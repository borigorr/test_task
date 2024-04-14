<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceContract;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    public function __construct(
        private UserServiceContract $userService
    ) {}

    #[OA\Post(
        path: "/api/login",
        summary: "Авторизация",
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'email',
                        description: 'email',
                        type: 'string'
                    ),
                    new OA\Property(
                        property: 'password',
                        description: 'Пароль',
                        type: 'string'
                    )
                ]
            )
        ),
        tags: ["Auth"],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    properties: [
                    new OA\Property(
                        property: 'data',
                        properties: [
                            new OA\Property(
                                property: 'token',
                                description: 'JWT токен',
                                type: 'string'
                            ),
                        ],
                        type: "object"
                    )
                ])
            ),
        ]
    )]
    public function login(LoginRequest $request)
    {
        $email = $request->get("email", "");
        $password = $request->get("password", "");
        $token = $this->userService->getJwtToken($email, $password);
        return new LoginResource($token);
    }
}
