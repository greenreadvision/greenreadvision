@extends('layouts.page')
@section('css')
<link rel="stylesheet" href="{{ URL::asset('css/main.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/watching.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/videoclassification.css') }}" />
@endsection
@section('header')
<header id="main_area">
    <section id="n_img">
        <div>
            <img src="{{ URL::asset('img/main-04.jpg') }}" alt="main img" />
        </div>
    </section>
</header>
@stop
@section('content')
<!-- main img -->
    <!--TEST-->
    <div class="inner2">
            <h3>意見／回饋</h3>
            
            <form method="post" action="#">
                <div class="row uniform">
                    <div class="6u 12u$(xsmall)">
                        <input type="text" name="name" id="name" value="" placeholder="Name" />
                    </div>
                    <div class="3u 12u$(small)">
                        <input type="radio" id="priority-low" name="priority" checked>
                            <label for="priority-low">先生</label>
                            </div>
                    <div class="3u$ 12u$(small)">
                        <input type="radio" id="priority-high" name="priority">
                            <label for="priority-high">女士</label>
                            </div>
                    <!-- Break -->
                    <div class="8u 12u$(xsmall)">
                        <input type="email" name="email" id="email" value="" placeholder="Email" />
                    </div>
                    
                                                <!-- Break -->
                    <div class="4u 12u$(small)">
                        <input type="checkbox" id="copy" name="copy">
                            <label for="copy">Email me a copy of this message</label>
                            </div>
                    
                    <!-- Break -->
                    <div class="12u$">
                        <textarea name="message" id="message" placeholder="Enter your message" rows="6"></textarea>
                    </div>
                    <!-- Break -->
                    <div class="4u 12u">
                        <ul class="actions">
                            <li><input type="submit" value="Send Message" /></li>
                            <li><input type="reset" value="Reset" class="alt" /></li>
                        </ul>
                    </div>
                    <div class="6u$ 12u$(small)">
                        <input type="checkbox" id="human" name="human">
                            <label for="human">I am a human and not a robot</label>
                            </div>
                </div>
            </form>
        </div>
        
        <div class="inner2">
            <h3>其他聯絡方式</h3>
        </div>
@stop
@section('javascript')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/filter.js') }}"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-103782278-1', 'auto');
  ga('send', 'pageview');
</script>
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/skel.min.js') }}"></script>
<script src="{{ URL::asset('js/util.js') }}"></script>
<script src="{{ URL::asset('js/main.js') }}"></script>
@stop
<!--<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">-->
