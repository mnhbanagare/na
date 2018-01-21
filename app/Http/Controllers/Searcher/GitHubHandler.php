<?php

namespace App\Http\Controllers\Searcher;

use App\Http\Controllers\Searcher\SearchAbstractController;
use GuzzleHttp;

class GitHubHandler extends SearchAbstractController
{

    const BASE_URL = "https://api.github.com";
    
    public function __construct()
    { 
    }


    public function codeSearch($query_term, $repo_name, $sort = 'updated', $order = 'desc'){

        // $q = "addClass+in:file+repo:jquery/jquery";
        //create the query term
        $q = $query_term."+in:file+repo:".$repo_name;

        $response = $this->_get('/search/code', array('q' => $q, 'sort' => $sort, 'order' => $order));

        return $this->formatResponse($response);

    }


    private function formatResponse($response){

        $result = array();
        $data = array();

        if(isset($response['total_count'])){
            $result['total_count'] = $response['total_count'];
        }

        // if(isset($response['incomplete_results'])){
        //     $result['incomplete_results'] = $response['incomplete_results'];
        // }

        foreach($response['items'] as $item){
            $data[] = array(
                'filename'=> $item['name'],
                'filepath'=> $item['path'],
                'repo_url'=> $item['repository']['url'],
                'owner' => $item['repository']['owner']['url']
            );
        }

        
        $result['items'] = $data;
        
        return $result;

    }




    

    /**
     * To Send GET request with query parameters.
     *
     * @param string $path - Request path.
     * @param array  $parameters - GET parameters.
     * @param array  $requestHeaders - Request Headers.
     *
     * @return array|string
     */
    protected function _get($path, array $parameters = array(), array $requestHeaders = array())
    {

        //create the path
        $path = $this::BASE_URL.$path;

        $response = $this->get($path,  $parameters , $requestHeaders);

        // $result = json_decode($response->getBody(), true);

        return $response;

    
    }







}
