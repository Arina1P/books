<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            Menu::make(__('Books'))
                ->icon('book-open')
                ->route('platform.system.books')
                ->badge(function () {
                    return Book::count();
                })
                ->title('Library'),

            Menu::make(__('Authors'))
                ->icon('user')
                ->route('platform.system.authors')
                ->badge(function () {
                    return Author::count();
                }),

            Menu::make(__('Genres'))
                ->icon('user')
                ->route('platform.system.genres')
                ->badge(function () {
                    return Genre::count();
                }),

//            Menu::make('Text Editors')
//                ->icon('list')
//                ->route('platform.example.editors'),

//            Menu::make('Documentation')
//                ->title('Docs')
//                ->icon('docs')
//                ->url('https://orchid.software/en/docs'),

            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

//            Menu::make(__('Roles'))
//                ->icon('lock')
//                ->route('platform.systems.roles')
//                ->permission('platform.systems.roles'),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
