<?php

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
*/

Route::get('/', function () {
    return view('auth.login');
});


Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('user', 'UserController');

    Route::resource('permission', 'PermissionController');


    Route::get('/profile', 'UserController@profile')->name('user.profile');

    Route::post('/profile', 'UserController@postProfile')->name('user.postProfile');

    Route::get('/password/change', 'UserController@getPassword')->name('userGetPassword');

    Route::post('/password/change', 'UserController@postPassword')->name('userPostPassword');
});


Route::group(['middleware' => ['auth', 'role_or_permission:admin|create role|create permission']], function() {

    Route::resource('role', 'RoleController');

     //=============Countries================
     Route::get('/Countries', 'CountriesController@index')->name('Countries');
     Route::get("/getCountries", "CountriesController@getAll");
     Route::post('/getCountries/create', 'CountriesController@store');
     Route::get('/getCountries/edit/{id}', 'CountriesController@edit');
     Route::get('Countries/delete/{id}', 'CountriesController@delete');

    //=============States================
    Route::get('/States', 'StatesController@index')->name('States');
    Route::get("/getStates", "StatesController@getAll");
    Route::post('/getStates/create', 'StatesController@store');
    Route::get('/getStates/edit/{id}', 'StatesController@edit');
    Route::get('States/delete/{id}', 'StatesController@delete');

      //=============Cities================
      Route::get('/Cities', 'CitiesController@index')->name('Cities');
      Route::get("/getCities", "CitiesController@getAll");
      Route::post('/getCities/create', 'CitiesController@store');
      Route::get('/getCities/edit/{id}', 'CitiesController@edit');
      Route::get('Cities/delete/{id}', 'CitiesController@delete');

       //=============Cities================
       Route::get('/Departments', 'DepartmentsController@index')->name('Departments');
       Route::get("/getDepartments", "DepartmentsController@getAll");
       Route::post('/getDepartments/create', 'DepartmentsController@store');
       Route::get('/getDepartments/edit/{id}', 'DepartmentsController@edit');
       Route::get('Departments/delete/{id}', 'DepartmentsController@delete');

       
       //=============Employees================
       Route::get('/Employees', 'EmployeesController@index')->name('Employees');
       Route::get("/getEmployees", "EmployeesController@getAll");
       Route::post('/getEmployees/create', 'EmployeesController@store');
       Route::get('/getEmployees/edit/{id}', 'EmployeesController@edit');
       Route::get('Employees/delete/{id}', 'EmployeesController@delete');
});



Auth::routes();


//////////////////////////////// axios request

Route::get('/getAllPermission', 'PermissionController@getAllPermissions');
Route::post("/postRole", "RoleController@store");
Route::get("/getAllUsers", "UserController@getAll");
Route::get("/getAllRoles", "RoleController@getAll");
Route::get("/getAllPermissions", "PermissionController@getAll");

/////////////axios create user
Route::post('/account/create', 'UserController@store');
Route::put('/account/update/{id}', 'UserController@update');
Route::delete('/delete/user/{id}', 'UserController@delete');
Route::get('/search/user', 'UserController@search');
