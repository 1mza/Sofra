<x-mail::message>
    Hi, {{$customer->name?:$customer->restaurant_name}}

    We received a request to access your account
    Your reset code is: {{$code}}

    Thanks,
    {{ config('app.name') }}
</x-mail::message>
