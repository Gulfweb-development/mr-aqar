<?php


use App\Models\Advertising;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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


////////////// index page
Route::get('/','MainController@index')->name('Main.index');
Route::get('/aboutus','MainController@aboutus')->name('Main.aboutus');
Route::get('/contact','MessageController@create')->name('Message.create');
Route::post('/contact', 'MessageController@store')->name('message.store');
Route::get('required', function() {return view('site.pages.main', ['required_for_rent' => true]);})->name('required_for_rent');

////////////// companies
Route::group(['prefix' => 'companies'] , function (){
    Route::get('/', 'CompanyController@index')->name('companies');
    Route::get('/new', 'CompanyController@new')->middleware(['auth', 'become_company'])->name('companies.new');
    Route::post('/store', 'CompanyController@store')->middleware(['auth', 'become_company'])->name('companies.store');
    Route::post('/downgrade', 'CompanyController@downgrade')->middleware(['auth'])->name('companies.downgrade');
    Route::put('/', 'CompanyController@update')->middleware(['auth'])->name('companies.update');
    Route::get('/{phone}/{name?}/advertise', 'CompanyController@new')->name('companies.show');
});

///////////// auth
Route::prefix('')->group(function (){
    $controller2='UserController@';
    Route::post("/sendSmsCode",$controller2.'sendSmsCode');
    Route::post("/verifyUserBySmsCode",$controller2.'verifyUserBySmsCode');
    Route::get("/get-credit-user",$controller2.'isValidRegisterAdvertising')->middleware('auth');
    Route::post("/user/profile",$controller2.'userProfile')->name('site.show.user');
    Route::post("/user/advertises",$controller2.'getAdvertises');
});


///////////// profile
Route::group(['middleware'=>['auth']],function (){
    Route::get('/profile','MainController@profile')->name('Main.profile');
    Route::post('/edituser', 'UserController@editUser')->name('User.editUser');
    Route::get('/changepassword', 'MainController@changePassword')->name('Main.changePassword');
    Route::post('/changepassword', 'UserController@changePassword')->name('User.changePassword');
    Route::get('/wishlist', 'MainController@wishList')->name('Main.wishList');
    // Route::get('/paymenthistory', 'MainController@paymentHistory')->name('Main.paymentHistory');
    Route::get('/paymenthistory', function () {return abort(404);})->name('Main.paymentHistory');
	Route::get('/paymentdetails/{paymentid}', 'MainController@paymentDetails')->name('Main.paymentDetails');
    Route::get('/myads', 'MainController@myAds')->name('Main.myAds');
    Route::delete('/ad/delete/{advertising}', 'AdvertisingController@delete')->name('Advertising.delete');
    Route::get('/buypackage', 'MainController@buyPackage')->name('Main.buyPackage');
    Route::post('/buypackageorcredit', 'MainController@buyPackageOrCredit')->name('Main.buyPackageOrCredit');
});


/////////////payment result
Route::get("/payment-result",'MainController@paymentResult')->name('callback');





///////////////// premium ads
Route::group(['prefix' => 'cat/premiums'] , function (){
    Route::get('/', 'AdvertisingController@premiums')->name('Advertising.premiums');
    Route::get('/latest', 'AdvertisingController@latestPremiums')->name('Advertising.latestPremiums');
    Route::get('/highestprice', 'AdvertisingController@highestPricePremiums')->name('Advertising.highestPricePremiums');
    Route::get('/lowestprice', 'AdvertisingController@lowestPricePremiums')->name('Advertising.lowestPricePremiums');
    Route::get('/mostvisited', 'AdvertisingController@mostVisitedPremiums')->name('Advertising.mostVisitedPremiums');
});


//////////////// show and search ads
Route::get('/ad/{advertising}', 'AdvertisingController@show')->name('Main.showAd');
Route::get('/search', 'AdvertisingController@search')->name('site.search');


//////////// archive advertising
Route::prefix('archive-advertising')->group(function (){
    $controller='ArchiveAdvertisingController@';
    Route::post('/add', $controller.'store');
    Route::post('/remove', $controller.'destroy');
});


/////////////user archive
Route::prefix('advertising')->group(function (){
    $controller='AdvertisingController@';
    Route::get('{hashNumber}/details', $controller.'details')->name('site.ad.detail');

    Route::get('/create', $controller.'create')->middleware('auth')->name('site.advertising.create');
    Route::POST('/ajax_file_upload_handler', $controller.'ajax_file_upload_handler')->middleware('auth')->name('site.advertising.ajax_file_upload_handler');
    Route::post('/store', $controller.'store')->middleware('auth')->name('site.advertising.store');;
    Route::get('{hashNumber}/edit', $controller.'edit')->name('site.advertising.edit')->middleware('auth');
    Route::post('upgrade_premium', $controller.'upgrade_premium')->name('site.advertising.upgrade_premium')->middleware('auth');
    Route::post('auto_extend', $controller.'auto_extend')->name('site.advertising.auto_extend')->middleware('auth');
    Route::PUT('/update', $controller.'updateAdvertising')->name('site.advertising.updateAdvertising')->middleware('auth');
    Route::post('/destroy', $controller.'destroyAdvertising')->name('site.advertising.destroy')->middleware('auth');
    Route::get('/{hashNumber}/location', $controller.'advertisingLocation')->name('site.advertising.location');
    Route::get('/{hashNumber}/direction', $controller.'advertisingDirection')->name('site.advertising.direction');

});




Route::get("/cities",'AdvertisingController@getCities');
Route::post("/areas",'AdvertisingController@getAreas');
Route::post("/venuetypes",'AdvertisingController@getVenueTypes');
Route::get("/get-all-areas",'MainController@getAreas');
Route::post("/upload-video",'AdvertisingController@simpleSaveVideo');
Route::get("/venuetypestest",'AdvertisingController@getVenueTypes');

//reset forgot password

Route::get('passwords/reset', 'UserController@showLinkRequestForm')->name('password.reset');
Route::post('passwords/email', 'UserController@sendResetLinkEmail')->name('password.email');
Route::get('passwords/reset/{token}', 'UserController@showResetForm')->name('password.reset');
Route::post('passwords/reset/{token}', 'UserController@resets')->name('password.token');

// In routes/web.php
Route::feeds();


Route::get("/test",function (){
    echo bcrypt(12345678);
})->name("test");


// Route::get('/images/main/profile.jpg')->name('user-image');
Route::get('/asset/images/others/user.jpg')->name('image.user');
Route::get('/asset/images/others/default-bg.png')->name('image.upgrade-company');
Route::get('/images/main/panel/noimage.png')->name('image.noimage');
Route::get('/images/main/panel/noimagebig.png')->name('image.noimagebig');

Route::get('/{phone?}/{name?}', 'CompanyController@show')->name('companies.info');
