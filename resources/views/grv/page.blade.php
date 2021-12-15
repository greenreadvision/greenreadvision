<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-158171906-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-158171906-1');
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="綠雷德文創官方網站。關於綠雷德，綠雷德帶領著國內外小朋友一起「玩感動、感動玩」台灣！台北、新竹時光機出發囉！帶你穿越古時候的小故事。官網中可以找到目前籌辦的活動，提供民眾前往參加報名，迎接新的旅程；也有許多活動後的花絮與大家分享，每次的過程中，大、小朋友一同學習、玩樂的點點滴滴！" />
    <meta name="keywords" content="綠雷德，綠雷德文創股份有限公司，時光機，玩感動，感動玩，參加活動，文化活動，文化體驗遊，">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>綠雷德創新 Green Readvision</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ URL::asset('js/all.js') }}"></script>
    @section('css')
    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/grv/showExternally.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.1.0/css/swiper.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.1.0/css/swiper.min.css" rel="stylesheet" />
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HQVYWV4G6G"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery.js"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-HQVYWV4G6G');
    </script>
    @show
</head>

<body class="subpage" oncontextmenu="return false">
    @section('nav')
    @include('grv.listNav')
    @show
    @yield('content')
    @section('footer')
    @include('grv.footer')
    @show
    @section('javascript')
    <script type="text/javascript" src="{{ URL::asset('js/homepage.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/skel.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/util.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/main.js') }}"></script>
    @show
</body>

</html>