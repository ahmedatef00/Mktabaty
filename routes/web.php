


<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', function () {
//     return view('welcome');
// })->middleware(['auth']);

Auth::routes();

Route::get('admin', 'AdminController@listAdmins')->name('listUsers')->middleware(['auth']);
Route::get('admin/users', 'AdminController@listUsers')->name('listUsers')->middleware(['auth']);
Route::get('admin/admins', 'AdminController@listAdmins')->name('listAdmins')->middleware(['auth']);
Route::get('admin/dashboard', 'AdminController@index')->name('dashboard');


Route::get('/', 'Admin\BookController@index');


Route::get('/favorites', function () {
    return view('mktabaty.pages.books.favorites');
});


Route::get('/books', function () {
    return view('mktabaty.pages.books.user-books');
});


Route::get('/book', function () {
    return view('mktabaty.pages.books.book');
});

// Route::get('/login', function () {
//     return view('mktabaty.pages.user.login');
// });


// Route::get('/register', function () {
//     return view('mktabaty.pages.user.register');
// });


// Route::get('/admin', function () {
//     return view('dashboard.pages.admins');
// });

// Route::get('/', ['name' => 'admin.index', 'uses' => function () {
//     return view('dashboard.pages.index');
// }]);


// Route::get('/admin/users', function () {
//     return view('dashboard.pages.users');
// });

Route::prefix('admin')->group(function () {
    Route::resource('books', 'Admin\BookController');

    Route::resource('category', 'Admin\CategoryController');
    Route::resource('books', 'Admin\BookController');
});

Route::resource('books', 'Admin\BookController');

// Route::resource('cat', 'Admin\CategoryController');

Route::get('/getBooks/{category}', 'Admin\BookController@categoryBooks')->name('getBooks');
Route::get('/', 'Admin\BookController@webBooks');
