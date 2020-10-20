@extends('layouts.page')
@section('css')
<link rel="stylesheet" href="{{ URL::asset('css/main.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/colorbox.css') }}" />
@stop
@section('content')
    @foreach ($data['arr'] as $key => $year)
        @if ($key != 0)
            <hr class="major">
        @endif
        <section id="three" class="wrapper">
            <div class="inner">
                <p id="news_text">{{$data['allYears'][$key]}}年度</p>
                @for ($keyEvent = 0; $keyEvent < count($year); )
                    <div class="flex flex-3"><!-- 分成多少格 -->
                        @for ($j = 0; $j < 3; $j++, $keyEvent++)
                            <article id="a_animation">
                                @if ($keyEvent < count($year))
                                    <section id="a_img">
                                        <div class="image fit">
                                            <div class="group1">
                                                <div class="fin" style="display:flex;">
                                                    <img src="{{$year[$keyEvent]["keyVision"]}}" style="align-items:center;" alt="Pic 01" />
                                                </div>
                                                <div class="fir" style="display:flex;">
                                                    <img src="{{$year[$keyEvent]["keyPic"]}}" style="align-items:center;" alt="Pic 02" />
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <header>
                                        <div class="text_font1">
                                            <h3>{{$year[$keyEvent]["name"]}}</h3>
                                        </div>
                                    </header>
                                @endif
                            </article>
                        @endfor
                    </div>
                @endfor
            </div>
        </section>
    @endforeach
@stop
@section('javascript')
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/skel.min.js') }}"></script>
<script src="{{ URL::asset('js/util.js') }}"></script>
<script src="{{ URL::asset('js/main.js') }}"></script>
<script src="{{ URL::asset('js/jquery.colorbox.js') }}"></script>
<!--<script>
    $(document).ready(function(){
        //Examples of how to assign the Colorbox event to elements
        $(".group1").colorbox({rel:'group1'});
        $(".ajax").colorbox();
        $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
        $(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
        $(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
        $(".inline").colorbox({inline:true, width:"50%"});
        $(".callbacks").colorbox({
            onOpen:function(){ alert('onOpen: colorbox is about to open'); },
            onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
            onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
            onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
            onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
        });

        $('.non-retina').colorbox({rel:'group5', transition:'none'})
        $('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
        
        //Example of preserving a JavaScript event for inline calls.
        $("#click").click(function(){ 
            $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
            return false;
        });
    });
</script>-->
@stop