<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Book;

use App\Models\Book;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class BookListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        $table = [];
        $books = Book::all();

        $books->map(function ($item) use (&$table) {
            $reader = Book::getReader($item->id);
            return $table[] = new Repository([
                'id' => $item->id,
                'title' => $item->title,
                'created_at' => $item->created_at,
                'author' => $item->author->name,
                'genres' => $item->genres()->pluck('title')->implode(', '),
                'reader' => $reader,
            ]);
        })->toArray();

        return ['table' => $table,];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Books';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'All registered books';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.systems.users',
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.books.create'),
        ];
    }

    /**
     * Views.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('table', [
                TD::make('id', 'ID')
                    ->width('70')
                    ->render(function (Repository $model) {
                        return $model->get('id');
                    }),

                TD::make('title', 'Название')
                    ->width('150')
                    ->render(function (Repository $model) {
                        return $model->get('title');
                    }),

                TD::make('author', 'Автор')
                    ->width('150')
                    ->render(function (Repository $model) {
                        return $model->get('author');
                    }),

                TD::make('genres', 'Жанры')
                    ->width('150')
                    ->render(function (Repository $model) {
                        return $model->get('genres');
                    }),

                TD::make('reader', 'Читатель')
                    ->width('150')
                    ->render(function (Repository $model) {
                        return $model->get('reader');
                    }),

                TD::make(__('Actions'))->width('50')
                    ->align(TD::ALIGN_CENTER)
                    ->width('10px')
                    ->render(fn(Repository $model) => DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Редактирование'))
                                ->route('platform.book.edit', $model->get('id'))
                                ->icon('pencil'),
                        ])
                    ),
            ])

        ];
    }
}
