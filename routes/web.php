<?php

use Illuminate\Support\Facades\Route;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('logout', 'UserController@logout');
Route::get('/email', function (){
    Mail:: to('sebastianj@rpwiktychy.local')->send(new TestMail());
    //return new TestMail();
});
Route::get('ad', 'AdController@getAdUserName')->name('komputery.getAdUserName');
Route::post('ad', 'AdController@getAdUserName')->name('komputery.getAdUserName');

Route::get('magazyny', 'MagazynController@index')->name('magazyny.index');

Route::get('komputery', 'KomputerController@index')->name('komputery.index')->middleware('auth');
Route::post('komputery', 'KomputerController@index')->name('komputery.index')->middleware('auth');

Route::post('komputery/activate/{id}', 'KomputerController@activate')->name('komputery.activate')->middleware('auth');
Route::post('komputery/disable/{id}',   'KomputerController@disable')->name('komputery.disable')->middleware('auth');

Route::get('komputery/otfile/{id}', 'KomputerController@downloadOtFile')->name('komputery.downloadOtFile')->middleware('auth');
Route::get('komputery/ftfile/{id}', 'KomputerController@downloadFtFile')->name('komputery.downloadOtFile')->middleware('auth');

Route::post('komputery/storeot/{id}', 'KomputerController@storeOtFile')->name('komputery.storeotfile')->middleware('auth');
Route::GET('komputery/storeot/{id}', 'KomputerController@storeOtFileGET')->name('komputery.storeotfileget')->middleware('auth');
Route::get('komputery/st/ot/{id}', 'KomputerController@storeOtFile')->name('komputery.storeotfile')->middleware('auth');
Route::get('komputery/st/fw/{id}', 'KomputerController@storeFwFile')->name('komputery.storefwfile')->middleware('auth');

Route::post('komputery/store', 'KomputerController@store')->name('komputery.store')->middleware('auth');
//Route::get('komputery/store', 'KomputerController@store')->name('komputery.store')->middleware('auth');
Route::get('komputery/editStep1/{id}', 'KomputerController@editStep1')->name('komputery.editStep1')->middleware('auth');
Route::post('komputery/editStep1/{id}', 'KomputerController@editStep1')->name('komputery.editStep1')->middleware('auth');
Route::get('komputery/editStep2/{id}', 'KomputerController@editStep2')->name('komputery.editStep2g')->middleware('auth');
Route::post('komputery/editStep2/{id}', 'KomputerController@editStep2')->name('komputery.editStep2p')->middleware('auth');
Route::get('komputery/updateOneCol/{id}', 'KomputerController@updateOneCol')->name('komputery.updateOneCol')->middleware('auth');
Route::post('komputery/updateoneCol/{id}', 'KomputerController@updateOneCol')->name('komputery.updateOneCol')->middleware('auth');
Route::get('komputery/delSoft/{id}', 'KomputerController@delSoft')->name('komputery.delSoft')->middleware('auth');
Route::post('komputery/delSoft/{id}', 'KomputerController@delSoft')->name('komputery.delSoft')->middleware('auth');
Route::get('komputery/addSoft/{id}', 'KomputerController@addSoft')->name('komputery.addSoft')->middleware('auth');
Route::post('komputery/addSoft/{id}', 'KomputerController@addSoft')->name('komputery.addSoft')->middleware('auth');
Route::get('komputery/addDev/{id}', 'KomputerController@addDev')->name('komputery.addDev')->middleware('auth');
Route::post('komputery/addDev/{id}', 'KomputerController@addDev')->name('komputery.addDev')->middleware('auth');
Route::get('komputery/delDev/{id}', 'KomputerController@delDev')->name('komputery.delDev')->middleware('auth');
Route::post('komputery/delDev/{id}', 'KomputerController@delDev')->name('komputery.delDev')->middleware('auth');
Route::get('komputery/update/{id}', 'KomputerController@update')->name('komputery.update')->middleware('auth');
Route::post('komputery/update/{id}', 'KomputerController@update')->name('komputery.update')->middleware('auth');
Route::post('komputery/addStep1', 'KomputerController@addStep1')->name('komputery.addStep1')->middleware('auth');
Route::get('komputery/addStep1', 'KomputerController@addStep1')->name('komputery.addStep1')->middleware('auth');
Route::post('komputery/addStep2', 'KomputerController@addStep2')->name('komputery.addStep2')->middleware('auth');
Route::get('komputery/addStep2', 'KomputerController@addStep2')->name('komputery.addStep2')->middleware('auth');

Route::get('komputery/{id}', 'KomputerController@show')->name('komputery.show');
Route::delete('komputery/{id}', 'KomputerController@destroy')->name('komputery.destroy')->middleware('auth');

Route::get('/monitory', 'MonitorController@index')->name('monitory.index')->middleware('auth');
Route::post('monitory/add', 'MonitorController@add')->name('monitory.add')->middleware('auth');
Route::get('monitory/add', 'MonitorController@add')->name('monitory.add')->middleware('auth');
Route::post('monitory/store', 'MonitorController@store')->name('monitory.store')->middleware('auth');
Route::get('monitory/store', 'MonitorController@store')->name('monitory.store')->middleware('auth');
Route::get('monitory/updateOneCol/{id}', 'MonitorController@updateOneCol')->name('monitory.updateOneCol')->middleware('auth');
Route::post('monitory/updateoneCol/{id}', 'MonitorController@updateOneCol')->name('monitory.updateOneCol')->middleware('auth');
Route::post('monitory/disable/{id}',   'MonitorController@disable')->name('monitory.disable')->middleware('auth');
Route::post('monitory/activate/{id}', 'MonitorController@activate')->name('monitory.activate')->middleware('auth');
Route::get('monitory/{id}', 'MonitorController@show')->name('monitory.show')->middleware('auth');
Route::delete('monitory/{id}', 'MonitorController@destroy')->name('monitory.destroy')->middleware('auth');

Route::get('/upsy', 'UPSController@index')->name('upsy.index')->middleware('auth');
Route::post('upsy/add', 'UPSController@add')->name('upsy.add')->middleware('auth');
Route::get('upsy/add', 'UPSController@add')->name('upsy.add')->middleware('auth');
Route::post('upsy/store', 'UPSController@store')->name('upsy.store')->middleware('auth');
Route::get('upsy/store', 'UPSController@store')->name('upsy.store')->middleware('auth');
Route::get('upsy/updateOneCol/{id}', 'UPSController@updateOneCol')->name('upsy.updateOneCol')->middleware('auth');
Route::post('upsy/updateoneCol/{id}', 'UPSController@updateOneCol')->name('upsy.updateOneCol')->middleware('auth');
Route::post('upsy/disable/{id}',   'UPSController@disable')->name('upsy.disable')->middleware('auth');
Route::post('upsy/activate/{id}', 'UPSController@activate')->name('upsy.activate')->middleware('auth');
Route::get('upsy/{id}', 'UPSController@show')->name('upsy.show')->middleware('auth');
Route::delete('upsy/{id}', 'UPSController@destroy')->name('upsy.destroy')->middleware('auth');

Route::get('/urzadzenia', 'UrzadzenieController@index')->name('urzadzenia.index')->middleware('auth');
Route::post('urzadzenia/add', 'UrzadzenieController@add')->name('urzadzenia.add')->middleware('auth');
Route::get('urzadzenia/add', 'UrzadzenieController@add')->name('urzadzenia.add')->middleware('auth');
Route::post('urzadzenia/store', 'UrzadzenieController@store')->name('urzadzenia.store')->middleware('auth');
Route::get('urzadzenia/store', 'UrzadzenieController@store')->name('urzadzenia.store')->middleware('auth');
Route::get('urzadzenia/updateOneCol/{id}', 'UrzadzenieController@updateOneCol')->name('urzadzenia.updateOneCol')->middleware('auth');
Route::post('urzadzenia/updateoneCol/{id}', 'UrzadzenieController@updateOneCol')->name('urzadzenia.updateOneCol')->middleware('auth');
Route::post('urzadzenia/disable/{id}',   'UrzadzenieController@disable')->name('urzadzenia.disable')->middleware('auth');
Route::post('urzadzenia/activate/{id}', 'UrzadzenieController@activate')->name('urzadzenia.activate')->middleware('auth');
Route::get('urzadzenia/{id}', 'UrzadzenieController@show')->name('urzadzenia.show')->middleware('auth');
Route::delete('urzadzenia/{id}', 'UrzadzenieController@destroy')->name('urzadzenia.destroy')->middleware('auth');
//Route::get('/monitory', 'MonitorController@add')->name('monitory.add')->middleware('auth');


Route::get('/uzytkownicy', 'UzytkownikController@index')->name('uzytkownicy.index')->middleware('auth');
Route::get('/uzytkownicy/add', 'UzytkownikController@add')->name('uzytkownicy.add')->middleware('auth');
Route::post('/uzytkownicy/add', 'UzytkownikController@add')->name('uzytkownicy.add')->middleware('auth');
Route::post('/uzytkownicy/store', 'UzytkownikController@store')->name('uzytkownicy.store')->middleware('auth');
Route::get('/uzytkownicy/disable/{id}', 'UzytkownikController@disable')->name('uzytkownicy.disable')->middleware('auth');
Route::post('/uzytkownicy/disable/{id}', 'UzytkownikController@disable')->name('uzytkownicy.disable')->middleware('auth');
Route::get('/uzytkownicy/activate/{id}', 'UzytkownikController@activate')->name('uzytkownicy.activate')->middleware('auth');
Route::post('/uzytkownicy/activate/{id}', 'UzytkownikController@activate')->name('uzytkownicy.activate')->middleware('auth');
Route::get('/uzytkownicy/updateOneCol/{id}', 'UzytkownikController@updateOneCol')->name('uzytkownicy.updateOneCol')->middleware('auth');
Route::post('/uzytkownicy/updateOneCol/{id}', 'UzytkownikController@updateOneCol')->name('uzytkownicy.updateOneCol')->middleware('auth');
Route::get('/uzytkownicy/{id}', 'UzytkownikController@show')->name('uzytkownicy.show')->middleware('auth');
Route::post('/uzytkownicy/{id}', 'UzytkownikController@show')->name('uzytkownicy.show')->middleware('auth');

Route::get('/dzialy', 'DzialController@index')->name('dzialy.index');
Route::get('/dzialy/add', 'DzialController@add')->name('dzialy.add')->middleware('auth');
Route::post('/dzialy/add', 'DzialController@add')->name('dzialy.add')->middleware('auth');
Route::get('/dzialy/store', 'DzialController@store')->name('dzialy.store')->middleware('auth');
Route::post('/dzialy/store', 'DzialController@store')->name('dzialy.store')->middleware('auth');
Route::get('/dzialy/disable/{id}', 'DzialController@disable')->name('dzialy.disable')->middleware('auth');
Route::post('/dzialy/disable/{id}', 'DzialController@disable')->name('dzialy.disable')->middleware('auth');
Route::get('/dzialy/delKomp/{id}', 'DzialController@delKomp')->name('dzialy.delKomp')->middleware('auth');
Route::post('/dzialy/delKomp/{id}', 'DzialController@delKomp')->name('dzialy.delKomp')->middleware('auth');
Route::get('/dzialy/addKomp/{id}', 'DzialController@addKomp')->name('dzialy.addKomp')->middleware('auth');
Route::post('/dzialy/addKomp/{id}', 'DzialController@addKomp')->name('dzialy.addKomp')->middleware('auth');
Route::get('/dzialy/delDev/{id}', 'DzialController@delDev')->name('dzialy.delDev')->middleware('auth');
Route::post('/dzialy/delDev/{id}', 'DzialController@delDev')->name('dzialy.delDev')->middleware('auth');
Route::get('/dzialy/addDev/{id}', 'DzialController@addDev')->name('dzialy.addDev')->middleware('auth');
Route::post('/dzialy/addDev/{id}', 'DzialController@addDev')->name('dzialy.addDev')->middleware('auth');
Route::get('/dzialy/delUser/{id}', 'DzialController@delUser')->name('dzialy.delUser')->middleware('auth');
Route::post('/dzialy/delUser/{id}', 'DzialController@delUser')->name('dzialy.delUser')->middleware('auth');
Route::get('/dzialy/addUser/{id}', 'DzialController@addUser')->name('dzialy.addUser')->middleware('auth');
Route::post('/dzialy/addOperatorWN/{id}', 'DzialController@addOperatorWN')->name('dzialy.addOperatorWN')->middleware('auth');
Route::get('/dzialy/addOperatorWN/{id}', 'DzialController@addOperatorWN')->name('dzialy.addOperatorWN')->middleware('auth');
Route::post('/dzialy/delOperatorWN/{id}', 'DzialController@delOperatorWN')->name('dzialy.delOperatorWN')->middleware('auth');
Route::get('/dzialy/delOperatorWN/{id}', 'DzialController@delOperatorWN')->name('dzialy.delOperatorWN')->middleware('auth');
Route::post('/dzialy/addUser/{id}', 'DzialController@addUser')->name('dzialy.addUser')->middleware('auth');
Route::get('/dzialy/activate/{id}', 'DzialController@activate')->name('dzialy.activate')->middleware('auth');
Route::post('/dzialy/activate/{id}', 'DzialController@activate')->name('dzialy.activate')->middleware('auth');
Route::get('/dzialy/updateOneCol/{id}', 'DzialController@updateOneCol')->name('dzialy.updateOneCol')->middleware('auth');
Route::post('/dzialy/updateOneCol/{id}', 'DzialController@updateOneCol')->name('dzialy.updateOneCol')->middleware('auth');
Route::get('/dzialy/{id}', 'DzialController@show')->name('dzialy.show');

Route::get('/programy', 'ProgramController@index')->name('programy.index');
Route::get('/programy/add', 'ProgramController@add')->name('programy.add')->middleware('auth');
Route::post('/programy/add', 'ProgramController@add')->name('programy.add')->middleware('auth');
Route::get('/programy/store', 'ProgramController@store')->name('programy.store')->middleware('auth');
Route::post('/programy/store', 'ProgramController@store')->name('programy.store')->middleware('auth');
Route::get('programy/updateOneCol/{id}', 'ProgramController@updateOneCol')->name('programy.updateOneCol')->middleware('auth');
Route::post('programy/updateOneCol/{id}', 'ProgramController@updateOneCol')->name('programy.updateOneCol')->middleware('auth');
Route::get('/programy/disable/{id}', 'ProgramController@disable')->name('programy.disable')->middleware('auth');
Route::post('/programy/disable/{id}', 'ProgramController@disable')->name('programy.disable')->middleware('auth');
Route::get('/programy/activate/{id}', 'ProgramController@activate')->name('programy.activate')->middleware('auth');
Route::post('/programy/activate/{id}', 'ProgramController@activate')->name('programy.activate')->middleware('auth');
Route::get('/programy/{id}', 'ProgramController@show')->name('programy.show');

#Route::get('/users', 'UserController@index');
#Route::get('/users/add', 'UserrController@add');
#Route::get('/users/{id}', 'UserController@show');

Route::get('/wnioski', 'WniosekController@index');
Route::get('/wnioski/addStep1', 'WniosekController@addStep1')->name('wnioski.addStep1');
Route::get('/wnioski/addStep2', 'WniosekController@addStep2')->name('wnioski.addStep2');
Route::get('/wnioski/addStep3', 'WniosekController@addStep3')->name('wnioski.addStep3');
Route::get('/wnioski/addStep4', 'WniosekController@addStep4')->name('wnioski.addStep4');
Route::get('/wnioski/addStep5', 'WniosekController@addStep5')->name('wnioski.addStep5');
Route::get('/wnioski/addStep6', 'WniosekController@addStep6')->name('wnioski.addStep6');
Route::get('/wnioski/addStep7', 'WniosekController@addStep7')->name('wnioski.addStep7');
Route::get('/wnioski/addStep8', 'WniosekController@addStep8')->name('wnioski.addStep8');
Route::get('/wnioski/addStep9', 'WniosekController@addStep9')->name('wnioski.addStep9');
Route::get('/wnioski/addStep10', 'WniosekController@addStep10')->name('wnioski.addStep10');
Route::get('/wnioski/addStep11', 'WniosekController@addStep11')->name('wnioski.addStep11');
Route::get('/wnioski/addStep12', 'WniosekController@addStep12')->name('wnioski.addStep12');
Route::post('/wnioski/addStep1', 'WniosekController@addStep1post')->name('wnioski.addStep1p');
Route::post('/wnioski/addStep2', 'WniosekController@addStep2post')->name('wnioski.addStep2p');
Route::post('/wnioski/addStep3', 'WniosekController@addStep3post')->name('wnioski.addStep3p');
Route::post('/wnioski/addStep4', 'WniosekController@addStep4post')->name('wnioski.addStep4p');
Route::post('/wnioski/addStep5', 'WniosekController@addStep5post')->name('wnioski.addStep5p');
Route::post('/wnioski/addStep6', 'WniosekController@addStep6post')->name('wnioski.addStep6p');
Route::post('/wnioski/addStep7', 'WniosekController@addStep7post')->name('wnioski.addStep7p');
Route::post('/wnioski/addStep8', 'WniosekController@addStep8post')->name('wnioski.addStep8p');
Route::post('/wnioski/addStep9', 'WniosekController@addStep9post')->name('wnioski.addStep9p');
Route::post('/wnioski/addStep10', 'WniosekController@addStep10post')->name('wnioski.addStep10p');
Route::post('/wnioski/addStep11', 'WniosekController@addStep11post')->name('wnioski.addStep11p');
Route::post('/wnioski/storeWniosek', 'WniosekController@storeWniosek')->name('wnioski.storeWniosek');
Route::get('/wnioski/{id}', 'WniosekController@show');

Route::get('/st', 'StController@index')->name('st.index')->middleware('auth');
Route::post('/st', 'StController@index')->name('st.index')->middleware('auth');


Route::post('/dealerzy/add', 'DealerController@add')->name('dealerzy.add')->middleware('auth');
Route::get('/dealerzy/add', 'DealerController@add')->name('dealerzy.add')->middleware('auth');
Route::post('/dealerzy/store', 'DealerController@store')->name('dealerzy.store')->middleware('auth');
Route::get('/dealerzy/store', 'DealerController@store')->name('dealerzy.store')->middleware('auth');
Route::post('dealerzy/activate/{id}', 'DealerController@activate')->name('dealerzy.activate')->middleware('auth');
Route::post('dealerzy/disable/{id}', 'DealerController@disable')->name('dealerzy.disable')->middleware('auth');
Route::post('/dealerzy/updateOneCol/[id}', 'DealerController@updateOneCol')->name('dealerzy.updateOneCol')->middleware('auth');
Route::get('/dealerzy/updateOneCol/{id}', 'DealerController@updateOneCol')->name('dealerzy.updateOneCol')->middleware('auth');
Route::post('/dealerzy/{id}', 'DealerController@show')->name('dealerzy.show')->middleware('auth');
Route::get('/dealerzy/{id}', 'DealerController@show')->name('dealerzy.show')->middleware('auth');

Route::post('/fw/add', 'FwController@add')->name('fw.add')->middleware('auth');
Route::get('/fw/add', 'FwController@add')->name('fw.add')->middleware('auth');
Route::post('/fw/store', 'FwController@store')->name('fw.store')->middleware('auth');
Route::get('/fw/store', 'FwController@store')->name('fw.store')->middleware('auth');
Route::get('/fw/fwfile/{id}', 'FwController@downloadFwFile')->name('fw.downloadFwFile')->middleware('auth');
Route::post('/fw/updateOneCol/[id}', 'FwController@updateOneCol')->name('fw.updateOneCol')->middleware('auth');
Route::get('/fw/updateOneCol/{id}', 'FwController@updateOneCol')->name('fw.updateOneCol')->middleware('auth');
Route::get('/ot/otfile/{id}', 'FwController@downloadFwFile')->name('fw.downloadFwFile')->middleware('auth');
Route::get('/fw/{id}', 'FwController@show')->name('fw.show')->middleware('auth');

Route::post('/ot/add', 'OtController@add')->name('ot.add')->middleware('auth');
Route::get('/ot/add', 'OtController@add')->name('ot.add')->middleware('auth');
Route::post('/ot/store', 'OtController@store')->name('ot.store')->middleware('auth');
Route::get('/ot/store', 'OtController@store')->name('ot.store')->middleware('auth');
Route::post('/ot/updateOneCol/[id}', 'OtController@updateOneCol')->name('ot.updateOneCol')->middleware('auth');
Route::get('/ot/updateOneCol/{id}', 'OtController@updateOneCol')->name('ot.updateOneCol')->middleware('auth');
Route::get('/ot/otfile/{id}', 'OtController@downloadOtFile')->name('ot.downloadOtFile')->middleware('auth');
Route::get('/ot/{id}', 'OtController@show')->name('ot.show')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
