<?php

namespace Modules\Markable\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Markable\Helpers\FavoriteHelper;
use Modules\Markable\Http\Requests\FavoriteToggleRequest;
use Modules\Product\Models\Product;
use Modules\Vendor\Models\Vendor;

class FavoriteController extends Controller
{
    use HttpResponse;

    public static array $allowedTypes = [
        'product' => Product::class,
        'vendor' => Vendor::class,
    ];

    public static array $hasStatus = [
        'product' => true,
    ];

    public function __invoke(FavoriteToggleRequest $request)
    {
        $modelType = $request->input('model_type');
        $modelID = $request->input('model_id');
        $errors = [];

        $modelObject = (static::$allowedTypes[$modelType])::query()
            ->whereId($modelID)
            ->when(isset(static::$hasStatus[$modelType]), fn ($query) => $query->whereStatus(true))
            ->firstOrFail();

        if ($modelObject) {
            FavoriteHelper::model()::toggle($modelObject, auth()->user());

            return $this->okResponse(
                message: translate_success_message('model', 'toggled')
            );
        }

        return $this->validationErrorsResponse($errors);
    }
}
