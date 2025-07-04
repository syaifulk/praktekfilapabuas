<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Route::get('/', [HomeController::class,'index']) -> name('home');
Route::get('/post/{slug}', [PostController::class,'detail']) -> name('post.detail');
Route::get('/artikel', [PostController::class, 'showArtikel'])->name('artikel');
Route::get('/penulis', [PostController::class, 'penulis'])->name('penulis');


Route::get('/check-permissions', function () {
    $permission = Permission::firstOrCreate(['name' => 'access_post_resource', 'guard_name' => 'web']);
    $role = Role::findByName('author');
    $role->givePermissionTo($permission);
});