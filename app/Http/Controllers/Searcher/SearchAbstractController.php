<?php

namespace App\Http\Controllers\Searcher;

use App\Http\Controllers\Searcher\SearchApiInterface;
use App\Exceptions\Searcher\SearchException;
use GuzzleHttp;

abstract class SearchAbstractController implements SearchApiInterface
{

    var $client;
   
    var $page;
  
    var $perPage;

    const USER_AGENT = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13";

    

    /**
    * Search Api by code.
    *
    */
    abstract function codeSearch($q, $repo_name ,$sort = 'updated', $order = 'desc');
    

    public function __construct(){

    }

    
    public function getPage()
    {
        return $this->page;
    }


    public function setPage($page)
    {
        $this->page = (null === $page ? $page : (int) $page);
        return $this;
    }
    

    public function getPerPage()
    {
        return $this->perPage;
    }
    
    
    
    public function setPerPage($perPage)
    {
        $this->perPage = (null === $perPage ? $perPage : (int) $perPage);
        return $this;
    }



    /**
     * Send a GET request with query parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     GET parameters.
     * @param array  $requestHeaders Request Headers.
     *
     * @return array|string
     */
    public function get($path, array $parameters = array(), array $requestHeaders = array())
    {
        if (null !== $this->page && !isset($parameters['page'])) {
            $parameters['page'] = $this->page;
        }
        if (null !== $this->perPage && !isset($parameters['per_page'])) {
            $parameters['per_page'] = $this->perPage;
        }
        
        if (count($parameters) > 0) {
            //$path .= '?'.http_build_query($parameters);
            $path .= '?';
            foreach($parameters as $key => $value){
                $path .= '&'.$key."=".$value;
            }
        }


        $client = new GuzzleHttp\Client;

        // echo $path;

        $headers = array('headers' => array('UserAgent'=> $this::USER_AGENT));

        $response = $client->get($path,$headers);

        return $this->getReponseBody($response);
    }


    public function getReponseBody($response)
    {
        if($response->getStatusCode()!=200){
            throw new SearchException(SearchException::$errors['HTTP_STATUS']['message'],SearchException::$errors['HTTP_STATUS']['code']);
        }

        $body = $response->getBody()->__toString();
        if (strpos($response->getHeaderLine('Content-Type'), 'application/json') === 0) {
            $content = json_decode($body, true);
            if (JSON_ERROR_NONE === json_last_error()) {
                return $content;
            }
        }
        return $body;
    }


}
