@extends ('layouts.app')
@section ('content')



@foreach($user->letters as $letter)
{{$letter->created_at}}
@if($letter->status == 'not_read')
<div style="cursor:pointer" onclick="location.href='{{route('letter.show', $letter->letter_id)}}'">
    <span style="font-size:16px;color:black;">{{$letter->title}}</span>
</div>
@else
<div style="cursor:pointer" onclick="location.href='{{route('letter.show', $letter->letter_id)}}'">
    <span style="font-size:16px;color:black;font-weight:normal">{{$letter->title}}</span>
</div>
@endif
@endforeach
@stop