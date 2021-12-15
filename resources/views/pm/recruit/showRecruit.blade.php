@extends('layouts.app')
@section('content')

<div id="print_box" >
    <div style="padding:2cm 3cm;text-align:center;color:black;">
        <img src="{{ URL::asset('img/new logo.png')}}"width="100px">
        <label style="font-size:x-large;color:gray;">綠雷德文創股份有限公司 Green ReadVision CO , LTD</label><br>
        <label style="font-size:xxx-large;">員工基本資料資料表</label>
        <table class="mb-3" width="100%" border=".5px"  style="table-layout: fixed;font-size:20px;line-height:40px;">
            <thead>
                <tr>
                    <th width="17.5%"></th>
                    <th width="17.5%"></th>
                    <th width="17.5%"> </th>
                    <th width="17.5%"></th>
                    <th width="30%"> </th>
                </tr>
            </thead>
            <tbody >
                <tr>
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify; padding:0 .1cm" colspan="1">中文名稱</th>
                    <th style="text-align:auto; padding:0 .1cm" colspan="1">{{$recruit->user_name_CH}}</th>
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify; padding:0 .1cm" colspan="1">性別</th>
                    @if($recruit->sex=='men')
                    <th style="text-align:auto; padding:0 .1cm" colspan="1">男性</th>
                    @elseif($recruit->sex=='women')
                    <th style="text-align:auto; padding:0 .1cm" colspan="1">女性</th>
                    @else
                    <th style="text-align:auto; padding:0 .1cm" colspan="1">其他</th>
                    @endif
                    <th style="text-align:auto; padding:0 .1cm" colspan="1" rowspan="6"><img src="{{route('show', $recruit->photo_path)}}" alt=""  width="200px"></th></th>
                </tr>
                <tr>
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">英文名稱</th>
                    <th style="text-align:auto; padding:0 .1cm" colspan="1">{{$recruit->user_name_EN}}</th>
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">生日</th>
                    <th style="text-align:auto; padding:0 .1cm" colspan="1">{{$recruit->birthday}}</th>
                </tr>
                <tr>
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">公司別名</th>
                    <th style="text-align:auto; padding:0 .1cm" colspan="1">{{$recruit->nickname}}</th>
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">工作名稱</th>
                    <th style="text-align:auto; padding:0 .1cm" colspan="1">{{$recruit->work_position}}</th>
                </tr>
                <tr>
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">電子信箱</th>
                    <th style="text-align:left; padding:0 .1cm" colspan="3">{{$recruit->Email}}</th>
                </tr>
                <tr>
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">緊急聯絡人1</th>
                    <th style="text-align:left; padding:0 .1cm" colspan="3">姓名： {{$recruit->contact_person_1_name}} 電話：{{$recruit->contact_person_1_phone}}</th>
                </tr>
                <tr>
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">緊急聯絡人2</th>
                    @if($recruit->contact_person_2_name!=NULL && $recruit->contact_person_2_phone != NULL)
                    <th style="text-align:left; padding:0 .1cm" colspan="3">姓名： {{$recruit->contact_person_2_name}} 電話：{{$recruit->contact_person_2_phone}}</th>
                    @else
                    <th style="text-align:left; padding:0 .1cm" colspan="3">無</th>
                    @endif
                </tr>
                <tr>
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">聯絡電話</th>
                    <th style="text-align:auto; padding:0 .1cm" colspan="1">{{$recruit->phone}}</th>
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">手機電話</th>
                    <th style="text-align:auto; padding:0 .1cm" colspan="2">{{$recruit->celephone}}</th>
                </tr>
                <tr>
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">婚姻狀況</th>
                    @if($recruit->marry==0)
                    <th style="text-align:auto; padding:0 .1cm" colspan="1">未婚</th>
                    @else
                    <th style="text-align:auto; padding:0 .1cm" colspan="1">已婚</th>
                    @endif
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">身分證字號</th>
                    <th style="text-align:auto; padding:0 .1cm" colspan="2">{{$recruit->IDcard_number}}</th>
                </tr>
                <tr>
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">到職日</th>
                    <th style="text-align:left; padding:0 .1cm" colspan="4">{{$recruit->first_day}}</th>
                </tr>
                <tr>
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">戶籍地址</th>
                    <th style="text-align:left; padding:0 .1cm" colspan="4">{{$recruit->residence_address}}</th>
                </tr>
                <tr>
                    <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">聯絡地址</th>
                    <th style="text-align:left; padding:0 .1cm" colspan="4">{{$recruit->contact_address}}</th>
                </tr>
            </tbody>
        </table>
        <label style="font-size:large;">本資料僅供綠雷德文創股份有限公司內部使用，一切按照『個資法規定』處理。</label>
        <table class="mb-3" width="100%" border=".5px" style="table-layout: fixed;font-size:20px">
            <thead>
                <tr>
                    <th width="50%"><img src="{{route('show', $recruit->front_of_IDcard_path)}}" alt="" width="300px"></th>
                    <th width="50%"><img src="{{route('show', $recruit->back_of_IDcard_path)}}" alt="" width="300px"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th colspan="1"><img src="{{route('show', $recruit->front_of_healthCard_path)}}" alt="" width="300px"></th>
                    <th colspan="1"><img src="{{route('show', $recruit->back_of_healthCard_path)}}" alt="" width="300px"></th>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div style="float: right;">
    <button type="button" id="print_button" class="btn btn-primary btn-primary-style print_button">{{__('customize.Print')}}</button>
    <button type="button" class="btn btn-primary btn-primary-style next" style="display: none" onclick="location.href='{{URL::route('train.two')}}'">下一步</button>
</div>
@stop
@section('script')
<script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript">
    var next = document.getElementsByClassName("next");
    var print_box = document.getElementsByClassName("print_button");
    $(document).ready(() => {
        $('#print_button').click(() => {
            let html = document.getElementById('print_box').innerHTML
            console.log(html)
            let bodyHtml = document.body.innerHTML
            document.body.innerHTML = html
            window.print()
            document.body.innerHTML = bodyHtml
            //window.location.reload() //列印輸出後更新頁面
            next[0].style.display = "block";
            print_box[0].style.display = "none";
        })
    })
</script>
@stop