<?php

namespace Modules\Order\Services;

use Illuminate\Support\Facades\DB;
use Modules\Cart\Exceptions\CartException;
use Modules\Cart\Models\Cart;
use Modules\Cart\Services\CartService;
use Modules\Order\Models\Order;

class ClientOrderService
{
    /**
     * @throws CartException
     */
    public function checkout(array $data, CartService $cartService)
    {
        $cartItems = Cart::query()
            ->where('user_id', auth()->id())
            ->with([
                'tileDetail.tile:id,price,name',
                'tileDetail.color',
                'tileDetail.tileTexture',
            ])
            ->get();

        if ($cartItems->isEmpty()) {
            CartException::emptyCart();
        }

        DB::transaction(function () use ($cartItems, $data, $cartService) {
            $orderItems = [];
            $total = 0;
            $order = Order::query()->create($data + ['total' => $total]);

            foreach ($cartItems as $item) {
                $subTotal = $item->quantity * $item->tileDetail->tile->price;
                $orderItems[] = [
                    'quantity' => $item->quantity,
                    'price' => $item->tileDetail->tile->price,
                    'sub_total' => $subTotal,
                    'name' => json_encode($item->tileDetail->tile->getTranslations('name')),
                    'color' => json_encode($item->tileDetail->color->getTranslations('name')),
                    'color_code' => $item->tileDetail->color->code,
                    'tile_texture' => json_encode($item->tileDetail->tileTexture->getTranslations('name')),
                    'order_id' => $order->id,
                ];

                $total += $subTotal;
            }

            $order->update(['total' => $total]);
            $order->items()->insert($orderItems);

            $cartService->clearCart();
        });
    }
}
