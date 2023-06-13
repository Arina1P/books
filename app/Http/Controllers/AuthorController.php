<?php

namespace App\Http\Controllers;

use App\Actions\Author\CreateAuthor;
use App\Actions\Author\EditAuthor;
use App\DTO\Author\AuthorCreateDTO;
use App\Models\Author;

class AuthorController extends Controller
{
    /**
     * @OA\Post(
     * tags={"Author"},
     * path="/api/author/create",
     * summary="Создание",
     * description="Create author",
     * @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *           example="Имя"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="surname",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *           example="Фамилия"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="birth_date",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string",
     *           example="Дата рождения"
     *      )
     *   ),
     * @OA\Response(
     *      response=200,
     *      description="Success"
     *      ),
     * )
     */

    public function create(CreateAuthor $action)
    {
        return response()->json([
            'id' => ($action)(new AuthorCreateDTO(\request()->all()))
        ]);
    }

    /**
     * @OA\Patch(
     * tags={"Author"},
     * path="/api/author/edit/{id}",
     * summary="Редактирование",
     * description="Edit Author",
     * @OA\Parameter(
     *      name="id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="int",
     *           example="Id автора"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *           example="Имя"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="surname",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *           example="Фамилия"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="birth_date",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string",
     *           example="Дата рождения"
     *      )
     *   ),
     * @OA\Response(
     *      response=200,
     *      description="Success"
     *      ),
     * )
     */

    public function edit(EditAuthor $action, int $id)
    {
        return response()->json([
            'id' => ($action)(new AuthorCreateDTO(\request()->all()), $id)
        ]);
    }

    /**
     * @OA\Delete(
     * tags={"Author"},
     * path="/api/author/remove/{id}",
     * summary="Удаление",
     * description="Remove author",
     * @OA\Parameter(
     *      name="id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="int",
     *           example="Id автора"
     *      )
     *   ),
     * @OA\Response(
     *      response=200,
     *      description="Success"
     *      ),
     * )
     */

    public function remove(int $id)
    {
        Author::findOrFail($id)->delete();
    }
}
