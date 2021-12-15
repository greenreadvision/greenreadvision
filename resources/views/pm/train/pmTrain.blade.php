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
                            <iframe id="pm_ppt" src="https://onedrive.live.com/embed?cid=4F85B04ACBC91E9B&amp;resid=4F85B04ACBC91E9B%212174&amp;authkey=AF5Y-UNsHsBSBVc&amp;em=2&amp;wdAr=1.7777777777777777" width="90%" frameborder="0" frameborder="0">這是 <a target="_blank" href="https://office.com/webapps">Office</a> 提供的內嵌 <a target="_blank" href="https://office.com">Microsoft Office</a> 簡報。</iframe>
                        </div>
                    </div>
                    <div class="col-lg-12 d-flex justify-content-center">
                        <button type="button" class="btn btn-blue" onclick="location.href='{{URL::route('pmTest')}}'">開始測驗</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#pm_ppt').height($('#pm_ppt').width() * 0.56)
    });
    window.onresize = (function() {
        $('#pm_ppt').height($('#pm_ppt').width() * 0.56)
    })
</script>
@stop