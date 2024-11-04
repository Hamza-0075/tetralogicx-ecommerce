<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Order;
use App\Models\OrderItem;
use App\Observers\ProductObserver;
use App\Observers\PaymentObserver;
use App\Observers\OrderItemObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        Product::observe(ProductObserver::class);
        OrderItem::observe(OrderItemObserver::class);
        Payment::observe(PaymentObserver::class);
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }
}
