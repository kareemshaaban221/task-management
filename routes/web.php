<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-email', function () {
    \Mail::raw('This is a test email.', function ($message) {
        $message->to('kareem.shaaban@brightcreations.com')
                ->subject('Test Email');
    });

    return 'Email Sent!';
});

Route::get('/send-custom-email', function () {
    $mailer = \Mail::build([
        'transport' => 'smtp',
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'encryption' => 'tls',
        'username' => '',
        'password' => '',
    ]);

    $mailer->alwaysFrom('kareemshaaban221@gmail.com');

    // Send the email using the custom configuration
    $mailer->raw('This is a test email using custom configuration.', function ($message) {
        $message->to('kareem.shaaban@brightcreations.com')
                ->subject('Custom Mail Configuration Test');
    });

    return 'Email sent with custom configuration!';
});
