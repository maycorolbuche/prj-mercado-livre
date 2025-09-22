<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TokenController;
use App\Models\Token;

Route::get('/', function (\Illuminate\Http\Request $request) {
    $code = $request->query('code');
    $state = $request->query('state');

    if ($code && $state && auth()->check()) {
        $token = Token::where('user_id', auth()->id())->first();

        if ($token) {
            $token->update(['code' => $code, 'access_token' => $state]);
        }
        return redirect()->route('index');
    }

    return view('welcome');
})->name('index');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('products', ProductController::class)->names('products');

    Route::get('/token', [TokenController::class, 'index'])->name('token.index');
    Route::post('/token', [TokenController::class, 'storeOrUpdate'])->name('token.storeOrUpdate');
});
