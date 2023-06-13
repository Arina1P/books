<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Book;

use App\Actions\Book\IssueBook;
use App\DTO\Book\BookIssueDTO;
use App\Models\Book;
use App\Models\User;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Facades\Log;

class BookIssueScreen extends Screen
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
        return [
            'book' => $book,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Issue Book';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Access rights';
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
            Button::make(__('Выдать'))
                ->icon('check')
                ->method('save', [$this->book->id])
        ];
    }

    /**
     * Views.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        $user = User::all()->pluck('id', 'name')->flip()->toArray();
        return [
            Layout::block(
                Layout::rows([
                    Select::make('user_id')
                        ->options($user)
                        ->required()
                        ->title(__('Читатель'))
                        ->empty('Не выбран'),
                ])
            ),
        ];
    }

    /**
     * @param IssueBook $action
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(IssueBook $action,  $bookId)
    {
        $data['user_id'] = \request()->get('user_id');
        $data['issued'] = now();

        try {
            ($action)(new BookIssueDTO($data), $bookId);
            Toast::info(__('Book issued'));
        } catch (\Exception $e) {
            Log::error('BOOK_SAVE_ERROR', ['error' => $e]);
            Toast::error(__('Book not issued'));
        }

        return redirect()->route('platform.system.books');
    }

}
