<?php

namespace App\Notifications;

use App\Enums\TaskStatusEnum;
use App\Mail\TasksReminderMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class TaskReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected $beforeDate)
    { }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        $notifiable
            ->tasks()
            ->whereDate('due_date', '>=', $this->beforeDate)
            ->update(['status' => TaskStatusEnum::OVER_DUE()]);

        $subject = 'Task Reminder';
        $data = [
            'user' => $notifiable,
            'tasks' => $notifiable
                ->tasks()
                ->where('status', TaskStatusEnum::OPEN())
                ->whereDate('due_date', '<', $this->beforeDate)
                ->get(),
        ];

        if ($data['tasks']->isEmpty()) {
            return;
        }

        $mail = new TasksReminderMail($subject, $data);
        static::buildMailer()->to($notifiable->email)->send($mail);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public static function buildMailer() {
        $mailer = Mail::build([
            'transport' => 'smtp',
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'encryption' => 'tls',
            'username' => '', // TODO Fill these lines with google data
            'password' => '', // TODO Fill these lines with google data
        ]);
        $mailer->alwaysFrom("info@system.com", config('app.name'));
        return $mailer;
    }
}
