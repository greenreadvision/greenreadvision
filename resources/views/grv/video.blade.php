@extends('layouts.page')
@section('css')
<link rel="stylesheet" href="{{ URL::asset('css/main.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/videoclassification.css') }}" />
@stop
@section('content')
    <!--TEST-->
    <div class="inner2">
            <h2>影音專區</h2>
            <hr class="major">
            <nav>
                <ul>
                <li><button class="typebutton" id="all">ALL</a></li>
            <!-- <li><button class="typebutton" id="all">ALL</button></li>
                <li><button class="typebutton" id="type1">TYPE</a></li>-->
                </ul>
            </nav>
            <hr class="major2">
        </div>
            
        <!--elements-->
        <section id="three" class="wrapper">
            <div class="inner">
                    <div class="row">
                <div class="4u 12u$(medium) el new"><!--e1-->
                    <article id="a_animation" >
                        <section id="a_img">
                            <div class="image fit">
                                <a href="#">
                                    <div class="fin">
                                        <img src="{{ URL::asset('img/news01.jpg') }}" alt="Pic 01" />
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
                                <h3>test</h3>
                            </div>
                        </header>
                    </article>
                </div>
                <div class="4u 12u$(medium) el"><!--e2-->
                    <article id="a_animation">
                        <section id="a_img">
                            <div class="image fit">
                                <a href="#">
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
                                <h3>test</h3>
                            </div>
                        </header>
                    </article>
                </div>
                <div class="4u 12u$(medium) el type1"><!--e3-->
                    <article id="a_animation">
                        <section id="a_img">
                            <div class="image fit">
                                <a href="#">
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
                                <h3>test</h3>
                            </div>
                        </header>
                    </article>
                </div>
                <div class="4u 12u$(medium) el"><!--e4-->
                    <article id="a_animation">
                        <section id="a_img">
                            <div class="image fit">
                                <a href="../watching.html">
                                    <div class="fin">
                                        <img src="{{ URL::asset('img/news01.jpg') }}" alt="Pic 01" />
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
                                <h3>test</h3>
                            </div>
                        </header>
                    </article>
                </div>
                <div class="4u 12u$(medium) el"><!--e5-->
                    <article id="a_animation">
                        <section id="a_img">
                            <div class="image fit">
                                <a href="#">
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
                                <h3>test</h3>
                            </div>
                        </header>
                    </article>
                </div>
                <div class="4u 12u$(medium) el"><!--e6-->
                    <article id="a_animation">
                        <section id="a_img">
                            <div class="image fit">
                                <a href="#">
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
                                <h3>test</h3>
                            </div>
                        </header>
                    </article>
                    </div>
                    <!--TEST END-->
                </div>
            </div>
        </section>
@stop
@section('javascript')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/filter.js') }}"></script>
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/skel.min.js') }}"></script>
<script src="{{ URL::asset('js/util.js') }}"></script>
<script src="{{ URL::asset('js/main.js') }}"></script>
@stop
<!--<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">-->