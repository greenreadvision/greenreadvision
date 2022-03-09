<?php
include app_path() . '/Functions/Letter.php';
$letter = new Letter();
?>
<div class="d-flex">
    <div class="menu px-0 position-fixed {{\Auth::user()->status != 'general' ? 'd-none':''}}" style="z-index:98">

        <div style="height:54.9px">
        </div>
        <div style="width:220px">
            <ul class="navbar-nav mr-auto" style="overflow:auto;max-height:calc(100vh - 55px)">
                <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                    <a id="menu-project" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('project.index') }}">
                        <i class='far fa-file-alt' style="width:50px"></i><span class="ml-2">@lang('customize.Project')</span>
                    </a>
                </li>
                <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                    <a id="menu-purchase" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('purchase.index') }}">
                        <i class="fas fa-shopping-cart" style="width:50px"></i><span class="ml-2">採購</span>
                    </a>
                </li>
                <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                    <a id="menu-invoice" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('invoice.index') }}">
                        <i class="fas fa-file-invoice-dollar" style="width:50px"></i> <span class="ml-2">請款</span>
                    </a>
                </li>
                <!--<li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                    <a id="menu-Estimate" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('estimate.index') }}">
                        <i class='fas fa-file-invoice' style="width:50px"></i><span class="ml-2">報價單</span>
                    </a>
                </li>-->
                <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                    <a id="menu-BusinessTrip" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('businessTrip.index') }}">
                        <i class="fas fa-business-time" style="width:50px"></i> <span class="ml-2">出差報告表</span>
                    </a>
                </li>
                <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                    <a id="menu-reserve" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('reserve.index') }}">
                        <i class="fas fa-box-open" style="width:50px"></i> <span class="ml-2">倉儲查詢</span>
                    </a>
                </li>
                <li>
                    <a id="menu-goods" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('goods.index') }}">
                        <i class='fas fa-dolly' style="width:50px"></i><span class="ml-2">貨單</span>
                    </a>
                </li>
                <!--<li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                    <a id="menu-todo" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('todo.index') }}">
                        <i class="fas fa-tasks" style="width:50px"></i><span class="ml-2">@lang('customize.Todo')</span>
                    </a>
                </li>
                <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                    <a id="menu-calendar" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('calendar.index') }}">
                        <i class='far fa-calendar-alt' style="width:50px"></i><span class="ml-2">@lang('customize.Calendar')</span>
                    </a>
                </li>-->
                <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                    <a id="menu-service" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('service.index') }}">
                        <i class='fas fa-address-book' style="width:50px"></i><span class="ml-2">勞務單</span>
                    </a>
                </li>
                
                <!-- <li><a class="navbar-brand" href="{{ route('offDay.index') }}">@lang('customize.OffDay')</a></li> -->
                <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                    <a id="menu-leaveday" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('leaveDay.show',[\Auth::user()->leaveDay->leave_day_id,date('Y').'-apply']) }}">
                        <i class='far fa-address-book' style="width:50px"></i><span class="ml-2">請/補假</span>
                    </a>
                </li>
                <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                    <a id="menu-seal" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('seal.index') }}">
                        <i class='fas fa-stamp' style="width:50px"></i><span class="ml-2">用印申請單</span>
                    </a>
                </li>
                <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                    <a id="menu-projectSOP" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('projectSOP.index') }}">
                        <i class='fas fa-cogs' style="width:50px"></i><span class="ml-2">公司資料庫</span>
                    </a>
                </li>
                

            </ul>
        </div>

        <div class="position-absolute w-100 pb-3" style="bottom:0px">
            <ul class="navbar-nav mr-auto">
                <li>
                    <a class=" d-flex navbar-brand px-5 py-2 justify-content-center position-relative" href="{{ route('letter.index') }}">
                        <div class="position-relative">
                            <i class='fas fa-comment-dots mr-3' style='font-size:36px'></i>
                            @if( $letter->getLetter() != 0)
                            <span class="number-of-messages rounded-circle">

                                <?php

                                echo $letter->getLetter();
                                ?>
                            </span>
                            @endif
                        </div>
                    </a>
                </li>
            </ul>
        </div>

    </div>

    <div class="px-0 container-fluid">
        @include('layouts.nav')
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
