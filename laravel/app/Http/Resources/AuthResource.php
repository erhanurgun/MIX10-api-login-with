<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $tokenCreated = $this->createToken('authToken');
        return [
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'password' => '',
                'created_at' => Carbon::parse($this->created_at)->format('d.m.Y H:i:s'),
            ],
            'token' => [
                'type' => 'Bearer',
                'access_key' => $tokenCreated->accessToken,
                'expires_at' => Carbon::parse($tokenCreated->token->expires_at)->format('d.m.Y H:i:s'),
            ]
        ];
    }
}
