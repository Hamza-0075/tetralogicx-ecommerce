<?php

namespace App\Observers;

use App\Models\OrderItem;

class OrderItemObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(OrderItem $orderItem): void
    {
        $productVariation = $orderItem->variation;
        if ($productVariation && $productVariation->stock >= $orderItem->quantity) {
            $productVariation->decrement('stock', $orderItem->quantity);
        } elseif($productVariation && $productVariation->stock < $orderItem->quantity) {
            $orderItem->order->update(['status' => 'cancelled']);
        }
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
