@auth
<nav class="navbar navbar-expand-md navbar-light navbar-laravel position-fixed px-5 navbar-style">
    @else
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel position-fixed px-5 navbar-style-not-auth">
        @endauth


        <div class="d-flex justify-content-between w-100">
            <!-- GreenReadvision -->
            <a class="navbar-brand" href="{{ route('home.index') }}" style="color:#98a6ad;font-weight: 600;">
                {{ config('app.name', 'GreenReadvision') }}
            </a>
            <!-- RWD 選單按鈕 -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav ml-auto navbar-nav-rwd">
                <!-- Authentication Links -->
                <!-- 訪客 -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">@lang('customize.Login')</a>
                </li>
                <!-- 會員 -->
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->nickname }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @if (Route::has('register'))
                        <a class="dropdown-item" href="{{ route('register') }}">
                            @lang('customize.Register')
                        </a>
                        @endif
                        @if(\Auth::user()->role=='manager')

                        <a class="dropdown-item" href="{{ route('role.index') }}">
                            @lang('customize.staff')管理
                        </a>

                        @endif
                        <a class="dropdown-item" href="{{ route('profile') }}">
                            {{ __('customize.Profile') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                            {{ __('customize.Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>

        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="menu-rwd px-0">
                <div>
                    <ul class="navbar-nav mr-auto" style="overflow:auto;max-height:calc(100vh - 55px)">
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">@lang('customize.Login')</a>
                        </li>
                        <!-- 會員 -->
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->nickname }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if (Route::has('register'))
                                <a class="dropdown-item" href="{{ route('register') }}">
                                    @lang('customize.Register')
                                </a>
                                @endif

                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    {{ __('customize.Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('customize.Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        <li>
                            <a class=" d-flex navbar-brand px-5 py-2 justify-content-center m-0" href="{{ route('project.index') }}">
                                <span class="ml-2">@lang('customize.Project')</span>
                            </a>
                        </li>
                        <li>
                            <a class=" d-flex navbar-brand px-5 py-2 justify-content-center m-0" href="{{ route('invoice.index') }}">
                                <span class="ml-2">@lang('customize.Invoice')</span>
                            </a>
                            <a class="d-flex navbar-brand px-5 py-2 justify-content-center m-0" href="{{ route('invoice.index') }}">
                                <span class="ml-2">請款</span>
                            </a>
                            <a class="d-flex navbar-brand px-5 py-2 justify-content-center m-0" href="{{ route('purchase.index') }}">
                                <span class="ml-2">採購單</span>
                            </a>
                        </li>
                        <li>
                            <a class=" d-flex navbar-brand px-5 py-2 justify-content-center m-0" href="{{ route('todo.index') }}">
                                <span class="ml-2">@lang('customize.Todo')</span>

                            </a>
                        </li>
                        <li>
                            <a class=" d-flex navbar-brand px-5 py-2 justify-content-center m-0" href="{{ route('calendar.index') }}">
                                <span class="ml-2">@lang('customize.Calendar')</span>
                            </a>
                        </li>
                        <!-- <li><a class="navbar-brand" href="{{ route('offDay.index') }}">@lang('customize.OffDay')</a></li> -->
                        <li>
                            <a class=" d-flex navbar-brand px-5 py-2 justify-content-center m-0" href="{{ route('leaveDay.index') }}">
                                <span class="ml-2">請/補假</span>
                            </a>
                        </li>
                        <li>
                            <a class=" d-flex navbar-brand px-5 py-2 justify-content-center m-0" href="{{ route('businessCar.index') }}">
                                <span class="ml-2">公務車</span>
                            </a>
                        </li>
                        <li>
                            <a class="d-flex navbar-brand px-5 py-2 justify-content-center m-0" href="{{ route('photo.index') }}">
                                <span class="ml-2">相簿</span>
                            </a>
                        </li>
                        <!-- <li><a class="navbar-brand" href="{{ route('photo.index') }}">相簿</a></li> -->

                        @endguest


                    </ul>
                </div>
            </div>
        </div>
    </nav>