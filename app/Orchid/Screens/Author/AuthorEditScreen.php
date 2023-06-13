<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Author;

use App\Actions\Author\CreateAuthor;
use App\Actions\Author\EditAuthor;
use App\DTO\Author\AuthorCreateDTO;
use App\Models\Author;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Facades\Log;

class AuthorEditScreen extends Screen
{
    /**
     * @var Author
     */
    public $author;

    /**
     * Query data.
     *
     * @param Author $author
     *
     * @return array
     */
    public function query(Author $author): iterable
    {
        return [
            'author' => $author,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Create authors';
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
                ->method('remove', [$this->author])
                ->canSee($this->author->exists),
            Button::make(__('Сохранить'))
                ->icon('check')
                ->method('save')
                ->canSee(!$this->author->exists),
            Button::make(__('Сохранить'))
                ->icon('check')
                ->method('edit', [$this->author->id])
                ->canSee($this->author->exists),
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
                    Input::make('author.name')
                        ->required()
                        ->title(__('Имя')),
                    Input::make('author.surname')
                        ->required()
                        ->title(__('Фамилия')),
                    DateTimer::make('author.birth_date')
                        ->title('Дата рождения'),
                ]),
            ]),
        ];
    }

    /**
     * @param CreateAuthor $action
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(CreateAuthor $action)
    {
        $data = \request()->get('author');

        try {
            ($action)(new AuthorCreateDTO($data));
            Toast::info(__('Author was saved'));
        } catch (\Exception $e) {
            Log::error('Author_SAVE_ERROR', ['error' => $e]);
            Toast::error(__('Author was not saved'));
        }

        return redirect()->route('platform.system.authors');
    }

    /**
     * @param EditAuthor $action
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(EditAuthor $action, int $id)
    {
        $data = \request()->get('author');

        try {
            ($action)(new AuthorCreateDTO($data), $id);
            Toast::info(__('Author was saved'));
        } catch (\Exception $e) {
            Log::error('Author_SAVE_ERROR', ['error' => $e]);
            Toast::error(__('Author was not saved'));
        }

        return redirect()->route('platform.system.authors');
    }

    /**
     * @param Author $Author
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     *
     */
    public function remove(Author $Author)
    {
        $Author->delete();

        Toast::info(__('Author was remove'));

        return redirect()->route('platform.system.authors');
    }
}
