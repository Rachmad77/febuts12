<?php

use App\Http\Controllers\Adm\CategoryBlogController;
use App\Http\Controllers\Adm\CategoryPageController;
use App\Http\Controllers\Adm\DashboardController;
use App\Http\Controllers\Adm\PermissionController;
use App\Http\Controllers\Adm\RoleController;
use App\Http\Controllers\Adm\UserController;
use App\Http\Controllers\Adm\ProgramStudiController;
use App\Http\Controllers\Adm\TagCategoryController;
use App\Http\Controllers\Adm\BlogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');

        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::get('/show/{id}', [RoleController::class, 'show'])->name('show');
            Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [RoleController::class, 'update'])->name('update');
            Route::put('/checked/{id}', [RoleController::class, 'checked'])->name('checked');
            Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('delete');
        });

        Route::prefix('permission')->name('permission.')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('index');
            Route::post('/', [PermissionController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [PermissionController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [PermissionController::class, 'destroy'])->name('delete');
        });
    });

    Route::prefix('master')->name('master.')->group(function () {
        Route::get('/blog-category', [CategoryBlogController::class, 'index'])->name('blog-category.index');
        Route::post('/blog-category', [CategoryBlogController::class, 'store'])->name('blog-category.store');
        Route::get('/blog-category/{id}', [CategoryBlogController::class, 'edit'])->name('blog-category.edit');
        Route::put('/blog-category/{id}', [CategoryBlogController::class, 'update'])->name('blog-category.update');
        Route::delete('/blog-category/{id}', [CategoryBlogController::class, 'destroy'])->name('blog-category.destroy');
        Route::put('/blog-category/restore/{id}', [CategoryBlogController::class, 'restore'])->name('blog-category.restore');
        Route::delete('/blog-category/force-delete/{id}', [CategoryBlogController::class, 'forceDelete'])->name('blog-category.force-delete');

        Route::get('/page-category', [CategoryPageController::class, 'index'])->name('page-category.index');
        Route::post('/page-category', [CategoryPageController::class, 'store'])->name('page-category.store');
        Route::get('/page-category/{id}', [CategoryPageController::class, 'edit'])->name('page-category.edit');
        Route::put('/page-category/{id}', [CategoryPageController::class, 'update'])->name('page-category.update');
        Route::delete('/page-category/{id}', [CategoryPageController::class, 'destroy'])->name('page-category.destroy');
        Route::put('/page-category/restore/{id}', [CategoryPageController::class, 'restore'])->name('page-category.restore');
        Route::delete('/page-category/force-delete/{id}', [CategoryPageController::class, 'forceDelete'])->name('page-category.force-delete');

        Route::get('/programstudi', [ProgramStudiController::class, 'index'])->name('programstudi.index');
        Route::post('/programstudi', [ProgramStudiController::class, 'store'])->name('programstudi.store');
        Route::get('/programstudi/{id}', [ProgramStudiController::class, 'edit'])->name('programstudi.edit');
        Route::put('/programstudi/{id}', [ProgramStudiController::class, 'update'])->name('programstudi.update');
        Route::delete('/programstudi/{id}', [ProgramStudiController::class, 'destroy'])->name('programstudi.destroy');
        Route::put('/programstudi/restore/{id}', [ProgramStudiController::class, 'restore'])->name('programstudi.restore');
        Route::delete('/programstudi/force-delete/{id}', [ProgramStudiController::class, 'forceDelete'])->name('programstudi.force-delete');

        Route::get('/category_tag', [TagCategoryController::class, 'index'])->name('category_tag.index');
        Route::post('/category_tag', [TagCategoryController::class, 'store'])->name('category_tag.store');
        Route::get('/category_tag/{id}', [TagCategoryController::class, 'edit'])->name('category_tag.edit');
        Route::put('/category_tag/{id}', [TagCategoryController::class, 'update'])->name('category_tag.update');
        Route::delete('/category_tag/{id}', [TagCategoryController::class, 'destroy'])->name('category_tag.destroy');
        Route::put('/category_tag/restore/{id}', [TagCategoryController::class, 'restore'])->name('category_tag.restore');
        Route::delete('/category_tag/force-delete/{id}', [TagCategoryController::class, 'forceDelete'])->name('category_tag.force-delete');
    });

    Route::prefix('adm')->name('adm.')->group(function() {
        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
        Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');
        Route::put('/blog/{id}', [BlogController::class, 'update'])->name('blog.update');
        Route::delete('/blog/{id}', [BlogController::class, 'destroy'])->name('blog.destroy');
    });
});


require __DIR__ . '/auth.php';
