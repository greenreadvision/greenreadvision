@extends('layouts.app')
@section('content')

<div calss="container">
    <div class="row" style="height: 100%">
        <div class="col col-lg-12">
            <div class="card card-style">
                <div class="card-header text-center">
                    <div class="title" style="display:block;">
                        <p style="font-size: 28px;text-align:center;">投影片</p>
                    </div>
                </div>
                <div class="card-body">
                    <div style="text-align: center">
                        <label style="font-size: 30px">請詳細了解投影片內容，再點選中間下方按鈕進行測試。</label>
                    </div>
                    <div class="d-flex justify-content-center " style="padding-top: 15px">
                        <iframe src="https://onedrive.live.com/embed?cid=4F85B04ACBC91E9B&amp;resid=4F85B04ACBC91E9B%212172&amp;authkey=AJhjleWv4f8dkLE&amp;em=2&amp;wdAr=1.7777777777777777" width="962px" height="565px" frameborder="0">這是 <a target="_blank" href="https://office.com/webapps">Office</a> 提供的內嵌 <a target="_blank" href="https://office.com">Microsoft Office</a> 簡報。</iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div style="float: right;">
    <div style="padding-top:15px;padding-right:2cm">
        <button type="button" class="btn btn-secondary" style="display: block" onclick="location.href='{{URL::route('train.two.test')}}'">開始測驗</button>
    </div>
</div>

@stop
<!--<div class="d-flex justify-content-center">
    <div style=" float: right;">
        <button type="button" class="btn btn-dark" onclick="plusDivs(-1)">❮ 上一頁</button>
        <button type="button" class="btn btn-dark" onclick="plusDivs(1)">下一頁 ❯</button>
    </div>
</div>
@section('script')
<script type="text/javascript">
    var slideIndex = 1;
    var test = document.getElementsByClassName("test");
    test[0].style.display = "none";
    
    
    showDivs(slideIndex);

    function VideoFunction(){
        alert("影片播放完畢，請點選右下角「開始測驗」進行小測驗");
        test[0].style.display = "block";
    }

    function plusDivs(n){
        
        showDivs(slideIndex += n);
    }

    function currentDiv(n){
        showDivs(slideIndex = n);
    }

    function showDivs(n){
        var i;
        var x = document.getElementsByClassName("Slides");
        var explanation = document.getElementsByClassName("explanation");
        
        
        if(n > x.length) 
        { 
            slideIndex = x.length
        }
        if(n < 1) 
        {
            slideIndex = 1
        }
        for (i = 0; i < x.length; i++) 
        {
            x[i].style.display = "none";  
        }
        for (i = 0 ; i < explanation.length;i++)
        {
            explanation[i].style.display = "none";
        }
        
        x[slideIndex-1].style.display = "block";  
        explanation[slideIndex-1].style.display = "block";
    }
    
</script>
@stop-->