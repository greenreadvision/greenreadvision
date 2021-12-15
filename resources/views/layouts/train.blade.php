
<?php
include app_path() . '/Functions/Letter.php';
$letter = new Letter();

?>
<div class="d-flex">
    <div class="menu px-0 position-fixed bg-dark ">
        <div style="height:55px">
        </div>
        <div>
            <ul class="navbar-nav mr-auto" style="overflow:auto;max-height:calc(100vh - 55px)">
                <li>
                    <a class="train menu-a d-flex navbar-brand px-3 py-2 justify-content-start position-relative" id="train">
                        <i class='fas fa-address-card' style="width:1.2rem"></i><span class="ml-2">第一步：基本資料</span>
                        <i class='position-absolute fas fa-angle-down' style="width:1.2rem;right:2rem"></i>
                    </a>
                    <a class="first menu-a d-flex navbar-brand px-5 py-0 justify-content-start position-relative" id="first">
                        <span style="padding-left:1rem ">&nbsp;</span><i class='fas fa-edit'></i><span class="ml-4">填寫資料</span>
                    </a>
                    <a class="first menu-a d-flex navbar-brand px-5 py-0 justify-content-start position-relative" id="first">
                        <span style="padding-left:1rem">&nbsp;</span><i class='fas fa-print'></i><span class="ml-4">列印資料</span>
                    </a>
                </li>
                <li>
                    <a class="train menu-a d-flex navbar-brand px-3 py-3 justify-content-start position-relative" id="train">
                        <i class='fas fa-briefcase' style="width:1.2rem"></i><span class="ml-2">第二步：了解活動</span>
                        <i class='position-absolute fas fa-angle-down' style="width:1.2rem;right:2rem"></i>
                    </a>
                    <a class="two menu-a d-flex navbar-brand px-5 py-0 justify-content-start position-relative" id="two">
                        <span style="padding-left:1rem">&nbsp;</span><i class='fas fa-film'></i><span class="ml-4">觀看影片</span>
                    </a>
                    <a class="two menu-a d-flex navbar-brand px-5 py-0 justify-content-start position-relative" id="two">
                        <span style="padding-left:1rem">&nbsp;</span><i class='fas fa-question'></i><span class="ml-4">填寫問卷</span>
                    </a>
                </li>
                <li>
                    <a class="train menu-a d-flex navbar-brand px-3 py-3 justify-content-start position-relative" id="train">
                        <i class='fab fa-internet-explorer' style="width:1.2rem"></i><span class="ml-2">第三步：公司網頁</span>
                        <i class='position-absolute fas fa-angle-down' style="width:1.2rem;right:2rem"></i>
                    </a>
                    <a class="three menu-a d-flex navbar-brand px-5 py-0 justify-content-start position-relative" id="three">
                        <span style="padding-left:1rem">&nbsp;</span><i class='fas fa-film'></i><span class="ml-4">觀看影片</span>
                    </a>
                    <a class="three menu-a d-flex navbar-brand px-5 py-0 justify-content-start position-relative" id="three">
                        <span style="padding-left:1rem">&nbsp;</span><i class='fas fa-question'></i><span class="ml-4">填寫問卷</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="content-page px-0 container-fluid">
        @include('layouts.nav')
        <main class="px-4" style="padding:90px 0; ">
            <section class="cd-section">
                <div class="container-fluid p-0 ">
                    @yield('content')
                </div>
                <div id="cd-loading-bar" data-scale="1" class="index"></div> <!-- lateral loading bar -->
            </section>
        </main>
    </div>

</div>
<script type="text/javascript">
    var http = location.pathname;
    var first = document.getElementsByClassName("first");
    var two = document.getElementsByClassName("two");
    var three = document.getElementsByClassName("three");
    var train = document.getElementsByClassName("train");

    if(http.indexOf("first")>=0){
        train[0].style.color = "white";
        if(http.indexOf("edit")>=0){
            first[0].style.color = "white";
        }
        else if(http.indexOf("show")>=0){
            first[1].style.color = "white";
        }
    }
    else if(http.indexOf("two")>=0){
        train[1].style.color = "white";
        if(http.indexOf("video")>=0){
            two[0].style.color = "white";
        }
        else if(http.indexOf("test")>=0){
            two[1].style.color = "white";
        }
    }
    else if(http.indexOf("three")>=0){
        train[2].style.color = "white";
        if(http.indexOf("video")>=0){
            three[0].style.color = "white";
        }
        else if(http.indexOf("test")>=0){
            three[1].style.color = "white";
        }
    }
</script>
