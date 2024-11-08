<?php

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\CandidateMediaController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');


Auth::routes(['verify'=>true]);


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes under 'auth' middleware group
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





Route::post('/send-email-to-users', function (Request $request) {
    try {
        // Fetch all users who have verified their emails
        $users = User::whereNotNull('email')->whereNotNull('email_verified_at')->get();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No verified users found.'], 404);
        }

        // Prepare the email details
        $details = [
            'title' => 'Test Email via MailerSend SMTP',
            'body' => 'This is a test email sent from Laravel using MailerSend SMTP.'
        ];

        // Send email to each user
        foreach ($users as $user) {
            Mail::to($user->email)->send(new \App\Mail\TestMailerSend($details));
        }

        return response()->json(['message' => 'Emails sent successfully to all verified users.']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
})->name('send.email.to.users');



// Candidate media store route
Route::post('/candidates', [CandidateMediaController::class, 'store'])
    ->name('candidates.store')
    ->middleware('auth'); // Add authentication middleware if required




    Route::get('/send-test-email', function () {
        Mail::raw('This is a test email from Laravel using Mailtrap.', function ($message) {
            $message->to('khaledshwike.01@gmail.com')
                    ->subject('Test Email');
        });

        return 'Test email sent!';
    });
