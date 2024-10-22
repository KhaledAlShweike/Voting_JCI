<?php

use App\Http\Controllers\Api\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// require __DIR__.'/auth.php';
require __DIR__.'/api.php';



Route::get('/send-mailersend-test', function () {
    $details = [
        'title' => 'Test Email via MailerSend SMTP',
        'body' => 'This is a test email sent from Laravel using MailerSend SMTP.'
    ];

    Mail::to('recipient@example.com')->send(new \App\Mail\TestMailerSend($details));

    return 'Test email sent via MailerSend!';
});
