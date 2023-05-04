<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// folisim acest controler ca sa facem swtch la limbile din site
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

// rute cadru didactic
Route::middleware(['auth:didactic'])->group(function(){
    Route::get('/acasa', [App\Http\Controllers\Didactic\HomeController::class, 'index'])->name('home');
});

Route::prefix('')->name('didactic.')->group(function(){
    Route::middleware(['auth:didactic'])->group(function(){
        Route::get('/pontaje/edit/{id_proiect}/{id_cd}/{luna?}/{an?}', 'App\Http\Controllers\Didactic\ControllerPontaje@edit')->name('pontaje.edit');
        Route::put('/pontaje/edit/{id_proiect}/{id_cd}/{luna?}/{an?}', 'App\Http\Controllers\Didactic\ControllerPontaje@update')->name('pontaje.update');
        Route::get('/pontaje/show/{id_proiect}/{id_cd}/{luna?}/{an?}', 'App\Http\Controllers\Didactic\ControllerPontaje@show')->name('pontaje.show');
        Route::get('/pontaje/list/{id_proiect}', 'App\Http\Controllers\Didactic\ControllerPontaje@index')->name('pontaje.view');
        Route::resource('cereri-granturi', App\Http\Controllers\Didactic\ControllerGranturiCereri::class);
        Route::post('/anexe-salvare', [App\Http\Controllers\Didactic\ControllerGranturiCereri::class, 'anexaStore'])->name('cereri-granturi.anexaStore');
        Route::get('/cereri-granturi/{id}/pdf',[App\Http\Controllers\Didactic\ControllerGranturiCereri::class,'grantCererePdf'])->name('cereri-granturi.pdf');
        Route::get('/proiecte', 'App\Http\Controllers\Didactic\ControllerProiecte@index')->name('proiecte.index');
        Route::get('/proiect/{id_proiect}', 'App\Http\Controllers\Didactic\ControllerProiecte@show')->name('proiecte.show');
        Route::get('/proiect/{id_proiect}/membri', 'App\Http\Controllers\Didactic\ControllerProiecte@membri')->name('proiecte.membri');
        Route::get('/granturi', 'App\Http\Controllers\Didactic\ControllerGranturi@index');
        Route::get('/granturi/{id_grant}', 'App\Http\Controllers\Didactic\ControllerGranturi@show');
    });
});

Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware(['guest:utilizator'])->group(function(){
        Route::view('/login','admin.login')->name('login');
        Route::post('/check',[AdminController::class,'check'])->name('check');
    });

    Route::middleware(['auth:utilizator'])->group(function(){
        Route::get('/', 'App\Http\Controllers\Admin\ControllerDashboard@index')->name('home');
        Route::post('/logout',[AdminController::class,'logout'])->name('logout');
        Route::resource('loguri', App\Http\Controllers\Admin\ControllerLoguri::class);
        Route::resource('utilizatori', App\Http\Controllers\Admin\ControllerUtilizatori::class);
        Route::resource('/pagini', App\Http\Controllers\Admin\ControllerPagini::class);
        Route::resource('admini', App\Http\Controllers\Admin\ControllerAdmini::class);
        Route::resource('cadre-didactice', App\Http\Controllers\Admin\ControllerCadreDidactice::class);
        Route::resource('cursuri-valutare', App\Http\Controllers\Admin\ControllerCursValutar::class);
        Route::resource('departamente', App\Http\Controllers\Admin\ControllerDepartamente::class);
        Route::resource('functii', App\Http\Controllers\Admin\ControllerFunctii::class);
        Route::resource('facultati', App\Http\Controllers\Admin\ControllerFacultati::class);
        Route::resource('universitati', App\Http\Controllers\Admin\ControllerUniversitati::class);
        Route::resource('limbi', App\Http\Controllers\Admin\ControllerLimbi::class);
        Route::resource('roluri', App\Http\Controllers\Admin\ControllerRoluri::class);
        Route::resource('notificari', App\Http\Controllers\Admin\ControllerNotificari::class);
        Route::get('/notificari-utilizator', 'App\Http\Controllers\Admin\ControllerNotificari@index_utilizator');
        Route::resource('meniuri', App\Http\Controllers\Admin\ControllerMeniuri::class);
        Route::delete('/elemente-meniu/{id}', 'App\Http\Controllers\Admin\ControllerMeniuri@stergereElementeMeniu');
        Route::resource('proiecte', App\Http\Controllers\Admin\ControllerProiecte::class);

        Route::get('/proiecte-membri/{id_proiect}', 'App\Http\Controllers\Admin\ControllerProiecteMembri@index')->name('proiecte-membri.index');
        Route::post('/proiecte-membri/{id_proiect}', 'App\Http\Controllers\Admin\ControllerProiecteMembri@store')->name('proiecte-membri.store');
        Route::get('/proiecte-membri/{id_proiect}/create', 'App\Http\Controllers\Admin\ControllerProiecteMembri@create')->name('proiecte-membri.create');
        Route::get('/proiecte-membri/{id_proiect}/{idProiectMembru}/edit', 'App\Http\Controllers\Admin\ControllerProiecteMembri@edit')->name('proiecte-membri.edit');
        Route::put('/proiecte-membri/{id_proiect}/{idProiectMembru}', 'App\Http\Controllers\Admin\ControllerProiecteMembri@update')->name('proiecte-membri.update');
        Route::delete('/proiecte-membri/{idProiectMembru}', 'App\Http\Controllers\Admin\ControllerProiecteMembri@destroy')->name('proiecte-membri.destroy');
        
        Route::get('/proiecte-entitati/{id_proiect}', 'App\Http\Controllers\Admin\ControllerProiecteEntitati@index')->name('proiecte-entitati.index');
        Route::post('/proiecte-entitati/{id_proiect}', 'App\Http\Controllers\Admin\ControllerProiecteEntitati@store')->name('proiecte-entitati.store');
        Route::get('/proiecte-entitati/{id_proiect}/create', 'App\Http\Controllers\Admin\ControllerProiecteEntitati@create')->name('proiecte-entitati.create');
        Route::get('/proiecte-entitati/{id_proiect}/{idProiectEntitate}/edit', 'App\Http\Controllers\Admin\ControllerProiecteEntitati@edit')->name('proiecte-entitati.edit');
        Route::put('/proiecte-entitati/{id_proiect}/{idProiectEntitate}', 'App\Http\Controllers\Admin\ControllerProiecteEntitati@update')->name('proiecte-entitati.update');
        Route::delete('/proiecte-entitati/{idProiectEntitate}', 'App\Http\Controllers\Admin\ControllerProiecteEntitati@destroy')->name('proiecte-entitati.destroy');
        
        Route::get('/proiecte-notificari/{id_proiect}', 'App\Http\Controllers\Admin\ControllerProiecteNotificari@index')->name('proiecte-notificari.index');
        Route::post('/proiecte-notificari/{id_proiect}', 'App\Http\Controllers\Admin\ControllerProiecteNotificari@store')->name('proiecte-notificari.store');
        Route::get('/proiecte-notificari/{id_proiect}/create', 'App\Http\Controllers\Admin\ControllerProiecteNotificari@create')->name('proiecte-notificari.create');
        Route::get('/proiecte-notificari/{id_proiect}/{idProiectNotificare}/edit', 'App\Http\Controllers\Admin\ControllerProiecteNotificari@edit')->name('proiecte-notificari.edit');
        Route::put('/proiecte-notificari/{id_proiect}/{idProiectNotificare}', 'App\Http\Controllers\Admin\ControllerProiecteNotificari@update')->name('proiecte-notificari.update');
        Route::delete('/proiecte-notificari/{idProiectNotificare}', 'App\Http\Controllers\Admin\ControllerProiecteNotificari@destroy')->name('proiecte-notificari.destroy');
       
        Route::resource('tipuri-proiecte', App\Http\Controllers\Admin\ControllerProiecteTipuri::class);
        Route::resource('categorii-cheltuieli', App\Http\Controllers\Admin\ControllerProiecteCategoriiCheltuieli::class);
        Route::resource('granturi-clasificari', App\Http\Controllers\Admin\ControllerGranturiClasificari::class);
        Route::resource('granturi', App\Http\Controllers\Admin\ControllerGranturi::class);

        Route::resource('granturi-cereri', App\Http\Controllers\Admin\ControllerGranturiCereri::class);
        Route::get('/granturi-cereri/{id}/pdf',[App\Http\Controllers\Admin\ControllerGranturiCereri::class,'grantCererePdf'])->name('cereri-granturi.pdf');
        Route::get('/granturi-mutari/{id_proiect}', 'App\Http\Controllers\Admin\ControllerGranturiMutari@index')->name('granturi-mutari.index');
        Route::post('/granturi-mutari/{id_proiect}', 'App\Http\Controllers\Admin\ControllerGranturiMutari@store')->name('granturi-mutari.store');
        Route::get('/granturi-mutari/{id_proiect}/create', 'App\Http\Controllers\Admin\ControllerGranturiMutari@create')->name('granturi-mutari.create');
        Route::get('/granturi-mutari/{id_proiect}/{idGrantMutare}/edit', 'App\Http\Controllers\Admin\ControllerGranturiMutari@edit')->name('granturi-mutari.edit');
        Route::put('/granturi-mutari/{id_proiect}/{idGrantMutare}', 'App\Http\Controllers\Admin\ControllerGranturiMutari@update')->name('granturi-mutari.update');
        Route::delete('granturi-mutari/{idGrantMutare}', 'App\Http\Controllers\Admin\ControllerGranturiMutari@destroy')->name('granturi-mutari.destroy');
    
    });
});

Route::prefix('ajax')->name('ajax.')->group(function(){
    Route::post('/ajaxCautaNumeUtilizator',['App\Http\Controllers\ControllerAjax','ajaxCautaNumeUtilizator']);
    Route::post('/ajaxMarcheazaNotificareCitita',['App\Http\Controllers\ControllerAjax','ajaxMarcheazaNotificareCitita']);
    Route::post('/ajaxAdaugaElemMeniu',['App\Http\Controllers\ControllerAjax','ajaxAdaugaElemMeniu']);
    Route::post('/ajaxIncarcareMeniuAdmin',['App\Http\Controllers\ControllerAjax','ajaxIncarcareMeniuAdmin']);
    Route::post('/ajaxUpdateElementMeniu',['App\Http\Controllers\ControllerAjax','ajaxUpdateElementMeniu']);
    Route::post('/ajaxUpdateOrdineMeniu',['App\Http\Controllers\ControllerAjax','ajaxUpdateOrdineMeniu']);
    Route::post('/ajaxCautareCadruDidactic',['App\Http\Controllers\ControllerAjax','ajaxCautareCadruDidactic']);
    Route::post('/ajaxCautareUniversitate',['App\Http\Controllers\ControllerAjax','ajaxCautareUniversitate']);
    Route::post('/ajaxPreluareCereriGranturiCD',['App\Http\Controllers\ControllerAjax','ajaxPreluareCereriGranturiCD']);
    Route::post('/ajaxCalculeazaValoriGranturi',['App\Http\Controllers\ControllerAjax','ajaxCalculeazaValoriGranturi']);
    Route::post('/ajaxGetSumaRamasaAutorGrant',['App\Http\Controllers\ControllerAjax','ajaxGetSumaRamasaAutorGrant']);

    // rute didactic
    Route::post('/ajaxValideazaPontaj',['App\Http\Controllers\ControllerAjax','ajaxValideazaPontaj']);
    Route::post('/ajaxStergereAtasamentAnexa',['App\Http\Controllers\ControllerAjax','ajaxStergereAtasamentAnexa']);
    Route::post('/ajaxStergereRandTabela',['App\Http\Controllers\ControllerAjax','ajaxStergereRandTabela']);

    // cadru didactic
    Route::post('/ajaxDeleteCerereInitiata',['App\Http\Controllers\ControllerAjax','ajaxDeleteCerereInitiata']);
});
Route::post('/upload',['App\Http\Controllers\ControllerAjax','upload'])->name('ckeditor.upload');


Route::get('routes', function () {
    $routeCollection = Route::getRoutes();

    echo "<table style='width:100%'>";
    echo "<tr>";
    echo "<td width='10%'><h4>HTTP Method</h4></td>";
    echo "<td width='10%'><h4>Route</h4></td>";
    echo "<td width='10%'><h4>Name</h4></td>";
    echo "<td width='70%'><h4>Corresponding Action</h4></td>";
    echo "</tr>";
    foreach ($routeCollection as $value) {
        echo "<tr>";
        echo "<td>" . $value->methods()[0] . "</td>";
        echo "<td>" . $value->uri() . "</td>";
        echo "<td>" . $value->getName() . "</td>";
        echo "<td>" . $value->getActionName() . "</td>";
        echo "</tr>";
    }
    echo "</table>";
});

