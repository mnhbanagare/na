<?php

namespace App\Http\Controllers\Searcher;

/**
 * Search Api interface.
 *
 * @author Mahesh Hegde
 */
interface SearchApiInterface
{
    public function getPerPage();
    public function setPerPage($perPage);
    public function getPage();
    public function setPage($page);

    public function get($path, array $parameters = array(), array $requestHeaders = array());
}