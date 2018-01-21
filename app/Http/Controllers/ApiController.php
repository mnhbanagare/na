<?php

namespace App\Http\Controllers;

use Request;
use Response;
use Validator;
use App\Http\Controllers\Searcher\SearchProvider;


class ApiController extends Controller
{
    /**
	 * Contructor to add filters and auth
	 *
	 * @return Response
	 */

	public function __construct()
	{
		

    }
    





/**
 * Function for handling search on github code (u can impliment the handler if you want to extend to multiple providers)
 * Author Mahesh Hegde
 * 
 * @param mixed query_term - search tearm 
 * @param mixed repo_name - repository name
 * @param mixed sort - sorting coulum
 * @param mixed orderby - order by asc /desc
 * @param int page - page name 
 * @param int per_page per page 
 * 
 * @return search results
 * 
 */
	public function codeSearch(Request $request)
	{
		$response = array();

		try{

			$validator = Validator::make(Request::all(), [
				'query_term' => 'required',
				'repo_name' => 'required',
			]);
	
			//added the simple validator for handling request
			if ($validator->fails()) {
				return Response($validator->errors());
			}
	

			$page = Request::input('page',config('searcher.pagination.page'));
			$perPage = Request::input('per_page',config('searcher.pagination.per_page'));
			$sort = Request::input('per_page',config('searcher.pagination.per_page'));
	
			$query =  'addClass';
			$reponame =  'jquery/jquery';
	
			$data['query_term']= Request::input('query_term');
			$data['repo_name'] = Request::input('repo_name');
			$data['sort'] = Request::input('sort');
			$data['orderby'] = Request::input('orderby');
	
			$search = new SearchProvider($perPage,$page);
	
			$response = $search->search($data);

		}catch(\Exception $e){
			$response['code'] = $e->getCode();
			$response['message'] = $e->getMessage();
		}

		return Response::json($response);
		
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

}

