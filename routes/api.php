<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/**
 * Route for handling search on github code (u can impliment the handler if you want to extend to multiple providers)
 * Author Mahesh Hegde
 * 
 * @param mixed query_term - search tearm 
 * @param mixed repo_name - repository name
 * @param mixed sort - sorting coulum
 * @param mixed orderby - order by asc /desc
 * @param int page - page name 
 * @param int per_page per page 
 * 
 */
Route::get('/search', 'ApiController@codeSearch');
Route::get('/search/code', 'ApiController@codeSearch');
