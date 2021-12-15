@extends('grv.page')
@section('content')
<section class="content" id="content">
    <div class="activityPageMenu row">
        <div class="activityPageMenu-wrap">
            
            <div class="activityPageMenu-Links">
                @foreach ($activity_types as $item)
                    <a id="{{$item->type_id}}" href="{{$item->type_id}}">{{$item->typeName}}</a>
                @endforeach
                
            </div>
        </div>
    </div>
    <section class="ActivityContent">
        <div class="ActivityTitle">
                @foreach ($activity_types as $item)
                @if($item->type_id == $activity_type)
                    <span>{{$item->typeName}}</span>
                @endif
                @endforeach
        </div>
        <div class="ActivityContent-wrap">
            <div class="ActivityMenu">
                <div class="ActivityMenu-list">
                    @foreach($activities as $num => $item)
                        <a class="ActivityMenu-list-table row"  href="/activity/{{$item['type']}}/{{$item['activity_id']}}" target='_blank'>
                            <div class="ActivityMenu-show-group">
                                <div style="background-image:url('../storage/{{$item['img_path']}}')" class="ActivityMenu-list-img">
                                    <span></span>
                                </div>
                            </div>
                            
                            <div class="ActivityMenu-content-group">
                                <span class="title">{{$item['name']}}</span></br>
                                
                            </div>
                            <div class="ActivityMenu-create-group">
                                <span style="font-weight:bolder;">政府單位：</span>
                                <span ></br>{{$item['organizers']}}</span></br>
                                <span ></br></span> 
                                <span style="font-weight:bolder;">專案負責人：</br></span>
                                <span >{{$item->project_user['nickname']}}</span>
                            </div>
                        </a>
                        
                    @endforeach
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
    });
    
</script>