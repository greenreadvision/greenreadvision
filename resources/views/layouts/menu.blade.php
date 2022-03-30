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
                
                <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}" >
                    <div id="menu-project-manager" class="icon-link" >
                        <a href="javascript:void(0);" onclick="dropMenu(this)" class="d-flex justify-content-between" style="display: flex;">
                            <div  class="menu-a d-flex navbar-brand py-2 align-items-center justify-content-start position-relative"  >
                                <i class="fas fa-building" style="width:40px"></i> 
                                <span class="ml-2">公司文案</span>
                            </div>
                            <i class="fas fa-chevron-down arrow"></i>
                        </a>                        
                    </div>
                    
                    <ul class="Dropdown_item" id="menu-project-dropdown" >
                        <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                            <a id="menu-project" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('project.index') }}">
                                <span class="ml-2">@lang('customize.Project')</span>
                            </a>
                        </li>
                        <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                            <a id="menu-seal" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('seal.index') }}">
                                <span class="ml-2">用印申請單</span>
                            </a>
                        </li>
                        <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                            <a id="menu-projectSOP" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('projectSOP.index') }}">
                                <span class="ml-2">公司資料庫</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}" >
                    <div id="menu-money-manager" class="icon-link" >
                        <a href="javascript:void(0);" onclick="dropMenu(this)" class="d-flex justify-content-between" style="display: flex;">
                            <div  class="menu-a d-flex navbar-brand py-2 align-items-center justify-content-start position-relative"  >
                                <i class="fas fa-file-invoice-dollar" style="width:40px"></i> 
                                <span class="ml-2">款項管理</span>
                            </div>
                            <i class="fas fa-chevron-down arrow"></i>
                        </a>                        
                    </div>
                    
                    <ul class="Dropdown_item" id="menu-money-dropdown" >
                        <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                            <a id="menu-invoice" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('invoice.index') }}">
                                <span class="ml-2">請款單</span>
                            </a>
                        </li>
                        <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                            <a id="menu-purchase" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('purchase.index') }}">
                                <span class="ml-2">採購單</span>
                            </a>
                        </li>
                        <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                            <a id="menu-service" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('service.index') }}">
                                <span class="ml-2">勞務單</span>
                            </a>
                        </li>
                        <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                            <a id="menu-BusinessTrip" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('businessTrip.index') }}">
                                <span class="ml-2">出差報告表</span>
                            </a>
                        </li>
                        <!--<li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                            <a id="menu-Estimate" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('estimate.index') }}">
                                <i class='fas fa-file-invoice' style="width:40px"></i><span class="ml-2">報價單</span>
                            </a>
                        </li>-->
                    </ul>
                </li>
                <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}" >
                    <div id="menu-people-manager" class="icon-link" >
                        <a href="javascript:void(0);" onclick="dropMenu(this)" class="d-flex justify-content-between" style="display: flex;">
                            <div  class="menu-a d-flex navbar-brand py-2 align-items-center justify-content-start position-relative"  >
                                <i class="fas fa-user" style="width:40px"></i> 
                                <span class="ml-2">人事管理</span>
                            </div>
                            <i class="fas fa-chevron-down arrow"></i>
                        </a>                        
                    </div>
                    
                    <ul class="Dropdown_item" id="menu-people-dropdown" >
                        <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                            <a id="menu-leaveday" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('leaveDay.show',[\Auth::user()->leaveDay->leave_day_id,date('Y').'-apply']) }}">
                                <span class="ml-2">請/補假</span>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}" >
                    <div id="menu-hardward-manager" class="icon-link" >
                        <a href="javascript:void(0);" onclick="dropMenu(this)" class="d-flex justify-content-between" style="display: flex;">
                            <div  class="menu-a d-flex navbar-brand py-2 align-items-center justify-content-start position-relative"  >
                                <i class="fas fa-box" style="width:40px"></i> 
                                <span class="ml-2">硬體管理</span>
                            </div>
                            <i class="fas fa-chevron-down arrow"></i>
                        </a>                        
                    </div>
                    
                    <ul class="Dropdown_item" id="menu-hardward-dropdown" >
                        <li class = "{{\Auth::user()->role == 'intern' ? 'd-none':''}}">
                            <a id="menu-reserve" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('reserve.index') }}">
                                <span class="ml-2">倉儲查詢</span>
                            </a>
                        </li>
                        <li>
                            <a id="menu-goods" class="menu-a d-flex navbar-brand py-2 justify-content-start position-relative" href="{{ route('goods.index') }}">
                               <span class="ml-2">貨單</span>
                            </a>
                        </li>
                    </ul>
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
        <main>
            <section class="cd-section" style="min-height:100vh;padding: 55px 0 45px 0;background-color:rgb(241 250 255); {{\Auth::user()->status == 'general'?'padding-left:220px!important':''}}">
                <div class="container-fluid p-0 ">
                    @yield('content')
                </div>
                <div id="cd-loading-bar" data-scale="1" class="index"></div> <!-- lateral loading bar -->
            </section>
        </main>
    </div>

</div>
