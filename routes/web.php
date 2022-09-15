<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
/*/
Route::prefix('{locale}')
    ->where(['locale'=>('en|ar')])->middleware(['check_lng'])->group(function (){
    Auth::routes();
});
Route::any("/payment-result",'Api\V1\PaymentController@paymentResult');
//Route::redirect("/",'login');
Route::get('/testP',function (){
    \App\Http\Controllers\Auth\RegisterController::sendOtp('test' , '96566444569');
   return view("test");
});


Route::redirect('/', app()->getLocale().'/');


Route::group(['middleware'=>['auth','Admin'],'prefix'=>"admin",'namespace'=>"Panel"],function (){


    //advertising

    Route::get('advertising-list/individual', 'AdvertisingController@index')->name('advertising.index');
    Route::get('advertising-list/companies', 'AdvertisingController@index')->name('advertising.indexCompanies');
    Route::get('advertising/create', 'AdvertisingController@createForm')->name('advertising.createForm');
    Route::post('advertising/create', 'AdvertisingController@create')->name('advertising.create');
    Route::get('advertising/{id}', 'AdvertisingController@getDetails')->name('advertising.details');
    Route::get('advertising/view/{id}', 'AdvertisingController@view')->name('advertising.view');
    Route::delete('advertising/delete/{advertising}', 'AdvertisingController@destroy')->name('advertising.destroy');
    Route::post('advertising/accept/{id}', 'AdvertisingController@accept')->name('advertising.accept');
    Route::post('advertising/update', 'AdvertisingController@update')->name('advertising.update');


    //packages
    Route::get('packages', 'PackagesController@index')->name('packages.index');
    Route::get('packages/company', 'PackagesController@index')->name('packages.company.index');
    Route::get('packages/individual', 'PackagesController@index')->name('packages.individual.index');

    Route::get('staticPackages', 'StaticPackagesController@index')->name('staticPackages.index');
    Route::get('staticPackages/company', 'StaticPackagesController@index')->name('staticPackages.company.index');
    Route::get('staticPackages/individual', 'StaticPackagesController@index')->name('staticPackages.individual.index');


    Route::resource('staticPackages', 'StaticPackagesController', ['except' => 'show']);
    Route::resource('packages', 'PackagesController', ['except' => 'show']);





    //payments

    Route::get('payments', 'PaymentsController@index')->name('payments.index');
    Route::get('payments/{id}', 'PaymentsController@showDetail')->name('payments.showDetail');
    Route::get('payments/user/{id}', 'PaymentsController@userPayment')->name('payments.userPayment');
    Route::post('paymenthistory/accept/{id}', 'PaymentsController@acceptPayment')->name('paymentHistory.accept');

    Route::get('balanceHistory/user/{id}', 'MembersController@balanceHistory')->name('members.balanceHistory');



    Route::get('messages', 'MessageController@index')->name('messages.index');



    //reports
    Route::get('reports', 'ReportsController@index')->name('reports.index');


    Route::get('profile', 'ProfileController@getProfile')->name('getProfile');
    Route::get('/changeLocale/{locale}', 'DashboardController@changeLocale')->name('changeLocale');

    Route::get("dashboard","DashboardController@dashboard")->name("dashboard");
    Route::get("/dashboard/charts", "DashboardController@charts")->name("charts");
    Route::get("/changeLocale/{locale}", "DashboardController@changeLocale")->name("changeLocale");
    Route::get('/dashboardInfo','DashboardController@getDashboardInfo')->name('dashboardInfo');


    //users
    Route::resource('administrators', 'AdministratorController', ['except' => 'show']);

    Route::resource('members', 'MembersController');
    Route::post("members-verify","MembersController@setVerify")->name("members.setVerify");
    Route::get("members-verify/{id}","MembersController@verify")->name("members.verify");

    Route::get('members-individual', 'MembersController@index')->name("members.individual");
    Route::get('members-company', 'MembersController@index')->name("members.company");

    Route::get('members-not-verified-individual', 'MembersController@notActiveMembers')->name("members.notActiveIndividual");
    Route::get('members-not-verified-company', 'MembersController@notActiveMembers')->name("members.notActiveCompany");

    Route::get('members-advertising-list/{userId}', 'MembersController@advertisingList')->name("members.advertisingList");

    Route::get('members/show/{id}', 'MembersController@show')->name("members.show");

    //settings
    Route::get('settings', 'SettingController@index')->name('settings.index');
    // Route::get('settings/invalid-keywords', 'SettingController@invalidKeywords')->name('settings.invalidKeywords');
    Route::get('settings/invalid-keywords', function() {return abort(404);})->name('settings.invalidKeywords');
    Route::post('settings/update-invalid-keywords', 'SettingController@updateInvalidKeywords')->name('settings.updateInvalidKeywords');
    Route::post('settings/createAjax', 'SettingController@createAjax')->name('createAjax');
    Route::post('settings/updateAjax', 'SettingController@updateAjax')->name('updateAjax');
    Route::post('settings/removeAjax', 'SettingController@removeAjax')->name('removeAjax');


    //city
    Route::get("city","CityAndAreaController@city")->name("cities");
    Route::post('city/store', 'CityAndAreaController@storeCity')->name('city.store');
    Route::post('city/update', 'CityAndAreaController@updateCity')->name('city.update');
    Route::delete('city/destroy/{country}', 'CityAndAreaController@destroyCity')->name('city.destroy');

    //areas
    Route::get("area","CityAndAreaController@area")->name("areas");
    Route::post('areas/store', 'CityAndAreaController@storeArea')->name('areas.store');
    Route::post('areas/update', 'CityAndAreaController@updateArea')->name('areas.update');
    Route::delete('areas/destroy/{area}', 'CityAndAreaController@destroyArea')->name('areas.destroy');

    //Amenties
    Route::get("amenties","SettingController@amenties")->name("amenties");
    Route::post('amenties/store', 'SettingController@storeAmenties')->name('amenties.store');
    Route::post('amenties/update', 'SettingController@updateAmenties')->name('amenties.update');
    Route::delete('amenties/destroy/{amenties}', 'SettingController@destroyAmenties')->name('amenties.destroy');


    //Venue Type
    Route::get("venue-type","SettingController@venueType")->name("venueType");
    Route::get("getVenueTypeByType/{id}","SettingController@getVenueTypeByType")->name("getVenueTYpeByType");
    Route::post('venue-type/store', 'SettingController@storeVenueType')->name('venueType.store');
    Route::post('venue-type/update', 'SettingController@updateVenueType')->name('venueType.update');
    Route::delete('venue-type/destroy/{type}', 'SettingController@destroyVenueType')->name('venueType.destroy');



});
// In routes/web.php
Route::feeds();

