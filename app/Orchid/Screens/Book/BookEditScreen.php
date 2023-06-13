<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Book;

use App\Actions\Book\CreateBook;
use App\Actions\Book\EditBook;
use App\Actions\Book\ReturnBook;
use App\DTO\Book\BookCreateDTO;
use App\DTO\Book\BookReturnDTO;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Facades\Log;

class BookEditScreen extends Screen
{
    /**
     * @var Book
     */
    public $book;

    /**
     * Query data.
     *
     * @param Book $book
     *
     * @return array
     */
    public function query(Book $book): iterable
    {
        $genres = $book->genres()->get()->pluck('id', 'title')->toArray();
        return [
            'book' => $book,
            'genres' => $genres,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Create book';
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
        $reader = Book::getReader($this->book->id);
        return [
            Button::make(__('Удалить'))
                ->icon('trash')
                ->method('remove', [$this->book])
                ->canSee($this->book->exists),
            Button::make(__('Сохранить'))
                ->icon('check')
                ->method('save')
                ->canSee(!$this->book->exists),
            Button::make(__('Сохранить'))
                ->icon('check')
                ->method('edit', [$this->book->id])
                ->canSee($this->book->exists),

            Button::make(__('Выдать'))
                ->icon('check')
                ->method('issue', [$this->book->id])
                ->canSee($this->book->exists && !$reader),

            Button::make(__('Забрать'))
                ->icon('check')
                ->method('return', [$this->book->id])
                ->canSee($this->book->exists && $reader),
        ];
    }

    /**
     * Views.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        $authors = Author::all()->pluck('id', 'name')->flip()->toArray();
        $genres = Genre::all()->pluck('id', 'title')->flip()->toArray();
        $reader = Book::getReader($this->book->id);

        return [
            Layout::block([
                Layout::rows([
                    Input::make('book.title')
                        ->required()
                        ->title(__('Имя')),
                    Select::make('book.author_id')
                        ->options($authors)
                        ->required()
                        ->title(__('Автор'))
                        ->empty('Не выбран'),
                    Select::make('genres')
                        ->options($genres)
                        ->required()
                        ->multiple()
                        ->title(__('Жанры'))
                        ->empty('Не выбран'),
                    DateTimer::make('book.release_date')
                        ->title('Дата выпуска'),
                ]),
            ])
                ->description('Книга находится у ' . $reader
                ),
        ];
    }

    /**
     * @param CreateBook $action
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(CreateBook $action)
    {
        $data = \request()->get('book');

        try {
            ($action)(new BookCreateDTO($data));
            Toast::info(__('Book was saved'));
        } catch (\Exception $e) {
            Log::error('Book_SAVE_ERROR', ['error' => $e]);
            Toast::error(__('Book was not saved'));
        }

        return redirect()->route('platform.system.books');
    }

    /**
     * @param EditBook $action
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(EditBook $action, int $id)
    {
        $data = \request()->get('book');
        $data['genres'] = \request()->get('genres');

        try {
            ($action)(new BookCreateDTO($data), $id);
            Toast::info(__('Book was saved'));
        } catch (\Exception $e) {
            Log::error('Book_SAVE_ERROR', ['error' => $e]);
            Toast::error(__('Book was not saved'));
        }

        return redirect()->route('platform.system.books');
    }

    /**
     * @param Book $book
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     *
     */
    public function remove(Book $book)
    {
        $book->delete();

        Toast::info(__('Book was remove'));

        return redirect()->route('platform.system.Books');
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function issue(int $id)
    {
        return redirect()->route('platform.books.issue', $id);
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function return(ReturnBook $action, int $id)
    {
        $data['returned'] =  now();

        try {
            ($action)(new BookReturnDTO($data), $id);
            Toast::info(__('Book returned'));
        } catch (\Exception $e) {
            Log::error('BOOK_RETURN_ERROR', ['error' => $e]);
            Toast::error(__('Book not returned'));
        }
    }
}
