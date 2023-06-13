<?php

namespace App\Http\Controllers;

use App\Actions\Genre\CreateGenre;
use App\Actions\Genre\EditGenre;
use App\DTO\Genre\GenreCreateDTO;
use App\Models\Genre;

class GenreController extends Controller
{
    /**
     * @OA\Post(
     * tags={"Genre"},
     * path="/api/genre/create",
     * summary="Создание",
     * description="Create genre",
     * @OA\Parameter(
     *      name="title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *           example="Название"
     *      )
     *   ),
     * @OA\Response(
     *      response=200,
     *      description="Success"
     *      ),
     * )
     */

    public function create(CreateGenre $action)
    {
        return response()->json([
            'id' => ($action)(new GenreCreateDTO(\request()->all()))
        ]);
    }

    /**
     * @OA\Patch(
     * tags={"Genre"},
     * path="/api/genre/edit/{id}",
     * summary="Редактирование",
     * description="Edit genre",
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
     *           example="Название"
     *      )
     *   ),
     * @OA\Response(
     *      response=200,
     *      description="Success"
     *      ),
     * )
     */

    public function edit(EditGenre $action, int $id)
    {
        return response()->json([
            'id' => ($action)(new GenreCreateDTO(\request()->all()), $id)
        ]);
    }

    /**
     * @OA\Delete(
     * tags={"Genre"},
     * path="/api/genre/remove/{id}",
     * summary="Удаление",
     * description="Remove genre",
     * @OA\Parameter(
     *      name="id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="int",
     *           example="Id жанра"
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
        Genre::findOrFail($id)->delete();
    }
}
