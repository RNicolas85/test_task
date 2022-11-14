<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class ResponseHelper
{
	protected $action;
	protected $code = 200;

	protected $defaultMessage = [
		'index' => [
			'200' => 'Resources retrieved successfully',
			'404' => 'Resource not found',
			'403' => 'Forbidden',
		],
		'show' => [
			'200' => 'Resource retrieved successfully',
			'404' => 'Resource not found',
			'403' => 'Forbidden',
		],
		'store' => [
			'201' => 'Resource created successfully',
			'403' => 'Forbidden',
		],
		'update' => [
			'200' => 'Resource updated successfully',
			'404' => 'Not found resource for updating',
			'403' => 'Forbidden',
		],
		'destroy' => [
			'200' => 'Resources deleted successfully',
			'404' => 'Not found resource for deleting',
			'403' => 'Forbidden',
		],
		'default' => [
			'200' => 'Successfully',
			'404' => 'Not found',
			'403' => 'Forbidden',
		]
	];


	public function __construct()
	{
		foreach ($this->defaultMessage as $key => $item) {
			$this->defaultMessage[$key]['403'] = "Forbidden";
			$this->defaultMessage[$key]['500'] = "Server error";
		}
		$actionName = Route::getCurrentRoute() !== null ? Route::getCurrentRoute()->getActionName() : 'default';
		$res = explode('@', $actionName);
		$this->action = end($res);
	}


	public function response($code = 200, $customResponse = [])
	{
		$this->code = $code === 0 ? 500 : $code; // to prevent "The HTTP status code 0 is not valid" exception

		$data = $this->defaultMessage['default'];
		if (($this->code >= 200) && ($this->code < 300)) {
			$res['success'] = true;
			$res['message'] = 'Success';
		} else {
			$res['success'] = false;
		}

		if (isset($this->defaultMessage[$this->action])) {
			$data = $this->defaultMessage[$this->action];
			if (isset($data[$this->code])) {
				$res['message'] = $data[$this->code];
			}
		}

		if (isset($customResponse['message'])) {
			$res['message'] = $customResponse['message'];
		}

		if (isset($customResponse['success'])) {
			$res['success'] = $customResponse['success'];
		}

		if (isset($customResponse['meta'])) {
			$res['meta'] = $customResponse['meta'];
		}

		if (isset($customResponse['other'])) {
			$res['other'] = $customResponse['other'];
		}

		if (isset($customResponse['data'])) {
			if (is_array($customResponse['data']) && isset($customResponse['data']['message']) && $customResponse['data']['message'] === "Unauthenticated.") {
			    $this->code = 401;
                $res['message'] = $customResponse['data']['message'];
            } else {
                $res['data'] = $customResponse['data'];
            }
		}

		return response()->json($res, $this->code);
	}
}
