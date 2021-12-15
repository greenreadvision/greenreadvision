@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow">
            <div class="card-body ">
                <div class="mb-3">
                    <div class="col-lg-12 d-flex justify-content-end">
                        <div class="col-lg-4 d-flex align-items-center justify-content-end">
                            @if($seal->status == 'waiting')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>第一階段審核中</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-danger' role='progressbar' style='width: 0%' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif($seal->status == 'waiting-fix')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>請款被撤回，請修改</small>
                                </div>
                                <div class='progress w-100' data-toggle='tooltip' data-placement='top' title='修改中'>
                                    <div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif($seal->status == 'managed')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>審核完成，已可借用 {{$seal->seal_type}}</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-warning' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif($seal->status == 'complete')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>已用印完成並歸還</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-info' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <button type="button" id="print_button" class="btn btn-blue rounded-pill"><span class="mx-2">列印</span></button>
                        @if(($seal->status == 'waiting' || $seal->status == 'waiting-fix') && (\Auth::user()->user_id == $seal->user_id ||\Auth::user()->role=='administrator'||\Auth::user()->role== $seal->seal_user_id))
                        <button class="ml-2 btn btn-green rounded-pill" onclick="location.href='{{route('seal.edit', $seal->seal_id)}}'"><span class="mx-2"> {{__('customize.Edit')}}</span></button>
                    @endif
                    </div>
                    
                </div>
                <div class="mb-3" id="print_box" name="print_box">
                    <!--print_start min-width:1043px;min-height:485px;-->
                    <div style="padding:2cm 2cm;text-align:center;color:black;font-size:1rem;font-family: DFKai-sb,Times New Roman,STKaiti;">
                        <div class="col-md-12" style="text-align:right   ;"><label>{{__('customize.id')}} : {{$seal->final_id}}</label></div>
                        <div class="col-md-12 table-style" style="text-align:center;">
                           @if($seal->company == 'grv')
                            <img src="{{ URL::asset('img/綠雷德LOGO.png') }}" height="50px">
                            <label style="font-size:xx-large;">綠雷德文創股份有限公司</label>
                             @elseif($seal->company == 'rv')
                            <img src="{{ URL::asset('img/rv_logo.png') }}" height="50px">
                            <label style="font-size:xx-large;">閱野文創股份有限公司</label>
                            @elseif($seal->company == 'grv_2')
                            <img src="{{ URL::asset('img/綠雷德創新logo.png') }}" height="50px">
                            <label style="font-size:xx-large;">綠雷德創新股份有限公司</label>
                            @endif
                            <h3 class="mb-2">公司章用印申請書</h3>
                            <table class="table border border-dark">
                                <tbody>
                                    <tr class="border border-dark">
                                        <th width="20%" class="align-middle text-center border border-dark " style="white-space:nowrap;">申請日期</th>
                                        <td style="font-size: 16px" width="30%" class="border border-dark align-middle text-left">{{$seal->create_day}}</td>
                                        <th width="20%" class="align-middle text-center border border-dark " style="white-space:nowrap;">用印對象</th>
                                        <td style="font-size: 16px" width="30%" class="border border-dark align-middle text-left">{{$seal->object}}</td>
                                    </tr>
                                    <tr class="border border-dark">                                            
                                        <th class="align-middle text-center border border-dark " style="white-space:nowrap;">用印章別</th>
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left">{{$seal->seal_type}}</td>
                                        <th class="align-middle text-center border border-dark " style="white-space:nowrap;">文件類別</th>
                                        @if($seal->file_type == '其他')
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left">{{$seal->file_type}}：{{$seal->file_other_content}}</td>
                                        @else
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left">{{$seal->file_type}}</td>
                                        @endif
                                    </tr>
                                    <tr class="border border-dark">
                                        <th class="align-middle text-center border border-dark " style="white-space:nowrap;">合約期限</th>
                                        @if($seal->contract_end_date ==null)
                                        <td style="font-size: 16px" colspan="3" class="border border-dark align-middle text-left">限民國{{substr($seal->contract_first_date , 0,4)-1911}}年{{substr($seal->contract_first_date , 5,2)}}月{{substr($seal->contract_first_date , 8,2)}}日當天使用</td>
                                        @else
                                        <td style="font-size: 16px" colspan="3" class="border border-dark align-middle text-left">自民國{{substr($seal->contract_first_date , 0,4)-1911}}年{{substr($seal->contract_first_date , 5,2)}}月{{substr($seal->contract_first_date , 8,2)}}日至民國{{substr($seal->contract_end_date , 0,4)-1911}}年{{substr($seal->contract_end_date , 5,2)}}月{{substr($seal->contract_end_date , 8,2)}}日止</td>
                                        @endif
                                    </tr>
                                    <tr class="border border-dark">
                                        <th class="align-middle text-center border border-dark " style="white-space:nowrap;">申請事項</th>
                                        <td style="font-size: 16px" colspan="3" class="border border-dark align-middle text-left">{{$seal->content}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 row" style="margin: auto; display:flex">
                            <div style="width:25%;text-align:left;"><label>用印者：</label><u>　{{$seal['seal_user']->name}}　.</u></div>
                            <div style="width:25%;text-align:left;"><label>主管簽核同意：</label><u>　{{$seal->managed!= null? $seal->managed:'　　'}}　.</u></div>
                            <div style="width:25%;text-align:left;"><label>申請人：</label><u>　{{$seal['user']->name}}　.</u></div>
                            <div style="width:25%;text-align:left;"><label>歸還證明：</label><u>　{{$seal->status=="complete" ? $seal['seal_user']->name : '　　'}}　.</u></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 d-flex justify-content-between">
                    <!-- waiting -->
                    @if($seal->status == 'waiting'&&(\Auth::user()->role=='proprietor'))
                    <div class="col-lg-8 p-0" style="text-align:center;">
                        <form action="withdraw" method="POST">
                            @csrf
                            <div class="form-row align-items-center">
                                <div class="col-lg-6 my-1">
                                    <input autocomplete="off" type="text" class="rounded-pill form-control" name="reason" placeholder="原因" required>
                                </div>
                                <div class="float-left">
                                    <button type="submit" class="btn btn-red rounded-pill">撤回</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <form action="match" method="POST">
                        @csrf
                        <!-- <input type="text" name="finished_id" class="form-control" placeholder="@lang('customize.finished_id')" required> -->
                        <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">第一階段審核</span></button>
                    </form>
                    @elseif($seal->status == 'managed'&&(\Auth::user()->user_id== $seal->seal_user_id))
                    <div class="col-lg-12 d-flex justify-content-center">
                        <form action="match" method="POST">
                            @csrf
                            <!-- <input type="text" name="finished_id" class="form-control" placeholder="@lang('customize.finished_id')" required> -->
                            <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">印章已經使用完畢並歸還</span></button>
                        </form>
                    </div>
                    
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(() => {
        $('#print_button').click(() => {
            let html = document.all['print_box'].innerHTML

            let bodyHtml = document.body.innerHTML
            document.body.innerHTML = html
            window.print()
            document.body.innerHTML = bodyHtml
            window.location.reload() //列印輸出後更新頁面
        })
    })
</script>
@stop