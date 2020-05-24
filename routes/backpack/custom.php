<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => [
        config('backpack.base.web_middleware', 'web'),
        config('backpack.base.middleware_key', 'admin'),
    ],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('stats', 'StatsCrudController');
    Route::get('charts/yandex-metrika', 'Charts\YandexMetrikaChartController@response')->name('charts.yandex-metrika.index');
    Route::get('charts/yandex-direct', 'Charts\YandexDirectChartController@response')->name('charts.yandex-direct.index');
    Route::get('charts/yandex-new-user', 'Charts\YandexNewUserChartController@response')->name('charts.yandex-new-use.index');
    Route::get('charts/nadavi', 'Charts\NadaviChartController@response')->name('charts.nadavi.index');
    Route::get('charts/yandex-other', 'Charts\YandexOtherChartController@response')->name('charts.yandex-other.index');
}); // this should be the absolute last line of this file
