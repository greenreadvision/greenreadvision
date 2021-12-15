@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card border-0 shadow rounded-pill">
        <div class="card-body ">
            <div id="print_box">
                <div style="padding:2cm 3cm;text-align:center;color:black;">
                    <img src="{{ URL::asset('img/new logo.png')}}" width="100px">
                    <label style="font-size:x-large;color:gray;">綠雷德文創股份有限公司 Green ReadVision CO , LTD</label><br>
                    <label style="font-size:xxx-large;">員工基本資料資料表</label>
                    <table class="mb-3" width="100%" border=".5px" style="table-layout: fixed;font-size:20px;line-height:40px;">
                        <tbody>
                            <tr>
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify; padding:0 .1cm" colspan="1">中文名稱</th>
                                <th style="text-align:auto; padding:0 .1cm" colspan="1">{{\Auth::user()->name}}</th>
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify; padding:0 .1cm" colspan="1">性別</th>
                                @if(\Auth::user()->sex =='men')
                                <th style="text-align:auto; padding:0 .1cm" colspan="1">男性</th>
                                @elseif(\Auth::user()->sex =='women')
                                <th style="text-align:auto; padding:0 .1cm" colspan="1">女性</th>
                                @else
                                <th style="text-align:auto; padding:0 .1cm" colspan="1">其他</th>
                                @endif
                                <th style="text-align:auto; padding:0 .1cm" colspan="1" rowspan="6"><img src="{{route('download', explode('/', \Auth::user()->ID_photo))}}" width="90%"></th>
                                </th>
                            </tr>
                            <tr>
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">英文名稱</th>
                                <th style="text-align:auto; padding:0 .1cm" colspan="1">{{\Auth::user()->EN_name}}</th>
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">生日</th>
                                <th style="text-align:auto; padding:0 .1cm" colspan="1">{{\Auth::user()->birthday}}</th>
                            </tr>
                            <tr>
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">公司別名</th>
                                <th style="text-align:auto; padding:0 .1cm" colspan="1">{{\Auth::user()->nickname}}</th>
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">工作名稱</th>
                                <th style="text-align:auto; padding:0 .1cm" colspan="1">{{\Auth::user()->work_position}}</th>
                            </tr>
                            <tr>
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">電子信箱</th>
                                <th style="text-align:left; padding:0 .1cm" colspan="3">{{\Auth::user()->email}}</th>
                            </tr>
                            <tr>
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">緊急聯絡人1</th>
                                <th style="text-align:left; padding:0 .1cm" colspan="3">姓名： {{\Auth::user()->contact_person_name_1}} 電話：{{\Auth::user()->contact_person_phone_1}}</th>
                            </tr>
                            <tr>
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">緊急聯絡人2</th>
                                @if(\Auth::user()->contact_person_2_name!=NULL && \Auth::user()->contact_person_2_phone != NULL)
                                <th style="text-align:left; padding:0 .1cm" colspan="3">姓名： {{\Auth::user()->contact_person_name_2}} 電話：{{\Auth::user()->contact_person_phone_2}}</th>
                                @else
                                <th style="text-align:left; padding:0 .1cm" colspan="3">無</th>
                                @endif
                            </tr>
                            <tr>
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">聯絡電話</th>
                                <th style="text-align:auto; padding:0 .1cm" colspan="1">{{\Auth::user()->phone}}</th>
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">手機電話</th>
                                <th style="text-align:auto; padding:0 .1cm" colspan="2">{{\Auth::user()->celephone}}</th>
                            </tr>
                            <tr>
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">婚姻狀況</th>
                                @if(\Auth::user()->is_marry==0)
                                <th style="text-align:auto; padding:0 .1cm" colspan="1">未婚</th>
                                @else
                                <th style="text-align:auto; padding:0 .1cm" colspan="1">已婚</th>
                                @endif
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">身分證字號</th>
                                <th style="text-align:auto; padding:0 .1cm" colspan="2">{{\Auth::user()->ID_number}}</th>
                            </tr>
                            <tr>
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">到職日</th>
                                <th style="text-align:left; padding:0 .1cm" colspan="4">{{\Auth::user()->arrival_date}}</th>
                            </tr>
                            <tr>
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">戶籍地址</th>
                                <th style="text-align:left; padding:0 .1cm" colspan="4">{{\Auth::user()->residence_address}}</th>
                            </tr>
                            <tr>
                                <th style="text-align:justify;text-justify:distribute-all-lines;text-align-last:justify;padding:0 .1cm" colspan="1">聯絡地址</th>
                                <th style="text-align:left; padding:0 .1cm" colspan="4">{{\Auth::user()->contact_address}}</th>
                            </tr>
                        </tbody>
                    </table>
                    <label style="font-size:large;">本資料僅供綠雷德文創股份有限公司內部使用，一切按照『個資法規定』處理。</label>
                    <table class="mb-3" width="100%" border=".5px" style="table-layout: fixed;font-size:20px">
                        <thead>
                            <tr>
                                <th width="50%"><img src="{{route('download', explode('/', \Auth::user()->IDcard_front_path))}}" width="90%"></th>
                                <th width="50%"><img src="{{route('download', explode('/', \Auth::user()->IDcard_back_path))}}" width="90%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th colspan="1"><img src="{{route('download', explode('/', \Auth::user()->healthCard_front_path))}}" width="90%"></th>
                                <th colspan="1"><img src="{{route('download', explode('/', \Auth::user()->healthCard_back_path))}}" width="90%"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="float: right;">
                <button type="button" id="print_button" class="btn btn-green rounded-pill print_button">{{__('customize.Print')}}</button>
                <form action="print/store" method="post" enctype="multipart/form-data">
                    @csrf
                    <button type="submit" class="btn btn-green rounded-pill next" style="display: none" >下一步</button>
                </form>
            </div>
        </div>
    </div>

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
            let bodyHtml = document.body.innerHTML
            document.body.innerHTML = html
            window.print()
            document.body.innerHTML = bodyHtml
            //window.location.reload() //列印輸出後更新頁面
            next[0].style.display = "block";
            print_box[0].style.display = "none";
        })
    })
    alert("請點選右下角'列印'按鈕進行列印，列印出來後請交給會計人員'海星'");
</script>
@stop