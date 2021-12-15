@extends('layouts.eventsPage')
@section('content')

<div class="d-flex justify-content-center content">
    <div class="col-lg-9 my-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">首頁</a></li>
                <li class="breadcrumb-item active" aria-current="page">活動花絮</li>
            </ol>
        </nav>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-6 hakka p-3">
                    <a style="text-decoration:none;" href="{{route('eventpage.show', 'hakka')}}">
                        <div class="eventpage d-flex justify-content-center">
                            <span>客家文化</span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 read p-3">
                    <a style="text-decoration:none;" href="{{route('eventpage.show', 'read')}}">
                        <div class="eventpage d-flex justify-content-center">
                            <span>閱讀</span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 child p-3">
                    <a style="text-decoration:none;" href="{{route('eventpage.show', 'child')}}">
                        <div class="eventpage d-flex justify-content-center">
                            <span>親子活動</span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 operation p-3">
                    <a style="text-decoration:none;" href="{{route('eventpage.show', 'operation')}}">
                        <div class="eventpage d-flex justify-content-center">
                            <span>營運</span>
                        </div>
                    </a>
                </div>
            </div>
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
<style>
   
.hakka div{
	background-color: #cff09e;
	border-radius: 5px;
}
.read div{
	background-color: #a8dba8;
	border-radius: 5px;
}
.child div{
	background-color: #79bd9a;
	border-radius: 5px;
}
.operation div{
	background-color: #3b8686;
	border-radius: 5px;
}
    .eventpage {
        height: 250px;
        transition: .5s all;

    }

    .eventpage span {
        text-align: center;
        line-height: 250px;
        color: white;
        font-size: 4rem;
        font-weight: bold;
        font-family: sans-serif, Microsoft JhengHei;

    }

    .eventpage:hover {
        box-shadow: 1px 1px 10px rgb(0, 0, 0, .2);
        transition: .5s all;
    }

    @media screen and (max-width:1024px) {
        .eventpage {
            height: 150px;
        }

        .eventpage span {
            text-align: center;
            line-height: 150px;
            color: white;
            font-size: 4rem;
            font-weight: bold;
            font-family: sans-serif, Microsoft JhengHei;

        }
    }
</style>
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