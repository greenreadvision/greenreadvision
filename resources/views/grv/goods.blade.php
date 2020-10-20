@extends('layouts.page')
@section('css')
<link rel="stylesheet" href="{{ URL::asset('css/main.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/slideBox.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/videoclassification.css') }}" />
@stop
@section('content')
    <!-- Three -->
    <section id="three" class="wrapper Creative">
            <div class="inner">
            <h1 id="title">文創設計</h1>
            
            </div>
        </section>
        <!--TEST-->
        <div class="sliderBox">
            <div class="slider">
                <h2>最近產品</h2>
                <ul class="list" >
                    <li><a><img src="{{ URL::asset('img/thumb/DSC06986.jpg') }}" width="140" height="140" ></a><br>閱野文創鴨舌帽</li>
                    <li><a><img src="{{ URL::asset('img/thumb/DSC07006.jpg') }}" width="140" height="140" ></a><br>閱野文創T恤</li>
                    <li><a><img src="{{ URL::asset('img/閱野文創中書包 (1).jpg') }}" width="140" height="140" ></a><br>閱野文創中書包(黃)</li>
                    <li><a><img src="{{ URL::asset('img/閱野文創中書包(3).jpg') }}" width="140" height="140" ></a><br>閱野文創中書包(紅)</li>
                    <li><a><img src="{{ URL::asset('img/閱野文創中書包(4).jpg') }}" width="140" height="140" ></a><br>閱野文創中書包(綠)</li>
                </ul>
            </div>
            <a id="Test" class="dIcon next">Next</a> <a class="dIcon prev">Prev</a>
        </div>
        <!--TEST-->
        <hr class="major">
        <div class="inner2">
            <h2>產品分類</h2>
            
            <nav>
                <ul>
                    <li><button class="typebutton" id="all">ALL</button></li>
                </ul>
            </nav>
            <hr class="major2">
        </div>
        
        <!--elements-->
        <section id="three" class="wrapper">
            <div class="inner">
                <div class="row">
                    <div class="2u 12u$(medium) el"><!--e1-->
                        <article>
                            <section>
                                <div class="image fit">
                                    <a href="#">
                                        <div class="fin">
                                            <img src="{{ URL::asset('img/thumb/DSC06986.jpg') }}" alt="Pic 01" />
                                        </div>
                                    </a>
                                </div>
                            </section>
                                <div class="text_font1">
                                    <h3>閱野文創鴨舌帽</h3>
                                </div>
                        </article>
                    </div>
                    <div class="2u 12u$(medium) el"><!--e2-->
                            <article>
                            <section>
                                <div class="image fit">
                                    <a href="#">
                                        <div class="fin">
                                            <img src="{{ URL::asset('img/thumb/DSC07006.jpg') }}" alt="Pic 01" />
                                        </div>
                                    </a>
                                </div>
                            </section>
                                <div class="text_font1">
                                    <h3>閱野文創T恤</h3>
                                </div>
                        </article>
                    </div>
                    <div class="2u 12u$(medium) el type1"><!--e3-->
                            <article>
                            <section>
                                <div class="image fit">
                                    <a href="#">
                                        <div class="fin">
                                            <img src="{{ URL::asset('img/閱野文創中書包 (1).jpg') }}" alt="Pic 01" />
                                        </div>
                                    </a>
                                </div>
                            </section>
                                <div class="text_font1">
                                    <h3>閱野文創中書包(黃)</h3>
                                </div>
                        </article>
                    </div>
                    <div class="2u 12u$(medium) el"><!--e4-->
                        <article>
                            <section>
                                <div class="image fit">
                                    <a href="#">
                                        <div class="fin">
                                            <img src="{{ URL::asset('img/閱野文創中書包(3).jpg') }}" alt="Pic 01" />
                                        </div>
                                    </a>
                                </div>
                            </section>
                                <div class="text_font1">
                                    <h3>閱野文創中書包(紅)</h3>
                                </div>
                        </article>
                    </div>
                    <div class="2u 12u$(medium) el"><!--e5-->
                            <article>
                            <section>
                                <div class="image fit">
                                    <a href="#">
                                        <div class="fin">
                                            <img src="{{ URL::asset('img/閱野文創中書包(4).jpg') }}" alt="Pic 01" />
                                        </div>
                                    </a>
                                </div>
                            </section>
                                <div class="text_font1">
                                    <h3>閱野文創中書包(綠)</h3>
                                </div>
                        </article>
                    </div>
                    <div class="2u 12u$(medium) el"><!--e6-->
                        <!-- <article>
                            <section>
                                <div class="image fit">
                                    <a href="#">
                                        <div class="fin">
                                            <img src="{{ URL::asset('img/閱野文創中書包 (4).jpg') }}" alt="Pic 01" />
                                        </div>
                                    </a>
                                </div>
                            </section>
                                <div class="text_font1">
                                    <h3>格1</h3>
                                </div>
                        </article>-->
                    </div>
                    <!--TEST END-->
                </div>
            </div>
        </section>
    <!--TEST END-->
@stop
@section('javascript')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/away.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/filter.js') }}"></script>
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
@stop

<!--<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">-->
