@extends('layouts.eventsPage')
@section('content')

<div class="d-flex justify-content-center content">
    <div class="col-lg-9 my-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">首頁</a></li>
                <li class="breadcrumb-item active"><a href="{{route('eventpage')}}">活動花絮</a></li>
                <li class="breadcrumb-item"><a href="{{route('eventpage.show', $type)}}">{{__('customize.'.$type)}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$photo->name}}</li>

            </ol>
        </nav>
        <div class="row popup-gallery">
            @foreach($data as $temp)
            <div class="col-xl-4 mb-3 photo-img">
                <a href="{{route('download', $temp['path'])}}">
                    <img class="object-fit_cover" src="{{route('download', $temp['path'])}}" alt="" width="100%" height="240px">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div id="BackTop">
    <div style="position: relative;width:100%;height:100%"><i class='fas fa-chevron-up' style='font-size:24px;position: absolute;
	top:8px;
    left:8px;'></i></div>
</div>

@stop

@section('javascript')
<!-- Magnific Popup core CSS file -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="{{URL::asset('js/jquery.magnific-popup.js')}}"></script>
<script>
    $(document).ready(function($) {
        $('.popup-gallery').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                
            }
        });
    });

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