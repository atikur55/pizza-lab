<?php

namespace App\Providers;

use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Order;
use App\Models\Page;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Pagination\Paginator;
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
        $activeTemplate                  = activeTemplate();
        $general                         = GeneralSetting::first();
        $viewShare['general']            = $general;
        $viewShare['activeTemplate']     = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language']           = Language::all();
        $viewShare['pages']              = Page::where('tempname', $activeTemplate)->where('is_default', 0)->get();
        $viewShare['emptyMessage']       = 'No data found';
        view()->share($viewShare);

        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'bannedUsersCount'              => User::banned()->count(),
                'emailUnverifiedUsersCount'     => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'    => User::mobileUnverified()->count(),
                'pendingTicketCount'            => SupportTicket::whereIN('status', [0, 2])->count(),
                'pendingDepositsCount'          => Deposit::pending()->count(),
                'pending_order_count'           => Order::pending()->where('payment_status', '!=', 0)->whereHas('deposit', function ($query) {
                    $query->where('status', '!=', 2);
                })->count(),
            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications' => AdminNotification::where('read_status', 0)->with('user')->orderBy('id', 'desc')->get(),
                'adminNotificationCount' => AdminNotification::where('read_status', 0)->count(),
            ]);
        });

        view()->composer('partials.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        if ($general->force_ssl) {
            \URL::forceScheme('https');
        }

        Paginator::useBootstrapFour();
    }
}
