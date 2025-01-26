<?php

namespace Modules\Product\Services;

use App\Exceptions\ValidationErrorsException;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Modules\Order\Models\Order;
use Modules\Product\Models\Builders\ProductBuilder;
use Modules\Product\Models\Product;
use Modules\Vendor\Helpers\VendorHelper;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Services\TransactionService;
use Modules\Wallet\Services\WalletService;

class PublicProductService
{
    public function index(array $filters = [])
    {
        return Product::query()
            ->latest()
            ->when(true, fn (ProductBuilder $b) => $b->handleFilters($filters)->withMinimalDetailsForVendor()->whereParentsNotDeleted())
            ->where('quantity', '>', 0)
            ->paginatedCollection();
    }

    public function show($id)
    {
        return Product::query()
            ->where('quantity', '>', 0)
            ->when(true, fn (ProductBuilder $b) => $b->withDetailsForVendor()->whereParentsNotDeleted())
            ->findOrFail($id);
    }

    /**
     * @throws ValidationErrorsException
     */
    public function order(array $data, $id)
    {
        $product = Product::query()
            ->where('quantity', '>', 0)
            ->findOrFail($id);

        $this->assertEnoughQuantity($data['quantity'], $product->quantity);
        $this->assertValidPrice($data['new_price'], $product->price);

        DB::transaction(function () use ($product, $data){
           $product->decrement('quantity', $data['quantity']);
           $order = Order::query()->create($data + [
                'product_id' => $product->id,
                'vendor_id' => VendorHelper::getUserVendor()->id,
                'original_price' => $product->price,
           ]);

           $walletService = new WalletService(
               app(Wallet::class),
               app(User::class),
               app(TransactionService::class)
           );

           //TODO transfer amount to inventory owner
           $walletService->deposit(
               $product->price * $data['quantity'],
               $product->inventoryOwner->user,
               $order->id,
               auth()->id(),
           );

           //TODO if there a profit for vendor, just make a transaction with it
            if($data['new_price'] - $product->price) {
                $walletService->deposit(
                    $data['new_price']  - $product->price * $data['quantity'],
                    auth()->user(),
                    $order->id,
                );
            }
        });
    }

    /**
     * @throws ValidationErrorsException
     */
    public function assertEnoughQuantity(int $requiredQuantity, int $existingQuantity)
    {
        if ($existingQuantity < $requiredQuantity) {
            throw new ValidationErrorsException([
                'quantity' => translate_word('not_enough_quantity')
            ]);
        }
    }

    /**
     * @throws ValidationErrorsException
     */
    private function assertValidPrice(float $newPrice, float $originalPrice)
    {
        if($newPrice < $originalPrice) {
            throw new ValidationErrorsException([
                'new_price' => translate_word('price_is_invalid')
            ]);
        }
    }
}
