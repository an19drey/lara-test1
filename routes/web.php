<?php

use Illuminate\Support\Facades\Route;
use \App\Models\Country as Country;
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

Route::get('/', function (\App\Models\Country $id) {
//    print_r($ttt);
//    die('aa');
//    print_r($test->id);
//    die('dd');
    return view('welcome');
});

Route::get('/country/{country}', function (Country $country) {
//    $country = \App\Models\Country::find($id);

    die($country->iso2);
//    print_r($test->id);
//    die('dd');
    return view('welcome');
});

