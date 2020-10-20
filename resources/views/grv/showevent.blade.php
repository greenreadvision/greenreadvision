@extends('layouts.eventsPage')
@section('content')

<div class="d-flex justify-content-center content">
    <div class="col-xl-9 my-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">首頁</a></li>
                <li class="breadcrumb-item active"><a href="{{route('eventpage')}}">活動花絮</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{__('customize.'.$type)}}</li>

            </ol>
        </nav>
        
        <!-- <h1 class="text-center font-weight-bold text-dark mb-3">{{__('customize.'.$type)}}</h1> -->
        <div class="row">
            @foreach($photos as $data)
            <div class="col-xl-6 mb-4">
                <div class="banner">
                    <a href="{{route('eventpage.view',['type'=>$data['type'],'id'=> $data['photo_id']])}}">
                        <div class="master-title ">
                            {{$data['name']}}
                        </div>
                        <img class="object-fit_cover" src="{{route('download', $data['path'])}}" alt="">
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
<div></div>
<div id="BackTop">
    <div style="position: relative;width:100%;height:100%"><i class='fas fa-chevron-up' style='font-size:24px;position: absolute;
	top:8px;
    left:8px;'></i></div>
</div>
@stop

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    $(window).scroll(function() {
        if ($(this).scrollTop() >= 50) { // If page is scrolled more than 50px
            $('#BackTop').fadeIn(300); // Fade in the arrow
        } else {
            $('#BackTop').fadeOut(300); // Else fade out the arrow
        }
    });
    $('#BackTop').click(function() { // When arrow is clicked
        $('body,html').animate({
            scrollTop: 0 // Scroll to top of body
        }, 500);
    });
</script>
@stop