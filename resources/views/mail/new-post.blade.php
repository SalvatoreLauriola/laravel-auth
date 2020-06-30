@component('mail::message')
# New Post Created

A new post has been published.

{{ $title }}
{{ $slug }}

@component('mail::button', ['url' =>config('app.url') . '/posts' ]) 
View Blog Archive
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent














{{-- <h1>New Post published on blog</h1>

<p>Read more</p>

<p><strong>Title:</strong>{{ $title }}</p>
<p><strong>Slug:</strong>{{ $slug }}</p> --}}
