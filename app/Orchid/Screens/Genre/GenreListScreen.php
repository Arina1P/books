<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Genre;

use App\Models\Genre;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class GenreListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        $table = [];
        $Genres = Genre::all();

        $Genres->map(function ($item) use (&$table) {
            return $table[] = new Repository([
                'id' => $item->id,
                'title' => $item->title,
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
        return 'Genres';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'All registered genres';
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
                ->route('platform.genres.create'),
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

                TD::make(__('Actions'))->width('50')
                    ->align(TD::ALIGN_CENTER)
                    ->width('10px')
                    ->render(fn(Repository $model) =>
                    DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Редактирование'))
                                ->route('platform.genre.edit', $model->get('id'))
                                ->icon('pencil'),
                        ])
                    ),

            ])

        ];
    }
}
