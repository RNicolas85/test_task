<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Response method
     *
     * @param $code
     * @param null $res
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResp($code, $res = null)
    {
        $resp = new ResponseHelper();
        return $resp->response($code, $res);
    }
}
