<?php

use App\Lib\Router;
use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->group(function () {
    Route::get('/', 'supportTicket')->name('ticket');
    Route::get('/new', 'openSupportTicket')->name('ticket.open');
    Route::post('/create', 'storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'replyTicket')->name('ticket.reply');
    Route::post('/close/{ticket}', 'closeTicket')->name('ticket.close');
    Route::get('/download/{ticket}', 'ticketDownload')->name('ticket.download');
});

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');


Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');
    Route::get('/blog', 'blog')->name('blog');
    Route::get('blog/{slug}/{id}', 'blogDetails')->name('blog.details');

    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');


    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');

    Route::get('get/cart/count', 'cartCount')->name('get.cart.count');
    Route::get('pizza/all', 'allPizzas')->name('pizza.all');
    Route::get('pizzas/category/{id}/{name}', 'pizzaByCategory')->name('pizza.category');

    Route::get('pizza/all/filtered', 'filterPizza')->name('pizza.filter');
    Route::get('pizza/detail/{id}/{name}', 'pizzaDetail')->name('pizza.detail');

    // track
    Route::get('track/order', 'trackOrder')->name('track.order');
    Route::get('track/order/{order_number}', 'getTrackOrder')->name('get.track.order');
});
