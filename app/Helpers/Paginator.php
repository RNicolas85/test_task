<?php


namespace App\Helpers;


class Paginator
{

    /**
     * @param $request
     * @param $total
     * @return \stdClass
     */
    public static function makePaginationData($request, $total)
    {
        $maxPerPage = 5000;
        $minPerPage = 5;
        $defaultPerPage = 20;
        $perPage = $request->perPage ?: $defaultPerPage;
        $perPage = intval($perPage);
        if (intval($perPage) > intval($maxPerPage)) {
            $perPage = $maxPerPage;
        }
        if ($perPage <= $minPerPage) {
            $perPage = $minPerPage;
        }
        $pages = ceil($total / $perPage);
        $page = $request->page ? intval($request->page) : 1;
        if ($page < 1) {
            $page = 1;
        } else if ($page > $pages) {
            $page = $pages;
        }
        $r = new \stdClass();
        $r->total = $total;
        $r->page = $page;
        $r->pages = $pages;
        $r->perPage = $perPage;
        return $r;
    }
}
