<?php

declare(strict_types=1);

use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('User'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Example screen');
    });

Route::screen('example-fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('example-layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('example-charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('example-editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('example-cards', ExampleCardsScreen::class)->name('platform.example.cards');
Route::screen('example-advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');

//Route::screen('idea', 'Idea::class','platform.screens.idea');


// Platform > System > Books
Route::screen('books', \App\Orchid\Screens\Book\BookListScreen::class)->name('platform.system.books')
->breadcrumbs(function (Trail $trail) {
    return $trail
        ->parent('platform.index')
        ->push(__('books'), route('platform.system.books'));
});

Route::screen('books/create', \App\Orchid\Screens\Book\BookEditScreen::class)
    ->name('platform.books.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.system.books')
            ->push(__('create'), route('platform.books.create'));
    });

Route::screen('books/edit/{book}', \App\Orchid\Screens\Book\BookEditScreen::class)
    ->name('platform.book.edit')
    ->breadcrumbs(fn(Trail $trail, $book) => $trail
        ->parent('platform.system.books')
        ->push(__('edit'), route('platform.book.edit', $book)));

Route::screen('books/issue/{book}', \App\Orchid\Screens\Book\BookIssueScreen::class)
    ->name('platform.books.issue')
    ->breadcrumbs(fn(Trail $trail, $book) => $trail
        ->parent('platform.system.books')
        ->push(__('Issue'), route('platform.books.issue', $book)));

// Platform > System > Authors
Route::screen('authors', \App\Orchid\Screens\Author\AuthorListScreen::class)->name('platform.system.authors')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('genres'), route('platform.system.genres'));
    });

Route::screen('authors/create', \App\Orchid\Screens\Author\AuthorEditScreen::class)
    ->name('platform.authors.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.system.authors')
            ->push(__('create'), route('platform.authors.create'));
    });

Route::screen('authors/edit/{author}', \App\Orchid\Screens\Author\AuthorEditScreen::class)
    ->name('platform.author.edit')
    ->breadcrumbs(fn(Trail $trail, $author) => $trail
        ->parent('platform.system.authors')
        ->push(__('edit'), route('platform.author.edit', $author)));

// Platform > System > Genres
Route::screen('genres', \App\Orchid\Screens\Genre\GenreListScreen::class)->name('platform.system.genres')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('genres'), route('platform.system.genres'));
    });

Route::screen('genres/create', \App\Orchid\Screens\Genre\GenreEditScreen::class)
    ->name('platform.genres.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.system.genres')
            ->push(__('create'), route('platform.genres.create'));
    });

Route::screen('genres/edit/{genre}', \App\Orchid\Screens\Genre\GenreEditScreen::class)
    ->name('platform.genre.edit')
    ->breadcrumbs(fn(Trail $trail, $genre) => $trail
        ->parent('platform.system.genres')
        ->push(__('edit'), route('platform.genre.edit', $genre)));
