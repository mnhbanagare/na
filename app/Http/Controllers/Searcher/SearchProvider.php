<?php

namespace App\Http\Controllers\Searcher;

use App\Http\Controllers\Searcher\GitHubHandler;


class SearchProvider 
{
    var $search;
    const GITHIB_NAME = 'github';
    const GITLAB_NAME = 'gitlab';
    const BITBUCKET_NAME = 'bitbucket';

    public function __construct($perPage=null,$page=null){
        

       // create the class instance as per the config
       switch(config('searcher.provider.name')){

        case $this::GITHIB_NAME:
            $this->search = new GitHubHandler(); 
            break;

        case $this::GITHIB_NAME:     
            // $this->search = new GitLabHandler();  // not yet implimented , if required impimement it
            // break;
        
        case $this::BITBUCKET_NAME:     
            // $this->search = new BitBucketHandler();  // not yet implimented , if required impimement it
            // break;

        default: //set the defalut handler to github
            $this->search = new GitHubHandler(); 

       }


       //set the pagination 
       $this->search->setPage($page);
       $this->search->setPerPage($perPage);

       return $this->search;   
    }

    
    public function search($data){

        return $this->search->codeSearch($data['query_term'],$data['repo_name'],$data['sort'],$data['orderby']);
    }
    
}
