<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return UserResource::collection($this->userService->all());
    }

    public function store(UserRequest $request)
    {
        try {
            $user = $this->userService->create($request->all());

            return response()->json([
                'data' => new UserResource($user),
                'message' => 'Usuario registrado exitosamente.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar el usuario.'
            ], 500);
        }
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            $user = $this->userService->update($request->all(), $user);

            return response()->json([
                'data' => new UserResource($user),
                'message' => 'Datos del usuario actualizados exitosamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar los datos del usuario.'
            ], 500);
        }
    }

    public function destroy(User $user)
    {
        try {
            $this->userService->delete($user);

            return response()->json([
                'message' => 'Usuario eliminado exitosamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el usuario.'
            ], 500);
        }
    }
}
