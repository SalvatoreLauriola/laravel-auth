@component('mail::message')
# New Post Updated

A new post has been updated.

{{ $title }}
{{ $slug }}

@component('mail::button', ['url' =>config('app.url') . '/posts' ]) 
View Blog Archive
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
