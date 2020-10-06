<?php

use App\Models\Meta;
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

Route::get('/bootstrap', 'BootstrapController@index');

Route::get('/', 'SquadController@pesquisaSquad');

Route::get('/processos', 'ProcessoController@getProcessosAtivosBySquad');

Route::get('/squadMetas', 'SquadController@squadMetas');

Route::get('/filtroProcessos', 'ProcessoController@filtroProcessos');

Route::get('/ordenaMetas', 'ProcessoController@ordenaMetas');

Route::post('/storeMeta', 'ProcessoController@storeMeta');
