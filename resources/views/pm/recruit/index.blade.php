@extends('layouts.app')
@section('content')

<div style="padding:2cm 3cm;text-align:center;color:black;">
    <div class="col-lg-12 ">
        <img src="{{ URL::asset('img/new logo.png')}}"width="150px">
        <label style="font-size:xxx-large;font-family:DFKai-sb;">歡迎來到 綠雷德文創股份有限公司</label>
    </div>
    <div class="row">
        <div class="col col-lg-2"></div>
        <div class="col align-self-center col-lg-9" style="text-align: left;font-family:DFKai-sb;">
            <div style="word-wrap: break-word; word-break: normal;">
                <h1>要先通過教育訓練才可以算是正職人員，以下三點是這次訓練的摘要。</h1>
                <h2>&nbsp;&nbsp;&nbsp;1.公司人員介紹</h2>
                <h2>&nbsp;&nbsp;&nbsp;2.執行活動時的整體流程</h2>
                <h2>&nbsp;&nbsp;&nbsp;3.公司內部網站以及規則介紹</h2>
                <br>
                <h1>以上都會以書面形式供給你閱讀，閱讀完畢之後會有簡易的測試。</h1>
                <h1>但首先需要你點擊右側按鈕填寫基本資料。</h1>
            </div>
        </div>
    </div>
</div>

<div class="md-5 col-lg-12" style="text-align: end">
    <button class="btn btn-primary " value="train_start" onclick="window.location='{{route('train.first')}}'">下一步</button>
</div>
@stop