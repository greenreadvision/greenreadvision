    <div class="layer"></div>
    <!-- Header -->
    <header id="header">
        <div class="  text_font1">           
            <nav id="nav" >
                <div class="logo">
                    <a id="nav_top" class="logo"><img id="nav_logo" src="{{ URL::asset('img/綠雷德創新logo.png') }}" alt="綠雷德文創"></a>
                </div>
                <a id="n1" href="javascript:void(0);">
                    <div id="go-about" class="nav_cover">
                        公司簡介
                        <b class="nav_b">About us</b>
                    </div>
                </a>
                <!-- <a id="nav_" href="javascript:void(0);"><div id="go-history" class="nav_cover">公司實蹟<b class="nav_b" >History</b></div></a> -->
                <a id="n1" href="javascript:void(0);"><div id="go-event" class="nav_cover">活動花絮<b class="nav_b">Highlights</b></div></a>
                <a id="n1" href="javascript:void(0);"><div id="go-design" class="nav_cover">文創設計<b class="nav_b">Design</b></div></a>
                <a id="n1" href="javascript:void(0);"><div id="go-video" class="nav_cover">影音專區<b class="nav_b">Videos</b></div></a>
                <a id="n1" href="javascript:void(0);"><div id="go-contact" class="nav_cover">聯絡我們<b class="nav_b">Contact</b></div></a>
            </nav>
            <div id="nav2">
                <div id="nav-panel-open" style="display: inline-flex">
                    <i  class='fas fa-bars' style='font-size:24px;'></i>
                </div>
                
                <div id="nav-panel">
                    <div id="nav-panel-close" style="display: inline-flex">
                        <i class='fas fa-times-circle' style='font-size:24px;color:#1d1d1d'></i>
                    </div>
                    <div  id="nav-panel-go-home" style="display: flex;justify-content: center;border-bottom: 1px #d3d3d3 solid;">
                        <!-- <img width="35%" height="auto" src="{{ URL::asset('img/綠雷德LOGO-sm.png') }}" alt="綠雷德文創"> -->
                    </div>
                    <div  id="nav-panel-go-about" style="display: flex;justify-content: center;border-bottom: 1px #d3d3d3 solid;">
                        <div class='nav-panel-style'>
                            公司簡介
                            <b class="nav-panel-b">About as</b>
                        </div>
                    </div>
                    <div id="nav-panel-go-event" style="display: flex;justify-content: center;border-bottom: 1px #d3d3d3 solid;">
                        <div class='nav-panel-style'>
                            活動花絮
                            <b class="nav-panel-b">Highlights</b>
                        </div>
                    </div>
                    <div id="nav-panel-go-design" style="display: flex;justify-content: center;border-bottom: 1px #d3d3d3 solid;">
                        <div class='nav-panel-style'>
                            文創設計
                            <b class="nav-panel-b">Design</b>
                        </div>
                    </div>
                    <div id="nav-panel-go-video" style="display: flex;justify-content: center;border-bottom: 1px #d3d3d3 solid;">
                        <div class='nav-panel-style'>
                            影音專區
                            <b class="nav-panel-b">Videos</b>
                        </div>
                    </div>
                    <div id="nav-panel-go-contact" style="display: flex;justify-content: center;border-bottom: 1px #d3d3d3 solid;">
                        <div class='nav-panel-style'>
                            聯絡我們
                            <b class="nav-panel-b">Contact</b>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- <div style="width:100%;padding:0 5%">
                <a id="nav_panelToggle" href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
            </div> -->
        </div>
    </header>


    <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('js/grvNav.js') }}"></script>