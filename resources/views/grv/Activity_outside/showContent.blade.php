@extends('grv.page')
@section('content')

<section class="content" >
    <div class="activityPageMenu row">
        <div class="activityPageMenu-wrap">
            
            <div class="activityPageMenu-Links">
                @foreach ($activity_types as $item)
                    <a id="{{$item->type_id}}" href="/activity/{{$item->type_id}}">{{$item->typeName}}</a>
                @endforeach
                
            </div>
        </div>
    </div>
    <section class="ActivityContent">
        <div class="ActivityTitle">
            <div class="ActivityTitleHead">
                @foreach ($activity_types as $item)
                @if($item->type_id == $activity_type)
                    <div id="title-logo" class="ActivityTitleHead-type">{{$item->typeName}}</div>
                    &nbsp&nbsp&nbsp
                    <div class="ActivityTitleHead-title">{{$activity->organizers}} {{$activity->name}}</div>
                @endif
                @endforeach
            </div>
        </div>
        <div class="ActivityContentPage-wrap">
            <div class="Activity-frame">
                <div class="Activity-Content">
                    {!!$activity->content!!}
                </div>
            </div>
        </div>
        
    </section>
</section>

@stop
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.0/dist/xlsx.full.min.js"></script>
<script src="{{URL::asset('ckeditor/ckeditor.js') }}"></script>
<script>
    $(document).ready(function(){
        var pathname = location.pathname;
        
        var path = pathname.split("/")
        console.log(path[2])
        document.getElementById(path[2]).classList.add('activityPageMenu-Links-active')

        document.getElementById('title-logo').classList.add(path[2])
    });
    
</script>