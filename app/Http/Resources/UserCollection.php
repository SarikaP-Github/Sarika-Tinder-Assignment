<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function (User $user) {
                return new UserResource($user);
            }),
            'meta' => [
                'total_users' => $this->collection->count(),
            ],
        ];
    }
}
