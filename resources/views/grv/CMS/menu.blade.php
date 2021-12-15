<div class="d-flex">
    <div class="menu px-0 position-fixed {{\Auth::user()->status != 'general' ? 'd-none':''}}" style="z-index:98">

        <div style="height:54.9px">
        </div>
        <div style="width:220px">
            <ul class="navbar-nav mr-auto" style="overflow:auto;max-height:calc(100vh - 55px)">
                <li>
                    <a id="menu-product" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('product.index') }}">
                        <i class='far fa-file-alt' style="width:50px"></i><span class="ml-2">文創商品</span>
                    </a>
                </li>
                <li>
                    <a id="menu-billboard" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative"  href="{{route('board.index')}}">
                        <i class='fas fa-list-ul' style="width:50px"></i><span class="ml-2">網頁公告</span>
                    </a>
                </li>
                <li>
                    <a id="menu-activity" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative"  href="{{route('activity.index')}}">
                        <i class='fas fa-list-ul' style="width:50px"></i><span class="ml-2">過往活動</span>
                    </a>
                </li>
            </ul>
        </div>

        

    </div>

    <div class="px-0 container-fluid">
        @include('grv.CMS.nav')
        <main class="px-4" style="min-height:100vh;padding:90px 0 45px 0;background-color:rgb(241 250 255); {{\Auth::user()->status == 'general'?'padding-left:74px!important':''}}">
            <section class="cd-section">
                <div class="container-fluid p-0 ">
                    @yield('content')
                </div>
                <div id="cd-loading-bar" data-scale="1" class="index"></div> <!-- lateral loading bar -->
            </section>
        </main>
    </div>

</div>
