<!DOCTYPE HTML>
<!--
	Theory by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>綠雷德文創</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<link rel="stylesheet" href="{{ URL::asset('css/main.css') }}" />
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-103782278-1', 'auto');
		  ga('send', 'pageview');
		</script>
	</head>
	<body class="subpage">
        <div class="layer"></div>
        @extends('layouts.footer')
        @extends('layouts.sample')
        @section('content')
            <!-- Banner -->
            <section id="about">
                <p id="title_A">News<br/>最新消息</p>
            </section>
            <!-- Three -->
            <section id="three" class="news_sec">
                <div class="inner">
				<p id="news_text"></p>
                    <div class=""><!-- 分成多少格 -->
                        <article style="height:320px;">
                            <a href="./" style="text-decoration:none;"><!--working-->
								<div style="float:left;">
									<img src="{{ URL::asset('img/news01.jpg') }}" alt="Pic 01" style="width: 280px;"/>
								</div>
								<div class="text_font1 tran">
									<h2 style="font-weight:bolder">桃園送聖蹟</h2>
								</div>
                            </a>
                        </article>
                        <article style="height:320px;">
                            <a href="./" style="text-decoration:none;"><!--working-->
								<div style="float:left;">
									<img src="{{ URL::asset('img/logo_pic.png') }}" alt="Pic 01" style="width: 280px;"/>
								</div>
								<div class="text_font1 tran">
									<h2 style="font-weight:bolder">敬請期待</h2>
								</div>
                            </a>
                        </article>
                       <article style="height:320px;">
                            <a href="./" style="text-decoration:none;"><!--working-->
								<div style="float:left;">
									<img src="{{ URL::asset('img/logo_pic.png') }}" alt="Pic 01" style="width: 280px;"/>
								</div>
								<div class="text_font1 tran">
									<h2 style="font-weight:bolder">敬請期待</h2>
								</div>
                            </a>
                        </article>
                    </div>
                </div>
            </section>
        @endsection
        <!-- Scripts -->
		<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
		<script src="{{ URL::asset('js/skel.min.js') }}"></script>
		<script src="{{ URL::asset('js/util.js') }}"></script>
		<script src="{{ URL::asset('js/main.js') }}"></script>

	</body>
</html>
