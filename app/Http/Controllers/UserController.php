<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceContract;
use App\Dto\User\UserDto;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceContract $userService,
    )
    {
    }

    #[OA\Get(
        path: "/api/users/",
        summary: "Список пользователей",
        security: [
            [
                "bearerAuth" => []
            ]
        ],
        tags: ["Users"],
        parameters: [
            new OA\Parameter(
                parameter: "page",
                name: "page",
                description: "Страница",
                in: "query",
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            type: "array", items: new OA\Items(
                                ref: "#/components/schemas/user",
                            )
                        )
                    ],

                )
            ),
        ]
    )]
    public function index(Request $request)
    {
        $page = $request->get("page", 1);
        $userList = $this->userService->getList($page);
        $paginator = new LengthAwarePaginator(
            items: $userList->list,
            total: $userList->total,
            perPage: $userList->perPage,
            currentPage: $userList->currentPage
        );
        return UserResource::collection($paginator);
    }

    #[OA\Get(
        path: "/api/users/{id}",
        summary: "Полученеи пользователя по id",
        security: [
            [
                "bearerAuth" => []
            ]
        ],
        tags: ["Users"],
        parameters: [
            new OA\Parameter(
                parameter: "id",
                name: "id",
                description: "id пользователя",
                in: "path",
                required: true,
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/user",
                            type: "object"
                        )
                    ],

                )
            ),
        ]
    )]
    public function getUser(int $id): UserResource
    {
        $user = $this->userService->getById($id);
        return new UserResource($user);
    }

    #[OA\Delete(
        path: "/api/users/{id}",
        summary: "Удаление пользователя по id",
        security: [
            [
                "bearerAuth" => []
            ]
        ],
        tags: ["Users"],
        parameters: [
            new OA\Parameter(
                parameter: "id",
                name: "id",
                description: "id пользователя",
                in: "path",
                required: true,
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent()
            ),
        ]
    )]
    public function delete(int $id): void
    {
        $this->userService->delete($id);
    }

    #[OA\Put(
        path: "/api/users/{id}",
        summary: "Обновление пользователя id",
        security: [
            [
                "bearerAuth" => []
            ]
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'email',
                        description: 'email',
                        type: 'string'
                    ),
                    new OA\Property(
                        property: 'name',
                        description: 'Имя',
                        type: 'string'
                    )
                ]
            )
        ),
        tags: ["Users"],
        parameters: [
            new OA\Parameter(
                parameter: "id",
                name: "id",
                description: "id пользователя",
                in: "path",
                required: true,
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "data",
                            ref: "#/components/schemas/user",
                            type: "object"
                        )
                    ],

                )
            ),
        ]
    )]
    public function update(int $id, UserRequest $request): UserResource
    {
        $data = new UserDto(
            name: $request->get("name", ""),
            email: $request->get("email", ""),
            id: $id,
        );
        $user = $this->userService->update($data);
        return new UserResource($user);
    }
}
