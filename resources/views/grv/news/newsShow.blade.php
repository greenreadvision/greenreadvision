@extends('layouts.page')
@section('content')

<div id="home-total" class="grvPage-top" >
    <div id="grvPage-top-img">
        <img src="{{ URL::asset('img/綠雷德LOGO.png') }}" alt="綠雷德文創">
    </div>
</div>
<div class="d-flex justify-content-center grvPage-content" style="padding:0 7.5%;padding-top:2.5%">
    <div class="col-lg-9 mb-2">
        <div class="row" >
            <div class="col-lg-3 Side">
                <div class="title">
                    <h3>消息分類</h3>
                    <button type="button" onclick="changeType('News')"><span>最新消息</span></button>
                    <button type="button" onclick="changeType('service')"><span>服務項目</span></button>
                    <button type="button" onclick="changeType('question')"><span>常見問題</span></button>
                </div>
                <div class="title">
                    <h3>社群連結</h3>
                </div>
            </div>
            <div class="col-lg-9" id="new_title">
                <div class="row">
                    @switch($board->newTypes)
                    @case ("news")
                        <div class="col-lg-9">
                            <h2 style="margin: 0 0 10px 0">NEWS/最新消息</h2>
                        </div>
                        <div class="col-lg-3" style="padding:0 0 0 0;color: black">
                            <a href="{{route('news.index')}}" style="color: black;text-decoration:none;"><span style="text-align: right" >佈告欄></span></a><span style="text-align: right"> NEWS/最新消息</span>
                        </div>
                        @break
                    @case ("service")
                        <div class="col-lg-9">
                            <h2 style="margin: 0 0 10px 0">NEWS/最新消息</h2>
                        </div>
                        <div class="col-lg-3" style="padding:0 0 0 0;color: black">
                            <a href="{{route('news.index')}}" style="color: black;text-decoration:none;"><span style="text-align: right" >佈告欄></span></a><span style="margin: 0 0 10px 0">SERVICES/服務項目</span>
                        </div>
                        @break
                    @case ("question")
                        <div class="col-lg-9">
                            <h2 style="margin: 0 0 10px 0">NEWS/最新消息</h2>
                        </div>
                        <div class="col-lg-3" style="padding:0 0 0 0;color: black">
                            <a href="{{route('news.index')}}" style="color: black;text-decoration:none;"><span style="text-align: right" >佈告欄></span></a><span style="margin: 0 0 10px 0">QUESTION/常見問題</span>
                        </div>
                        @break
                    @default
                        @break
                    @endswitch
                </div>
                    
                <hr  style="border-color: black;margin: auto;"  align="center" width="100%"/>
                <div style="width: 100%">
                    
                </div>
                
                
            </div>
        </div>
    </div>
</div>

@stop
