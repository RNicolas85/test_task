<?php

namespace App\SearchModels;

use App\Helpers\Paginator;
use App\Http\Resources\CustomUserResource;
use App\Models\CustomUser;

class CustomUserSearchModel
{
    use BaseSearchTrait;

    /**
     * @return void
     */
    public function search(): void
    {
        $custom_users = CustomUser::all();

        $this->_meta = Paginator::makePaginationData($this->request, $custom_users->count());
        $custom_users = $custom_users
            ->skip(($this->_meta->page - 1) * $this->_meta->perPage)
            ->take($this->_meta->perPage);

        $this->_data = CustomUserResource::collection($custom_users);
    }

    /**
     * @return void
     */
    public function searchStore(): void
    {
        $custom_user = CustomUser::create([
            'name' => $this->request->name,
            'email' => $this->request->email,
            'phone' => $this->request->phone
        ]);

        $this->_data = CustomUserResource::make($custom_user);
    }

    /**
     * @param $custom_user
     * @return void
     */
    public function searchUpdate($custom_user): void
    {
        $custom_user->name = $this->request->name;
        $custom_user->email = $this->request->email;
        $custom_user->phone = $this->request->phone;
        $custom_user->save();

        $this->_data = CustomUserResource::make($custom_user);
    }
}
