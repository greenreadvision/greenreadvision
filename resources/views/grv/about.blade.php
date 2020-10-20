@extends('layouts.eventsPage')
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/aboutwith.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/videoclassification.css') }}" />
    <!--<script type="text/javascript" src="../assets/js/aboutwith.js"></script>-->
@stop
@section('header')
@stop
@section('content')
<!-- main img -->
    <!--TEST-->
    <div class="inner">
    
        <div class="row">
            <div class="12u 12u$(medium) heightu" ><div class="circle"></div></div>
                <div style="margin-bottom:60px;">
                    <div class="text_font1"><h3 style="text-align:left; font-weight:bold">綠雷德文創成立</h3></div>
                    <div class="text_font1"><h4 style="font-weight:bold; color:#5a5858;" >綠雷德名字的由來，是從英文『Green Readvision』直接用音譯過來的。綠亦即是『Green』、雷德亦即是『Read』音譯。創辦人的精神是：希望在大自然的環境中，讓親子家庭閱讀到世界的無限視野。</h4></div>
                    <div class="text_font1"><h4 style="font-weight:bold; color:#5a5858;">我們有感於我們下一代，對於大自然的接觸越來越少，期望用我們團隊的小小力量能夠，帶領著親子家庭從台灣出發，認識台灣的生態、人文、科技、文化等各地方的美麗故事。也從台北出發，發展出台北時光機、桃園時光機、新竹時光機、台南時光機等各地的在地故事系列課程。</h4></div>
                    <div class="text_font1"><h4 style="font-weight:bold; color:#5a5858;">更藉由服務各縣市的政府單位，推廣更多的在地活動、小旅行、環境教育推廣等讓更多的民眾，認識自己的家鄉、認識在地的環境、認識自己生活的故事。</h4></div>
                </div>
                <div>
                    <div class="text_font1"><h3 style="text-align:left; font-weight:bold">綠雷德文創的企業社會責任（CSR）</h3></div>
                    <div class="text_font1"><h4 style="font-weight:bold; color:#5a5858;">致力於親子教育的推廣是我們團隊多年的經驗傳承、智慧累積，更是我們貢獻和回饋於社會的最好方式。希望能夠有更多的機會前進到校園中推廣各式課程和活動、偏鄉的地區。成立的這幾年中，我們團隊用教育的理念讓我們的下一代更認識我們的台灣外，並藉由我們的力量，服務社會做公益。服務過唐氏症寶寶的課程、台北市弱勢家庭的公益2日夏令營、宜蘭偏鄉聯合5校學校到台北的北投活動等。都是我們成立來對社會的回饋，我們也會秉持的這精神繼續往前進，並推廣到國外去。</h4></div>
                </div>
                
                <!--
                <div id="box1" class="12u 12u$(medium) heightu scrEvent text_font1">
                    <div id="rightbox" class="rectangle hideme3 boxText"><h1 class="aboutBody">綠雷德精心舉辦許多活動，帶領著大、小朋友們一同前往各地，進行有趣的探訪，並且從中了解在地文化習俗與歷史背景，讓每個來參加的民眾滿載而歸。</h1></div>
                    <div id="rightbox2" class="circle2 hideme"></div>
                    <div  class="leaf1"><h1 class="leafH1">關於綠雷德</h1></div></div>
                <div id="box2" class="12u 12u$(medium) heightu scrEvent text_font1"><div id="leftbox" class="rectangle"><h1 class="aboutBody"> </h1></div>
                    <div id="leftbox2" class="circle3 hideme"></div>
                    <div  class="leaf2"><h1 class="leafH1">公司理念</h1></div></div>
                <div id="box3" class="12u 12u$(medium) heightu scrEvent text_font1">
                    <div id="rightbox" class="rectangle hideme3 boxText"><h1 class="aboutBody">親子人文教育和國內外營隊<br/>政府活動和執行<br/>設計與服務<br/>文創商品</h1></div>
                    <div id="rightbox2" class="circle4 hideme "></div>
                <div  class="leaf1"><h1 class="leafH1">主要服務</h1></div></div>
                <div id="box4" class="12u 12u$(medium) heightu scrEvent text_font1"><div id="leftbox" class="rectangle"></div>
                    <div id="leftbox2" class="circle5 hideme scrEvent"></div>
                <div  class="leaf2"><h1 class="leafH1">承辦活動經驗</h1></div>-->
            </div>
        </div>
    </div>
@stop
@section('javascript')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/about.js') }}"></script>
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/skel.min.js') }}"></script>
<script src="{{ URL::asset('js/util.js') }}"></script>
<script src="{{ URL::asset('js/main.js') }}"></script>
@stop