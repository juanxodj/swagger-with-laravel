<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="API Usuarios", version="1.0")
 *
 * @OA\Server(url="http://swagger.test/api")
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Usuarios"},
     *     path="/users",
     *     summary="Mostrar usuarios",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todos los usuarios."
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error."
     *     )
     * )
     */
    public function index()
    {
        return User::all();
    }

    /**
     * @OA\Get(
     *     tags={"Usuarios"},
     *     path="/users/{id}",
     *     summary="Obtener especificamente un usuario",
     *     @OA\Parameter(
     *         description="Pasamos el ID del usuario a buscar como parámetro",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         @OA\Examples(example="int", value="1", summary="ID #1"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function show(User $user)
    {
        return User::find($user);
    }

    /**
     * @OA\Post(
     *     tags={"Usuarios"},
     *     path="/users",
     *     summary="Agregar nuevo usuario",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 ref="#/components/schemas/User"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  type="string",
     *                  default="Login successfully",
     *                  property="status"
     *              ),
     *              @OA\Property(
     *                  type="string",
     *                  default="20d338931e8d6bd9466edeba78ea7dce7c7bc01aa5cc5b4735691c50a2fe3228",
     *                  property="token"
     *              )
     *          )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $user = new User($request->input());
        $user->saveOrFail();

        return response()->json([
            "msg" => "Usuario creado",
        ]);
    }

    /**
     * @OA\Put(
     *     tags={"Usuarios"},
     *     path="/users/{id}",
     *     summary="Actualizar usuario",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An int value."),
     *         @OA\Examples(example="uuid", value="0006faf6-7a61-426c-9034-579f2cfcfa83", summary="An UUID value."),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function update(Request $request, User $user)
    {
        $user->fill($request->input())->saveOrFail();

        return response()->json([
            'msg' => 'Usuario actualizado',
        ]);
    }
}
