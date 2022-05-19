@extends('layouts.page')
@section('content')
<div id="home-total" class="grvPage-top" >
    <div id="grvPage-top-img">
        {{--  <img src="{{ URL::asset('img/綠雷德LOGO.png') }}" alt="綠雷德文創">  --}}
    </div>
</div>
<!--修改頁面-->
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body">
                                <div class="col-lg-12" style="color: black; font-weight:bold">
                                    文章主旨
                                </div>
                                <div class="col-lg-12 text-center">
                                    <h3>{{$board->title}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body">
                                <div class="col-lg-12" style="color: black; font-weight:bold">
                                    公告類型
                                </div>
                                <div class="col-lg-12 text-center"> 
                                    <h3>{{__('customize.'.$board->newTypes)}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div class="card border-0 shadow h-100">
                            <div class="card-body">
                                <div class="col-lg-12" style="color: black; font-weight:bold">
                                    活動內容介紹
                                </div>
                                <div class="col-lg-12">
                                    <span id="content">{!!$board->content!!}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   

<div style="min-height: 200px">
</div>
<script type="text/javascript">

    if (localStorage.pagecount){
        localStorage.pagecount=Number(localStorage.pagecount) +1;
    }else{
        localStorage.pagecount=1;
    }
    document.write("Visits: " + localStorage.pagecount + " time(s).");

    {{--  localStorage.setItem(location.href, 1);
    localStorage.pagecount=1;
    if (localStorage.pagecount){
        localStorage.setItem(location.href, Number(localStorage.getItem(location.href))+1)
    }else{
        localStorage.pagecount=1;
    }
    document.write("Visits: " + localStorage.getItem(location.href) + " time(s).");
    console.log(localStorage.pagecount)  --}}
</script> 
@stop


@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.0/dist/xlsx.full.min.js"></script>
{{--  <script src="{{URL::asset('ckeditor/ckeditor.js') }}"></script>
<script>
    setTimeout(function(){
        var editor = CKEDITOR.replace( 'ckeditor',{
            filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
            language: 'zh-cn',
            
        } ); //Your selector must match the textarea ID
    },400);
</script>  --}}

