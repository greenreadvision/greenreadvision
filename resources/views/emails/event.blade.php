@component('mail::message')
<h1>
    {{$maildata['title']}}
</h1>
<div>
    <span>
        {{ $maildata['reason']}}
    </span>
</div>

@component('mail::button', ['url' => $maildata['link']])
請點擊按鈕，{{ $maildata['content']}}
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
