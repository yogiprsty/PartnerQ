<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupRequestController;
use App\Http\Controllers\ProfileController;
use App\Models\Chat;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

Route::get('/profile', [ProfileController::class, 'edit']);
Route::post('/profile', [ProfileController::class, 'update']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

Route::get('/{slug}', [GroupController::class, 'index']);
Route::get('/group/create', [GroupController::class, 'showCreate']);
Route::post('/group/create', [GroupController::class, 'create']);

Route::post('/group/make-request', [GroupController::class, 'requestJoin']);

Route::post('/group/update/', [GroupController::class, 'update']);

Route::get('/group/settings/{slug}', [GroupController::class, 'settings'])->name('settings');
Route::get('/group/pending/acc/{slug}/{user_id}', [GroupController::class, 'acceptUser']);
Route::get('/group/kick/{slug}/{user_id}', [GroupController::class, 'declineUser']);

Route::get('/read-chat/{slug}', [GroupController::class, 'readChat']);
Route::post('/send-chat/{slug}', function(Request $request, $slug) {
    $validated = $request->validate([
        'chat_text' => 'required'
    ]);
    $username = Auth::user()->username;
    $group = Group::where('slug', $slug)->first();

    $data = [
        'group_id' => $group->id,
        'username' => $username,
        'chat_text' => $request['chat_text']
    ];
    Chat::create($data);
    return response(200);
});