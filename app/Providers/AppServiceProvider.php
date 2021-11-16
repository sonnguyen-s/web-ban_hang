<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\ProductType;
use App\Models\Cart;
use Session;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Paginator::useBootstrap();
        view()->composer(['header','quantri_header','quantri_pages.quantri_sanpham'],function($view){
            $loai_sp=ProductType::all();          
            $view->with('loai_sp',$loai_sp);
        });
        view()->composer(['header','pages.dat_hang'],function($view){
            if(Session('cart')){
                $oldcart=Session::get('cart');
                $cart=new cart($oldcart);
                $view->with(['cart'=>Session::get('cart'),
                'product_cart'=>$cart->items,
                'totalPrice'=>$cart->totalPrice,
                'totalQty'=>$cart->totalQty]);
            }
        });
    }
}
//đây là project em đã lbạnvậy tthfì ngon rồi 