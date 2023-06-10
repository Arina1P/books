<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Genre;

use App\Actions\Genre\CreateGenre;
use App\Actions\Genre\EditBook;
use App\DTO\Genre\GenreCreateDTO;
use App\Models\Genre;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Facades\Log;

class GenreEditScreen extends Screen
{
    /**
     * @var genre
     */
    public $genre;

    /**
     * Query data.
     *
     * @param Genre $genre
     *
     * @return array
     */
    public function query(Genre $genre): iterable
    {
        return [
            'genre' => $genre,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Create genres';
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
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Удалить'))
                ->icon('trash')
                ->method('remove', [$this->genre])
                ->canSee($this->genre->exists),
            Button::make(__('Сохранить'))
                ->icon('check')
                ->method('save')
                ->canSee(!$this->genre->exists),
            Button::make(__('Сохранить'))
                ->icon('check')
                ->method('edit', [$this->genre->id])
                ->canSee($this->genre->exists),
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
            Layout::block([
                Layout::rows([
                    Input::make('genre.title')
                        ->required()
                        ->title(__('Жанр')),
                ]),
            ]),
        ];
    }

    /**
     * @param CreateGenre $action
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(CreateGenre $action)
    {
        $data = \request()->get('genre');

        try {
            ($action)(new GenreCreateDTO($data));
            Toast::info(__('Genre was saved'));
        } catch (\Exception $e) {
            Log::error('Genre_SAVE_ERROR', ['error' => $e]);
            Toast::error(__('Genre was not saved'));
        }

        return redirect()->route('platform.system.genres');
    }

    /**
     * @param EditBook $action
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(EditBook $action, int $id)
    {
        $data = \request()->get('genre');

        try {
            ($action)(new GenreCreateDTO($data), $id);
            Toast::info(__('Genre was saved'));
        } catch (\Exception $e) {
            Log::error('GENRE_SAVE_ERROR', ['error' => $e]);
            Toast::error(__('Genre was not saved'));
        }

        return redirect()->route('platform.system.genres');
    }

    /**
     * @param Genre $Genre
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     *
     */
    public function remove(Genre $genre)
    {
        $genre->delete();

        Toast::info(__('Genre was remove'));

        return redirect()->route('platform.system.genres');
    }
}
