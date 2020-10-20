@extends ('layouts.app')
@section ('content')

<h1>
{{$letter->title}}
</h1>
<div>
<span>
{{$letter->reason}}
</span>
</div>
<a href="{{$letter->link}}">
    {{$letter->content}}
</a>
@stop