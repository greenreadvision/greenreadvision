@extends('layouts.app')
@section('content')

<div style="padding:2cm 3cm;text-align:center;color:black;">
    <img src="{{ URL::asset('img/new logo.png')}}"width="150px">
    <label style="font-size:xxx-large;">歡迎來到 綠雷德 這個大家庭</label>
    <h1>要使用網站前，請等候主管核准，若要參考文件可以下載以下文件</h1>
    <div style="text-align: left;margin: 5px">
        <div class = "row">
            <h1>活動訓練PPT</h1>
            
        </div>
    </div>
    <div style="text-align: left;margin: 5px" >
        <div class = "row">
            <h1>結案報告書參考文件</h1>
            <button type="button" class="btn btn-blue">下載檔案</button>
        </div>
    </div>
    <div style="text-align: left;margin: 5px">
        <div class = "row">
            <h1>公司網站訓練PPT</h1>
            <button type="button" class="btn btn-blue">下載檔案</button>
        </div>
    </div>
    
</div>
@stop