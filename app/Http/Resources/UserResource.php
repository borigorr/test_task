<?php

namespace App\Http\Resources;

use App\Dto\User\UserDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class UserResource extends JsonResource
{

    #[OA\Schema(
        schema: 'user',
        properties: [
            new OA\Property(
                property: "id",
                description: "id пользователя",
                type: "integer"
            ),
            new OA\Property(
                property: "email",
                description: "email",
                type: "string"
            ),
            new OA\Property(
                property: "name",
                description: "Имя пользователя",
                type: "string"
            )
        ],
        type: 'object'
    )]
        /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var $this UserResource|UserDto */
        return [
            "id" => $this->id,
            "email" => $this->email,
            "name" => $this->name
        ];
    }
}
