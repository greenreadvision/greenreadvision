@extends('layouts.page')
@section('css')
<link rel="stylesheet" href="{{ URL::asset('css/main.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/colorbox.css') }}" />
@stop
@section('header')
<header id="main_area">
    <section id="n_img">
        <div>
            <img src="{{ URL::asset('img/20170728152736.jpg') }}" alt="main img" />
        </div>
    </section>
</header>
@stop
@section('content')
    <div class="layer"></div>
    <!-- Three -->
        <section id="three" class="wrapper">
            <div class="inner">
                <p id="news_text">課程活動</p>
                <div class="flex flex-3"><!-- 分成多少格 -->
                    <article id="a_animation">
                        <section id="a_img">
                            <div class="image fit">
                                <a class="group1" href="{{ URL::asset('img/logo_pic.png') }}" title="test">
                                    <div class="fin">
                                        <img src="{{ URL::asset('img/logo_pic.png') }}" alt="Pic 01" />
                                    </div>
                                    <div class="fir">
                                        <img src="{{ URL::asset('img/logo_pic2.png') }}" alt="Pic 02" />
                                    </div>
                                    <p>進入 →</p>
                                </a>
                            </div>
                        </section>
                        <header>
                            <div class="text_font1">
                                <h3>尚未公布</h3>
                            </div>
                        </header>
                    </article>
                    <article id="a_animation">
                        <section id="a_img">
                            <div class="image fit">
                                <a class="group1" href="{{ URL::asset('img/logo_pic.png') }}" title="test">
                                    <div class="fin">
                                        <img src="{{ URL::asset('img/logo_pic.png') }}" alt="Pic 01" />
                                    </div>
                                    <div class="fir">
                                        <img src="{{ URL::asset('img/logo_pic2.png') }}" alt="Pic 02" />
                                    </div>
                                    <p>進入 →</p>
                                </a>
                            </div>
                        </section>
                        <header>
                            <div class="text_font1">
                                <h3>尚未公布</h3>
                            </div>
                        </header>
                    </article>
                    <article id="a_animation">
                        <section id="a_img">
                            <div class="image fit">
                                <a class="group1" href="{{ URL::asset('img/logo_pic.png') }}" title="test">
                                    <div class="fin">
                                        <img src="{{ URL::asset('img/logo_pic.png') }}" alt="Pic 01" />
                                    </div>
                                    <div class="fir">
                                        <img src="{{ URL::asset('img/logo_pic2.png') }}" alt="Pic 02" />
                                    </div>
                                    <p>進入 →</p>
                                </a>
                            </div>
                        </section>
                        <header>
                            <div class="text_font1">
                                <h3>尚未公布</h3>
                            </div>
                        </header>
                    </article>
                </div>
            </div>
        </section>
        <!-- Banner -->
        <hr class="major">
        <section id="three" class="wrapper">
            <div class="inner">
                <p id="news_text">活動資訊</p>
                <div class="flex flex-3"><!-- 分成多少格 -->
                    <article id="a_animation">
                        <section id="a_img">
                            <div class="image fit">
                                <a class="group1" href="{{ URL::asset('img/news01.jpg') }}" title="2017桃園送聖蹟">
                                    <div class="fin">
                                        <img src="{{ URL::asset('img/logo_pic.png') }}" alt="Pic 01" />
                                    </div>
                                    <div class="fir">
                                        <img src="{{ URL::asset('img/logo_pic2.png') }}" alt="Pic 02" />
                                    </div>
                                    <p>進入 →</p>
                                </a>
                            </div>
                        </section>
                        <header>
                            <div class="text_font1">
                                <h3>2017桃園送聖蹟</h3>
                            </div>
                        </header>
                    </article>
                    <article id="a_animation">
                        <section id="a_img">
                            <div class="image fit">
                                <a class="group1" href="{{ URL::asset('img/過往活動-2017戀戀臺北城.png') }}" title="2017戀戀臺北城">
                                    <div class="fin">
                                        <img src="{{ URL::asset('img/過往活動-2017戀戀臺北城.png') }}" alt="Pic 01" />
                                    </div>
                                    <div class="fir">
                                        <img src="{{ URL::asset('img/logo_pic2.png') }}" alt="Pic 02" />
                                    </div>
                                    <p>進入 →</p>
                                </a>
                            </div>
                        </section>
                        <header>
                            <div class="text_font1">
                                <h3>2017戀戀臺北城</h3>
                            </div>
                        </header>
                    </article>
                    <article id="a_animation">
                        <section id="a_img">
                            <div class="image fit">
                                <a class="group1" href="{{ URL::asset('img/過往活動-2016桃園客家文化節.jpg') }}" title="2016桃園客家文化節">
                                    <div class="fin">
                                        <img src="{{ URL::asset('img/過往活動-2016桃園客家文化節.jpg') }}" alt="Pic 01" />
                                    </div>
                                    <div class="fir">
                                        <img src="{{ URL::asset('img/logo_pic2.png') }}" alt="Pic 02" />
                                    </div>
                                    <p>進入 →</p>
                                </a>
                            </div>
                        </section>
                        <header>
                            <div class="text_font1">
                                <h3>2016桃園客家文化節</h3>
                            </div>
                        </header>
                    </article>
                </div>
            </div>
        </section>
        <section id="three" class="wrapper">
            <div class="inner">
                <p id="news_text">活動歷史</p>
                <div class="flex flex-3"><!-- 分成多少格 -->
                    <article id="a_animation">
                        <section id="a_img">
                            <div class="image fit">
                                <a class="group1" href="{{ URL::asset('img/old_act1.png') }}" title="海客文化藝術季">
                                    <div class="fin">
                                        <img src="{{ URL::asset('img/old_act1.png') }}" alt="Pic 01" />
                                    </div>
                                    <div class="fir">
                                        <img src="{{ URL::asset('img/logo_pic2.png') }}" alt="Pic 02" />
                                    </div>
                                    <p>進入 →</p>
                                </a>
                            </div>
                        </section>
                        <header>
                            <div class="text_font1">
                                <h3>海客文化藝術季展覽</h3>
                            </div>
                        </header>
                    </article>
                    <article id="a_animation">
                        <section id="a_img">
                            <div class="image fit">
                                <a class="group1" href="{{ URL::asset('img/old_act2.png') }}" title="客家漁村小旅行">
                                    <div class="fin">
                                        <img src="{{ URL::asset('img/old_act2.png') }}" alt="Pic 01" />
                                    </div>
                                    <div class="fir">
                                        <img src="{{ URL::asset('img/logo_pic2.png') }}" alt="Pic 02" />
                                    </div>
                                    <p>進入 →</p>
                                </a>
                            </div>
                        </section>
                        <header>
                            <div class="text_font1">
                                <h3>客家漁村小旅行</h3>
                            </div>
                        </header>
                    </article>
                    <article id="a_animation">
                        <section id="a_img">
                            <div class="image fit">
                                <a class="group1" href="{{ URL::asset('img/old_act3.png') }}" title="淘桃散步去">
                                    <div class="fin">
                                        <img src="{{ URL::asset('img/old_act3.png') }}" alt="Pic 01" />
                                    </div>
                                    <div class="fir">
                                        <img src="{{ URL::asset('img/logo_pic2.png') }}" alt="Pic 02" />
                                    </div>
                                    <p>進入 →</p>
                                </a>
                            </div>
                        </section>
                        <header>
                            <div class="text_font1">
                                <h3>淘桃散步去</h3>
                            </div>
                        </header>
                    </article>
                </div>
            </div>
        </section>
@stop
@section('javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-103782278-1', 'auto');
  ga('send', 'pageview');
</script>
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/skel.min.js') }}"></script>
<script src="{{ URL::asset('js/util.js') }}"></script>
<script src="{{ URL::asset('js/main.js') }}"></script>
<script src="{{ URL::asset('js/jquery.colorbox.js') }}"></script>
<script>
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
</script>
@stop