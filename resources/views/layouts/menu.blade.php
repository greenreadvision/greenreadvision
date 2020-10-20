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
                    <a class="menu-a d-flex navbar-brand px-5 py-2 justify-content-start position-relative" href="{{ route('project.index') }}">
                        <i class='far fa-file-alt' style="width:1.2rem"></i><span class="ml-2">@lang('customize.Project')</span>
                        <i class='position-absolute fas fa-angle-right' style="width:1.2rem;right:3rem"></i>
                    </a>
                </li>
                <li>
                    <!-- <a class="menu-a d-flex navbar-brand px-5 py-2 justify-content-start position-relative" href="{{ route('invoice.index') }}">
                        <i class='fas fa-dollar-sign' style="width:1.2rem"></i><span class="ml-2">@lang('customize.Invoice')</span>
                        <i class='position-absolute fas fa-angle-right' style="width:1.2rem;right:3rem"></i>
                    </a> -->
                    <a class="menu-a d-flex navbar-brand px-5 py-2 justify-content-start position-relative" href="javascript:void(0);">
                        <i class='fas fa-dollar-sign' style="width:1.2rem"></i><span class="ml-2">@lang('customize.Invoice')</span>
                        <i class='position-absolute fas fa-angle-down' style="width:1.2rem;right:3rem"></i>
                    </a>
                    <a class="menu-a d-flex navbar-brand px-5 py-0 justify-content-start position-relative" href="{{ route('invoice.index') }}">
                        <span style="width:1.2rem">&nbsp;</span><span class="ml-4">請款</span>
                    </a>
                    <a class="menu-a d-flex navbar-brand px-5 py-0 justify-content-start position-relative" href="{{ route('purchase.index') }}">
                        <span style="width:1.2rem">&nbsp;</span> <span class="ml-4">採購單</span>
                    </a>
                </li>
                <li>
                    <a class="menu-a d-flex navbar-brand px-5 py-2 justify-content-start position-relative" href="{{ route('todo.index') }}">
                        <i class='far fa-calendar-check' style="width:1.2rem"></i><span class="ml-2">@lang('customize.Todo')</span>
                        <i class='position-absolute fas fa-angle-right' style="width:1.2rem;right:3rem"></i>
                    </a>
                </li>
                <li>
                    <a class="menu-a d-flex navbar-brand px-5 py-2 justify-content-start position-relative" href="{{ route('calendar.index') }}">
                        <i class='far fa-calendar-alt' style="width:1.2rem"></i><span class="ml-2">@lang('customize.Calendar')</span>
                        <i class='position-absolute fas fa-angle-right' style="width:1.2rem;right:3rem"></i>
                    </a>
                </li>
                <!-- <li><a class="navbar-brand" href="{{ route('offDay.index') }}">@lang('customize.OffDay')</a></li> -->
                <li>
                    <a class="menu-a d-flex navbar-brand px-5 py-2 justify-content-start position-relative" href="{{ route('leaveDay.index') }}">
                        <i class='far fa-address-book' style="width:1.2rem"></i><span class="ml-2">請/補假</span>
                        <i class='position-absolute fas fa-angle-right' style="width:1.2rem;right:3rem"></i>
                    </a>
                </li>
                <li>
                    <a class="menu-a d-flex navbar-brand px-5 py-2 justify-content-start position-relative" href="{{ route('businessCar.index') }}">
                        <i class='fas fa-car-alt' style="width:1.2rem"></i><span class="ml-2">公務車</span>
                        <i class='position-absolute fas fa-angle-right' style="width:1.2rem;right:3rem"></i>
                    </a>
                </li>
                <li>
                    <a class="menu-a d-flex navbar-brand px-5 py-2 justify-content-start position-relative" href="{{ route('photo.index') }}">
                        <i class='fas fa-file-image' style="width:1.2rem"></i><span class="ml-2">相簿</span>
                        <i class='position-absolute fas fa-angle-right' style="width:1.2rem;right:3rem"></i>
                    </a>
                </li>
                <li>
                    <a class="menu-a d-flex navbar-brand px-5 py-2 justify-content-start position-relative" href="{{ route('todoRecord.index') }}">
                        <i class='fas fa-file-image' style="width:1.2rem"></i><span class="ml-2">todoRecord</span>
                        <i class='position-absolute fas fa-angle-right' style="width:1.2rem;right:3rem"></i>
                    </a>
                </li>
                <!-- <li>
                    <a class="menu-a d-flex navbar-brand px-5 py-2 justify-content-start position-relative" href="{{ route('grvCode') }}">
                        <i class='fas fa-qrcode' style="width:1.2rem"></i><span class="ml-2">實名制</span>
                        <i class='position-absolute fas fa-angle-right' style="width:1.2rem;right:3rem"></i>
                    </a>
                </li> -->

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