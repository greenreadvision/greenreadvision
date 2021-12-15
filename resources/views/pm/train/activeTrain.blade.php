@extends('layouts.app')
@section('content')

<div calss="container">
    <div class="d-flex justify-content-center">
        <div class="col-lg-11">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="col-lg-12 d-flex justify-content-center">
                        請詳細了解投影片內容，再點選下方按鈕進行測試。
                    </div>
                    <div class="col-lg-12">
                        <div style="text-align: center">
                            <iframe id="ac_ppt" src="https://onedrive.live.com/embed?cid=4F85B04ACBC91E9B&amp;resid=4F85B04ACBC91E9B%212172&amp;authkey=AJhjleWv4f8dkLE&amp;em=2&amp;wdAr=1.7777777777777777" width="90%" height="" frameborder="0">這是 <a target="_blank" href="https://office.com/webapps">Office</a> 提供的內嵌 <a target="_blank" href="https://office.com">Microsoft Office</a> 簡報。</iframe>
                        </div>
                    </div>
                    <div class="col-lg-12 d-flex justify-content-center">
                        <button type="button" class="btn btn-blue" onclick="location.href='{{URL::route('activeTest')}}'">開始測驗</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="row" style="height: 100%">
        <div class="col col-lg-12">
            <div class="card card-style">
                <div class="card-header text-center">
                    <div class="title" style="display:block;">
                        <p style="font-size: 28px;text-align:center;">投影片</p>
                    </div>
                </div>
                <div class="card-body">
                    <div style="text-align: center">
                        <label style="font-size: 30px">請詳細了解投影片內容，再點選右下角按鈕進行測試。</label>
                    </div>
                    <div class="d-flex justify-content-center " style="padding-top: 15px">
                        <iframe src="https://onedrive.live.com/embed?cid=3D45F91002D878BF&amp;resid=3D45F91002D878BF%21518&amp;authkey=AHaUTXmzgZN0I0c&amp;em=2&amp;wdAr=1.7777777777777777" width="1024px" height="720px" frameborder="0">這是 <a target="_blank" href="https://office.com/webapps">Office</a> 提供的內嵌 <a target="_blank" href="https://office.com">Microsoft Office</a> 簡報。</iframe>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>


@stop
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#ac_ppt').height($('#ac_ppt').width() * 0.56)
    });
    window.onresize = (function() {
        $('#ac_ppt').height($('#ac_ppt').width() * 0.56)
    })
</script>
@stop