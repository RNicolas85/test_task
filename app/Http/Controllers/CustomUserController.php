<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomUserRequest;
use App\Http\Resources\CustomUserResource;
use App\Models\CustomUser;
use App\SearchModels\CustomUserSearchModel;
use Illuminate\Http\Request;

class CustomUserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $search_model = new CustomUserSearchModel($request);
            $search_model->search();

            $res['meta'] = $search_model->getMeta();;
            $res['data'] = $search_model->getData();
            return $this->sendResp(200, $res);
        } catch (\Exception $e) {
            return $this->sendResp(500, ['data' => $e->getMessage()]);
        }
    }

    /**
     * @param CustomUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CustomUserRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $search_model = new CustomUserSearchModel($request->makeDto());
            $search_model->searchStore();

            return $this->sendResp(201, ['data' => $search_model->getData()]);
        } catch (\Exception $e) {
            return $this->sendResp(500, ['data' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $custom_user = CustomUser::findOrFail($id);

            if (!$custom_user) {
                return $this->sendResp(404, ['message' => 'User not found']);
            }

            $data = CustomUserResource::make($custom_user);

            $res['data'] = $data;
            return $this->sendResp(200, $res);
        } catch (\Exception $e) {
            return $this->sendResp(500, ['data' => $e->getMessage()]);
        }
    }

    /**
     * @param CustomUserRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CustomUserRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            $custom_user = CustomUser::findOrFail($id);

            if (!$custom_user) {
                return $this->sendResp(404, ['message' => 'User not found']);
            }

            $search_model = new CustomUserSearchModel($request->makeDto());
            $search_model->searchUpdate($custom_user);

            return $this->sendResp(202, ['data' => $search_model->getData()]);
        } catch (\Exception $e) {
            return $this->sendResp(500, ['data' => $e->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            $custom_user = CustomUser::findOrFail($id);
            if (!$custom_user) {
                return $this->sendResp(404, ['message' => 'User not found']);
            }

            $custom_user->delete();

            return $this->sendResp(202);
        } catch (\Exception $e) {
            return $this->sendResp(500, ['data' => $e->getMessage()]);
        }
    }
}
