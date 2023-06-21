<?php

namespace App\Providers;

use App\GeneralSetting;
use App\Language;
use Illuminate\Support\ServiceProvider;

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
        $activeTemplate = activeTemplate();

        $viewShare['general'] = GeneralSetting::first();
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language'] = Language::all();

        $viewShare['categories'] = \App\Category::with(['allSubcategories','products'=> function($q){
            return $q->whereHas('categories')->whereHas('brand');
        }, 'products.reviews', 'products.offer', 'products.offer.activeOffer'])->where('parent_id', null)->get();
        view()->share($viewShare);

        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'banned_users_count'           => \App\User::banned()->count(),
                'email_unverified_users_count' => \App\User::emailUnverified()->count(),
                'sms_unverified_users_count'   => \App\User::smsUnverified()->count(),
                'pending_ticket_count'         => \App\SupportTicket::whereIN('status', [0,2])->count(),
                'pending_deposits_count'       => \App\Deposit::pending()->count(),

                'pending_orders_count'          => \App\Order::where('status', 0)->where('payment_status',  '!=' ,0)->count(),
                'processing_orders_count'       => \App\Order::where('status', 1)->where('payment_status','!=', 0)->count(),
                'dispatched_orders_count'       => \App\Order::where('status', 2)->where('payment_status','!=', 0)->count()
            ]);
        });

        $pages  = $seo = \App\Frontend::where('data_keys', 'pages.element')->get();
        view()->composer([$activeTemplate.'partials.header', $activeTemplate.'partials.footer'], function ($view) use($pages){
            $view->with([
                'pages' => $pages
            ]);
        });





    }
}
