@extends('layouts.page')

@section('content')
<div class="modal fade" style="padding-top: 5%" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:90vw;">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"  id="modal-body" style="height: 80vh">
                <div class="col-lg-12 form-group" style="height: 100%; width:100%;">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div id="home-total" class="home" >
    <div id="home-img" >
        <!--<img src="{{ URL::asset('img/綠雷德創新.png') }}" alt="綠雷德創新">-->
        
        <span>綠雷德帶領著國內外小朋友<br/>&emsp;一起「玩感動、感動玩」台灣！<br/>&emsp;&emsp;台北、新竹時光機出發囉！<br/>&emsp;&emsp;&emsp;帶你穿越古時候的小故事。</span>
    </div>
</div>
<div class="row" style="padding:0 7.5%;padding-top:5%;background-color: rgb(255, 255, 255)">
    <div class="col-2">
    </div>
    <div id="news-board" class="col-8 table-style-board">
            <table class="table-home-board" cellpadding="10" border='1' id="board-table">
                <thead>
                    <td><b style="color:black;font-size: 32px">最新消息</b><b style="color:black;font-size: 20px">/News</b></td>
                    <td><a href="{{route('news.index')}}"><b style="color:black;">more</b></a></td>
                </thead>
            </table>
    </div>
    <div class="col-2">
    </div>
</div>
<div id="about-us" class="col col-md-12 col-log-10" style="float:none;margin:auto;padding:0 7.5%;padding-top:5%;background-color: rgb(255, 255, 255)">
        {{--  <div id="about-us" class="col col-md-12 col-log-10"  style="float:none;margin:auto;">  --}}
    <div id="about-as" class="title-style">
        <h3>公司簡介</h3>
        <h4>&nbsp;About us</h4>
    </div>
    <div class="row">
        <div class="about-content col-lg-8 col-md-8 col-sm-8" id="about-content">
            <div class="company-creat">
                <h3 style="color: #DC8749"><i class="fas fa-seedling"></i>&nbsp;綠雷德創新成立</h3>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;綠雷德名字的由來，是從英文『Green Readvision』直接用音譯過來的。綠亦即是『Green』、雷德亦即是『Read』音譯。創辦人的精神是：希望在大自然的環境中，讓親子家庭閱讀到世界的無限視野。
                    我們有感於我們下一代，對於大自然的接觸越來越少，期望用我們團隊的小小力量能夠，帶領著親子家庭從台灣出發，認識台灣的生態、人文、科技、文化等各地方的美麗故事。也從台北出發，發展出台北時光機、桃園時光機、新竹時光機、台南時光機等各地的在地故事系列課程。
                    更藉由服務各縣市的政府單位，推廣更多的在地活動、小旅行、環境教育推廣等讓更多的民眾，認識自己的家鄉、認識在地的環境、認識自己生活的故事。
                </p>
            </div>
            <div class="csr">
                <h3 style="color: #DC8749"><i class="fas fa-users"></i>&nbsp;綠雷德創新的企業社會責任（CSR）</h3>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;致力於親子教育的推廣是我們團隊多年的經驗傳承、智慧累積，更是我們貢獻和回饋於社會的最好方式。希望能夠有更多的機會前進到校園中推廣各式課程和活動、偏鄉的地區。成立的這幾年中，我們團隊用教育的理念讓我們的下一代更認識我們的台灣外，並藉由我們的力量，服務社會做公益。服務過唐氏症寶寶的課程、台北市弱勢家庭的公益2日夏令營、宜蘭偏鄉聯合5校學校到台北的北投活動等。都是我們成立來對社會的回饋，我們也會秉持的這精神繼續往前進，並推廣到國外去。
                </p>
            </div>
        </div>
        <div class="about-year-book col-lg-4 col-md-4 col-sm-4">
            <h3 style="color: #DC8749;"><i class="fas fa-book"></i>&nbsp;綠雷德創新2021回顧</h3>
            <a onclick="AddBook()" class="about-year-book-modal" href="#" data-toggle="modal" data-target='#myModal'>
                <img  src="{{ URL::asset('years/年刊封面.JPG') }}">
            </a>
        </div>
    </div>
</div>
<div style="padding:0;background-color:rgba(255, 255, 255,0.8)">
    <div id="event">
        <div class="title-style">
            <h3>活動花絮</h3>
            <h4>&nbsp;Highlights</h4>
        </div>
        <div class="highlights">
            <div class="col-lg-12">
                    <div style="padding-left: 10px" class="nav-tabs">
                        @foreach ($types as $key => $type)
                            <a class="nav-link type_{{$type['type_id']}}" target='_blank' data-toggle="tab" onclick="window.location = '/activity/{{$type['type_id']}}'" href="#"><span> {{__('customize.' . $type['type_id'])}}</span></a>
                        @endforeach
                    </div>
                    <!--<div class="card border-0 shadow">
                        <div class="tab-content col-lg-12">
                            @foreach ($types as $key => $type)
                                <div id="{{$type['type_id']}}_content" class=" tab-pane fade">
                                    <p>
                                        &nbsp; &nbsp;&nbsp; &nbsp;{{$type['content']}}
                                    </p>
                                    @foreach($activities as $num => $activity)
                                        @if($activity['type'] === $type['type_id'])
                                            <div class="activity-img">
                                                <a href="/activity/{{$activity['activity_id']}}" target='_blank'>
                                                    <img src="{{route('download', $activity['img_path'])}}" >
                                                    <span>{{$activity['organizers']}}<br/>{{$activity['name']}}</span>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>-->
            </div>
        </div>
    </div>
</div>
<div style="padding:0 7.5%;background-color:rgba(255, 255, 255, 0.8)">
    <div id="design">
        <div class="title-style">
            <h3>文創設計</h3>
            <h4>&nbsp;Design</h4>
        </div>
        <div class="swiper-container" id="swiper2">
            <div class="swiper-wrapper">
                @foreach($products as $product)
                <div class="swiper-slide">
                    <a href="{{$product->url}}">
                        <img src="{{route('download', $product['path'])}}" width="100%" height="100%">
                    </a>
                    <p>{{$product['name']}}</p>

                </div>

                @endforeach


            </div>
            <div class="swiper-pagination"></div>
        </div>

    </div>
</div>
<div style="padding:0 7.5%;background-color:rgba(255, 255, 255, 0.8)">
    <div id="video">
        <div class="title-style">
            <h3>影音專區</h3>
            <h4>&nbsp;Video</h4>
        </div>
        <div class="video-box">
            <div id="video-mp4">
                <video class="video-style" controls muted autoplay loop controlslist="nodownload">
                    <source src="{{ URL::asset('img/video/v1005.mp4') }}" type="video/mp4">
                </video>
            </div>
            <div id="video-content">
                <h3>2019戀戀臺北城</h3>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;臺北市的古蹟一直與您我同在 「戀戀臺北城－史蹟趴趴GO」史蹟推廣教育活動，除了與您分享古蹟的知識，並藉由導覽人員精彩的解說將更多古蹟的歷史、一系列的老街、老行業、老地方的典故流傳下去，讓今年的臺北城充滿了濃濃的老味道。</p>
                <a id="videoBtn" href="" style="text-decoration:none;margin: 2% 4%">
                    <div class="bnt-video">
                        <div>
                            <i style="font-size:22px" class='fab fa-youtube'></i>
                        </div>
                        <div>
                            &nbsp;更多影片
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div style="padding:0 7.5%;background-color:rgba(255, 255, 255, 0.8)">
    <div id="contact">
        <div class="title-style">
            <h3>聯絡我們</h3>
            <h4>&nbsp;Contact</h4>
        </div>
        <div class="contact1">
            <div id="contact-information">
                <div>
                    <p><i class="fas fa-building" style="text-align: center;width:24px;"></i> 綠雷德創新股份有限公司
                    </p>
                    <p><i class="fas fa-map-marker-alt" style="text-align: center;width:24px;"></i>
                        地址：台北市大安區忠孝東路三段1號(台北科技大學 光華館 3樓 310室)</p>
                    <p><i class='fas fa-envelope' style='text-align: center;width:24px;'></i>
                        E-mail：greenreadvision@gmail.com</p>
                    <p><i class='fas fa-phone' style='text-align: center;width:24px;'></i>
                        聯絡電話：(02)8772-6321</p>
                    <p><i class="fas fa-file-alt" style="text-align: center;width:24px;"></i>
                        統一編號：90742969</p>
                    <div style="display:flex;justify-content: center;">
                        <a href="https://www.facebook.com/readvisionco/" style="text-decoration:none;margin: 2% 4%">
                            <div class="bnt-fb">
                                <div>
                                    <i style="font-size:20px" class='fab fa-facebook-square'></i>
                                </div>
                                <div>
                                    &nbsp;FaceBook
                                </div>
                            </div>
                            <!-- <a href="" style="text-decoration:none;margin: 2% 4%">
                                <div class="bnt-line">
                                    <div>
                                        <i style="font-size:20px" class='fab fa-line'></i>
                                    </div>
                                    <div>
                                        &nbsp;LINE
                                    </div>
                                </div>
                            </a> -->
                            <a href="https://www.instagram.com/greenreadvision/?igshid=1k6630obswhbt" style="text-decoration:none;margin: 2% 4%">
                                <div class="bnt-ig b-ig">
                                    <div>
                                        <i style="font-size:20px;color:rgba(193,53,132,0.9)" class='fab fa-instagram '></i>
                                    </div>
                                    <div>
                                        &nbsp;Instagram
                                    </div>
                                </div>
                            </a>
                    </div>
                </div>

            </div>
            <div id="contact-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1807.3602006966714!2d121.533957!3d25.043561!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442a97d255598df%3A0x47ea748e8f3f53aa!2z5ZyL56uL6Ie65YyX56eR5oqA5aSn5a24!5e0!3m2!1szh-TW!2sus!4v1568365900979!5m2!1szh-TW!2sus" width="500px" height="400px" frameborder="0" style="box-shadow:5px 5px 10px rgb(0, 0, 0,.5);border:10px #fff solid;" allowfullscreen=""></iframe>
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

{{--  <link href="{{ URL::asset('css/grv/board.css') }}" rel="stylesheet">  --}}

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>

<style>
    #swiper2 {
    }

    #swiper2 .swiper-slide {
        display: block;
        text-align: center;

    }
    

    .swiper-container {
        width: 90%;
    }

    .swiper-father {
        width: 100%;
        position: relative;
        opacity: 0;
    }

    .swiper-btn {
        color: rgb(88, 193, 196);
        outline: none;
        --swiper-navigation-size: 30px;
    }

    @media screen and (max-width:1024px) {
        .swiper-btn {
            --swiper-navigation-size: 20px;
            display: none;
        }

        .swiper-slide {
            display: block;
        }
    }
</style>

<script>
    var boards =[];
    var tr;



    $(document).ready(function() {
        listBoard();
    });
    
    $(window).scroll(function(){
        var home = document.getElementById("home-total");
        var board = document.getElementById("news-board");
        var about = document.getElementById("about-us")
        {{--  var event = document.getElementById("event")
        var design = document.getElementById("design")
        var video = document.getElementById("video")
        var contact = document.getElementById("contact")  --}}
        if($(this).scrollTop()>= board.offsetHeight){
            board.classList.add("leftIn")
        }
        if($(this).scrollTop()>= about.offsetHeight){
            about.classList.add("rightIn")
        }
        {{--  if($(this).scrollTop()>= event.offsetHeight){
            event.classList.add("leftIn")
        }
        if($(this).scrollTop()>= design.offsetHeight){
            design.classList.add("rightIn")
        }
        if($(this).scrollTop()>= video.offsetHeight){
            video.classList.add("leftIn")
        }
        if($(this).scrollTop()>= contact.offsetHeight){
            contact.classList.add("rightIn")
        }  --}}
    });

   function listBoard(){
        boards = getNewBoard();
        var parent = document.getElementById("board-table");
        var board_body = document.createElement("tbody");
        board_body.innerHTML = '<tr>'+
            '<th width="80%"></th>' +
            '<th width="20%"></th>' + 
            '</tr>';
        if(boards.length < 7){
            for(var i = 0 ; i < boards.length ;i++){
                board_body.innerHTML = board_body.innerHTML + setData(i);
            }
        }else{
            for(var i = 0 ; i < 7 ;i++){
                board_body.innerHTML = board_body.innerHTML + setData(i);
            }
        }
        
        
        
        parent.appendChild(board_body);
   }
   

    window.onbeforeunload = function() {
        if (event.clientX > document.body.clientWidth && event.clientY < 0 || event.altKey) {
            event.returnValue="確定離開當前頁面嗎?";
        } else {
            alert("你正在重新整理頁面");
        }
    }
   function setData(val){
        
        
        a = "/news/"+boards[val]['board_id'] + "/show";
        tr =  "<tr>" + 
            "<td width='80%'><a href='" + a + "' target='_blank'>" + boards[val]['title'] + "</td>" +
            "<td width='20%'><a href='" + a + "' target='_blank'>" + boards[val]['updata_date'] + "</td>" +
            "</tr>"

        return tr;
   }

   function getNewBoard(){
    data = "{{$board}}"
    data = data.replace(/[\n\r]/g, "")
    data = data.replace(/&lt;/g, '<')
    data = data.replace(/&gt;/g, '>')
    data = data.replace(/&quot;/g, '"')
    data = data.replace(/	/g,"")
    console.log(data)
    data = JSON.parse(data)
    return data
    }
</script>
<script src="{{ URL::asset('js/all.js') }}"></script>
<script>
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-103782278-1', 'auto');
    ga('require', 'displayfeatures');
    ga('require', 'linkid', 'linkid.js');
    ga('send', 'pageview');
</script>
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
<script src="https://unpkg.com/swiper/js/swiper.min.js"></script>
<script>
    var mySwiper = new Swiper ( ".swiper-home", {
        // 參數設定[註1]
        effect: "cube", // 效果
        loop:true,
        grabCursor: true, // 游標為手掌
        pagination: {
            el: '.swiper-pagination',
        },
        cubeEffect: {
            shadow: true, // 顯示陰影
            slideShadows: true, // 當滑動時，則顯示動陰影
            shadowOffset: 20, // 陰影偏移
            shadowScale: 0.94, // 陰影比例
        },
        navigation: {
            nextEl: ".swiper-button-next", // 上一頁按鈕物件
            prevEl: ".swiper-button-prev", // 下一頁按鈕物件
        }
    })
</script>
<script>
    var swiper1 = new Swiper('#swiper1', {
        speed: 1000,
        loop: true,
        spaceBetween: 1,
        scrollbar: {
            el: '.swiper-scrollbar',
            hide: true,
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

    });
    var view = 0
    if (window.innerWidth > 1024) {
        view = 3
    } else if (window.innerWidth <= 1024 && window.innerWidth > 420) {
        view = 2
    } else {
        view = 1
    }

    var swiper2 = new Swiper('#swiper2', {
        speed: 1000,
        slidesPerView: view,
        slidesPerGroup: view,
        loop: true,
        loopFillGroupWithBlank: true,
        autoplay: {
            delay: 10000,
            disableOnInteraction: false,
        },
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>

<script>
    var modal_content = document.getElementById('modal-body');
    function AddBook(){
        modal_content.innerHTML = "<iframe src=\"{{ URL::asset('years/index.html') }}\" style=\"height: 100%; width:100%;\">你的瀏覽器不支援 iframe</iframe>"
    }
</script>

<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>

<script src="{{ URL::asset('js/homepage.js') }}"></script>
<script src="{{ URL::asset('js/skel.min.js') }}"></script>
<script src="{{ URL::asset('js/util.js') }}"></script>
<script src="{{ URL::asset('js/main.js') }}"></script>
@stop