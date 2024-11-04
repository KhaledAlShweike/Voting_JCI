<?php

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\CandidateMediaController;
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
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes under 'auth' middleware group
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Test email route
Route::get('/send-mailersend-test', function () {
    try {
        $details = [
            'title' => 'Test Email via MailerSend SMTP',
            'body' => 'This is a test email sent from Laravel using MailerSend SMTP.'
        ];

        Mail::to('test@example.com')->send(new \App\Mail\TestMailerSend($details));

        return response()->json(['message' => 'Email sent successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->name('send.mail.test');

// Candidate media store route
Route::post('/candidates', [CandidateMediaController::class, 'store'])
    ->name('candidates.store')
    ->middleware('auth'); // Add authentication middleware if required
