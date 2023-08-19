<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mycontroller;
use App\Http\Middleware\login_check;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[Mycontroller::class, 'index']);

Route::get('/admin', function () {
    return redirect()->route('login');
});

Route::post('cat_filter',[Mycontroller::class, 'cat_filter'])->name('category.filter');

Route::post('sort_filter',[Mycontroller::class, 'sort_filter'])->name('sort.filter');

Route::post('filter_set',[Mycontroller::class, 'filter_set'])->name('filter.set');


Route::get('login', [Mycontroller::class, 'login'])->name('login');

Route::post('login_check', [Mycontroller::class, 'login_check'])->name('login.check');

Route::middleware([login_check::class])->group(function(){

    Route::get('dashboard',function(){
        return view('dashboard');
    })->name('dashboard');

    Route::get('logout',function (){
        session()->flush();
        return redirect()->route('login');
    })->name('logout');

    Route::get('product',[Mycontroller::class, 'product'])->name('product.add');
    Route::post('add_product',[Mycontroller::class, 'add_product'])->name('product');

    Route::get('category',function(){
        return view('category');
    })->name('cat.add');
    Route::post('add_cat',[Mycontroller::class, 'add_cat'])->name('add.cat');

    Route::get('category_show',[Mycontroller::class,'show_category'])->name('show.cat');
    Route::post('cat',[Mycontroller::class, 'edit_cat'])->name('edit.cat');
    Route::post('cat_edit',[Mycontroller::class, 'category_edit'])->name('category.edit');
    Route::post('delete',[Mycontroller::class, 'delete_cat'])->name('delete.cat');

    Route::get('product_show',[Mycontroller::class, 'show_product'])->name('show.product');
    Route::post('pro',[Mycontroller::class, 'edit_pro'])->name('edit.pro');
    Route::post('delete_product',[Mycontroller::class, 'delete_product'])->name('delete.product');
    Route::post('product_edit',[Mycontroller::class, 'product_edit'])->name('product.edit');

});