<?php

namespace App\Http\Controllers;

use App\Actions\Book\CreateBook;
use App\Actions\Book\EditBook;
use App\DTO\Book\BookCreateDTO;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * @OA\Post(
     * tags={"Book"},
     * path="/api/book/create",
     * summary="Создание",
     * description="Create book",
     * @OA\Parameter(
     *      name="title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *           example="Название"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="author_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="int",
     *           example="Id автора"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="genres",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="json",
     *           example="Id жанров"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="release_date",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string",
     *           example="Дата публикации"
     *      )
     *   ),
     * @OA\Response(
     *      response=200,
     *      description="Success"
     *      ),
     * )
     */

    public function create(CreateBook $action)
    {
        return response()->json([
            'id' => ($action)(new BookCreateDTO(\request()->all()))
        ]);
    }

    /**
     * @OA\Patch(
     * tags={"Book"},
     * path="/api/book/edit/{id}",
     * summary="Редактирование",
     * description="Edit book",
     * @OA\Parameter(
     *      name="id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *           example="1"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *           example="Название"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="author_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="int",
     *           example="Id автора"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="genres",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="json",
     *           example="Id жанров"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="release_date",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string",
     *           example="Дата публикации"
     *      )
     *   ),
     * @OA\Response(
     *      response=200,
     *      description="Success"
     *      ),
     * )
     */

    public function edit(EditBook $action, int $id)
    {
        return response()->json([
            'id' => ($action)(new BookCreateDTO(\request()->all()), $id)
        ]);
    }


    /**
     * @OA\Delete(
     * tags={"Book"},
     * path="/api/book/remove/{id}",
     * summary="Удаление",
     * description="Remove book",
     * @OA\Parameter(
     *      name="id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="int",
     *           example="Id книги"
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
        Book::findOrFail($id)->delete();
    }
}
