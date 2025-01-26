<?php

namespace Modules\InventoryOwner\Services;

use App\Exceptions\ValidationErrorsException;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Enums\AuthEnum;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Auth\Services\UserService;
use Modules\InventoryOwner\Contracts\InventoryOwnerContract;
use Modules\InventoryOwner\Models\InventoryOwner;
use Modules\Wallet\Database\factories\WalletFactory;
use Throwable;

readonly class AdminInventoryOwnerService
{
    public function __construct(
        private Model $model = new InventoryOwner(),
        private int $userType = UserTypeEnum::INVENTORY_OWNER,
        private string $errorKey = 'inventory_owner_id',
        private string $errorMessageKey = 'inventory_owner',
    ) {}

    public function index()
    {
        return $this->model::query()
            ->latest()
            ->when(true, fn (InventoryOwnerContract $b) => $b->withMinimalDetails()->searchByRelation('user', ['name', 'email']))
            ->paginatedCollection();
    }

    public function show($id)
    {
        return $this->model::query()
            ->when(true, fn (InventoryOwnerContract $b) => $b->withDetails())
            ->findOrFail($id);
    }

    /**
     * @throws ValidationErrorsException
     */
    public function store(array $data)
    {
        UserService::columnExists($data['email'], columnName: 'email', errorKey: 'email');

        DB::transaction(function () use ($data) {
            $user = User::create($data + [
                'type' => $this->userType,
                'status' => true,
                AuthEnum::VERIFIED_AT => now(),
            ]);

            $this->model::query()->create(['user_id' => $user->id]);
            WalletFactory::new()->create(['user_id' => $user->id]);
        });
    }

    /**
     * @throws Throwable
     * @throws ValidationErrorsException
     */
    public function update(array $data, $id)
    {
        $inventoryOwner = $this->model::query()->findOrFail($id);

        if (isset($data['email'])) {
            UserService::columnExists($data['email'], $inventoryOwner->user_id, 'email', 'email');
        }

        $inventoryOwner->user->update($data);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $inventoryOwner = $this->model::query()->findOrFail($id);
            $inventoryOwner->user->delete();
            $inventoryOwner->delete();
        });
    }

    /**
     * @throws ValidationErrorsException
     */
    public function exists($id)
    {
        $item = $this->model::query()->find($id);

        if (! $item) {
            throw new ValidationErrorsException([
                $this->errorKey => translate_error_message($this->errorMessageKey, 'not_exists'),
            ]);
        }

        return $item;
    }
}
