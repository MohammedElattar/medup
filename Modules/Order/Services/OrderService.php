<?php

namespace Modules\Order\Services;

use App\Exceptions\ValidationErrorsException;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Modules\Course\Models\Builders\CourseBuilder;
use Modules\Course\Models\Course;
use Modules\FcmNotification\Enums\NotificationTypeEnum;
use Modules\FcmNotification\Notifications\FcmNotification;
use Modules\Library\Models\Builders\LibraryBuilder;
use Modules\Library\Models\Library;
use Modules\Order\Exceptions\OrderException;
use Modules\Order\Models\Order;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Services\TransactionService;
use Modules\Wallet\Services\WalletService;

class OrderService
{
    private function baseQuery()
    {
        return Order::query()
            ->where('user_id', auth()->id())
            ->with([
                'orderable' => function(MorphTo $morphTo) {
                    $morphTo->constrain([
                        Course::class => function (CourseBuilder $query) {
                            $query->withMinimalDetailsForOrders();
                        },
                        Library::class => function (LibraryBuilder $query) {
                            $query->withMinimalDetailsForOrders();
                        },
                    ]);
                }
            ]);
    }
    public function index()
    {
        return $this->baseQuery()->latest()->paginatedCollection();
    }

    public function show($id)
    {
        return $this->baseQuery()->findOrFail($id);
    }

    public function store(array $data)
    {
        $this->assertPurchasedBefore($data['type'], $data['id']);

        $model = $this->getOrderableModel($data);

        $order = DB::transaction(function() use ($data, $model){
            $this->transferMoney($model);

            return Order::query()->create([
                'user_id' => auth()->id(),
                'orderable_type' => $this->getModel($data['type']),
                'orderable_id' => $data['id'],
                'price' => $model->price,
            ]);
        });

        $this->orderCreatedNotification($model, $data);

        return $this->show($order->id);
    }

    public function review(array $data, $id)
    {
        $order = Order::query()
            ->where('user_id', auth()->id())
            ->where('reviewed', false)
            ->findOrFail($id);

        DB::transaction(fn() => $order->review($data));
    }
    private function getModel(string $type)
    {
        return [
            'course' => Course::class,
            'library' => Library::class,
        ][$type];
    }

    /**
     * @throws ValidationErrorsException
     */
    private function assertPurchasedBefore(string $type, int $id)
    {
        $exists = Order::query()
            ->where('user_id', auth()->id())
            ->where('orderable_type', $this->getModel($type))
            ->where('orderable_id', $id)
            ->exists();

        if($exists) {
            throw new ValidationErrorsException([
                'id' => translate_word('item_purchased_before'),
            ]);
        }
    }

    private function getOrderableModel(array $data)
    {
        $model = $this->getModel($data['type'])::query()
            ->where('id', $data['id'])
            ->when($data['type'] == 'library', fn($q) => $q->where('status', true))
            ->first();

        if(! $model) {
            throw new ValidationErrorsException([
                'id' => translate_error_message('model', 'not_exists'),
            ]);
        }

        return $model;
    }

    private function transferMoney(Model $orderable)
    {
        try{
            ( new WalletService(
                app(Wallet::class),
                app(User::class),
                app(TransactionService::class),
            ))->transfer(
                auth()->user(),
                $orderable->expert->user,
                $orderable->price,
                'Order for ' . $orderable->name,
            );
        } catch(ValidationErrorsException $e) {
            $errors = $e->getErrors();
            $firstKey = array_key_first($errors);
            throw new OrderException($e->getErrors()[$firstKey], 400);
        }
    }

    private function orderCreatedNotification(Model $model, array $data)
    {
        Notification::send($model->expert->user, new FcmNotification(
            'order_created_title',
            'order_created_body',
            additionalData: [
                'type' => NotificationTypeEnum::ORDER_CREATED,
                'id' => $data['id'],
            ],shouldTranslate: [
            'title' => true,
            'body' => true,
        ],translatedAttributes: [
            'name' => $model->name,
        ]
        ));
    }
}
