<x-mail::message>
# Task Reminder

Dear {{ $user->name }},

This is a task reminder for you.
You have to finish these tasks:

@foreach ($tasks as $task)
- {{ $task->title }}
@endforeach

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
