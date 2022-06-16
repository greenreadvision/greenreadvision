@extends('layouts.app')
@section('content')
<div class="page_level">
    <div class="page_show">
        <div class="page_title" id="page_title">
            <a  href="/change" class="page_title_a" >系統更動申請表單</a>
            <i class="fas fa-chevron-right page_title_arrow"></i>
            <span class="page_title_span">{{$data['change']['finished_id']}}</span>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center" >
    <div class="col-lg-11">
        <div class="card border-0 shadow">
            <div class="card-body ">
                @if($data['change']['status'] == 'delete')
                <div style="position: absolute;width:100%;height:100%;display:flex;justify-content:center;align-items:center" >
                    <img style="width:70%" src="{{ URL::asset('gif/cancelled.png') }}" alt=""/>
                </div>
                @endif
                <div class="mb-3">
                    <div class="col-lg-12 d-flex justify-content-end">
                        <div class="col-lg-4 d-flex align-items-center justify-content-end">
                            @if ($data['change']['status'] == 'first')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>第一階段審核中</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-danger' role='progressbar' style='width: 0%' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($data['change']['status'] == 'first-fix')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>第一階段被撤回，請修改</small>
                                </div>
                                <div class='progress w-100' data-toggle='tooltip' data-placement='top' title='修改中'>
                                    <div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>

                            @elseif ($data['change']['status'] == 'second')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>第二階段審核中</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-danger' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($data['change']['status'] == 'second-fix')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>第二階段被撤回，請修改</small>
                                </div>
                                <div class='progress w-100' data-toggle='tooltip' data-placement='top' title='修改中'>
                                    <div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>

                            @elseif ($data['change']['status'] == 'third')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>第三階段審核中</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-danger' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($data['change']['status'] == 'third-fix')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>第三階段被撤回，請修改</small>
                                </div>
                                <div class='progress w-100' data-toggle='tooltip' data-placement='top' title='修改中'>
                                    <div class='progress-bar progress-bar-striped bg-danger progress-bar-animated' role='progressbar' style='width: 75%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>

                            @elseif ($data['change']['status'] == 'matched')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>更動處理中</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-success' role='progressbar' style='width: 75%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif ($data['change']['status'] == 'complete')
                            <div class="w-100">
                                <div class="w-100 text-center">
                                    <small>更動處理完成</small>
                                </div>
                                <div class='progress w-100'>
                                    <div class='progress-bar bg-info' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>
                            @elseif($data['change']['status'] == 'delete')
                            <div class="w-100">
                                <div class="w-100" style="display: flex;justify-content: flex-end;">
                                    <span>已註銷，無法使用</span>
                                </div>
                            </div>
                            @endif
                        </div>
                        @if($data['change']['status'] == 'delete')
                            <button class="ml-2 btn btn-gray rounded-pill"><span class="mx-2"> 無法{{__('customize.Edit')}}</span></button>
                        @elseif(\Auth::user()->user_id==$data['change']['user_id']||\Auth::user()->role=='administrator'|| \Auth::user()->role =='manager')
                            <button class="ml-2 btn btn-green rounded-pill" onclick="location.href='{{route('change.edit', $data['change']['id'])}}'"><span class="mx-2"> {{__('customize.Edit')}}</span></button>
                        @endif
                    </div>
                </div>
                <div class="mb-3" id="print_box" name="print_box">
                    <!--print_start min-width:1043px;min-height:485px;-->
                    <div style="padding:2cm 2cm;text-align:center;color:black;font-size:1rem;font-family: DFKai-sb,Times New Roman,STKaiti;">
                        <div class="col-md-12" style="text-align:right   ;"><label>申請單號 : {{$data['change']['finished_id']}}</label></div>
                        <div class="col-md-12" style="text-align:right   ;"><label>申請日期 : {{$data['change']['created_at']->format('Y-m-d')}}</label></div>
                            <h3 class="mb-2">系統更動申請單</h3>

                            <table class="table border border-dark">
                                <tbody>
                                    <tr class="border border-dark">
                                        <th width="10%" class="border border-dark align-middle text-center" style="white-space:nowrap;">最晚完成期限</th>
                                        <td style="font-size: 16px" width="40%" class="border border-dark align-middle text-left">{{$data['change']['urgency']}}</td>
                                        <th width="10%" class="border border-dark align-middle text-center" style="white-space:nowrap;">完成日期</th>
                                        <td style="font-size: 16px" width="40%" class="border border-dark align-middle text-left">{{$data['change']['finished_date']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">申請類別</th>
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left" style="white-space: pre-line;">{{$data['change']['change_type']}}</td>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">申請項目</th>
                                        <td style="font-size: 16px" class="border border-dark align-middle text-left" style="white-space: pre-line;">{{$data['change']['title']}}</td>
                                    </tr>
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">申請更動事項</th>
                                        <td colspan="3" class="border border-dark align-middle text-left" style="white-space: pre-line;">
                                            <div class="form-group">
                                                <label style="font-size: 16px" >{{$data['change']['content']}}</label>
                                            </div>
                                        </td>
                                    </tr>
                                    @if($data['change']['status']=='first-fix'||$data['change']['status']=='second-fix'||$data['change']['status']=='third-fix')
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">申請撤回原因</th>
                                        <td colspan="3" class="border border-dark align-middle text-left" style="white-space: pre-line;">
                                            <div class="form-group">
                                                <label style="font-size: 16px">{{$data['change']['withdraw_reason']}}</label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                    @if($data['change']['finished_message']!=null)
                                    <tr>
                                        <th class="border border-dark align-middle text-center" style="white-space:nowrap;">完成更動說明</th>
                                        <td colspan="3" class="border border-dark align-middle text-left" style="white-space: pre-line;">
                                            <div class="form-group">
                                                <label style="font-size: 16px">{{$data['change']['finished_message']}}</label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 row" style="margin: auto; display:flex">
                            <div style="width:20%;text-align:left;"><label>行政審核：</label><u>　{{$data['change']['status']=='second'||$data['change']['status']=='third'||$data['change']['status']=='matched'||$data['change']['status']=='complete'? "蔡貴瑄":'　　'}}　.</u></div>
                            <div style="width:20%;text-align:left;"><label>主管審核：</label><u>　{{$data['change']['status']=='third'||$data['change']['status']=='matched'||$data['change']['status']=='complete'? $data['change']['managed']:'　　'}}　.</u></div>
                            <div style="width:20%;text-align:left;"><label>執行長審核：</label><u>　{{$data['change']['status']=='matched'||$data['change']['status']=='complete'? "吳奇靜":'　　'}}　.</u></div>
                            <div style="width:20%;text-align:left;"><label>更動處理：</label><u>　{{$data['change']['status']=='complete'? $data['change']['matched']:'　　'}}　.</u></div>
                            <div style="width:20%;text-align:left;"><label>申請人：</label><u>　{{($data['change']->user->role == 'manager' && $data['change']['intern_name']!=null) ? $data['change']['intern_name'] : $data['change']->user->name}}　.</u></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-3 d-flex justify-content-center">
                    <div>
                        @if (is_array($data['change']['file']))
                        <a class="btn btn-blue rounded-pill" href="{{route('changedownload', $data['change']['file'])}}">額外說明檔案</a>
                        @endif
                    </div>
                </div>
                {{--  <div class="col-lg-12 mb-3 d-flex justify-content-center">
                    <div>
                        @if (is_array($data['change']['finished_file']))
                        <a class="btn btn-blue rounded-pill" href="{{route('changedownload', $data['change']['finished_file'])}}">完成更動說明檔案</a>
                        @endif
                    </div>
                </div>  --}}
                <div class="col-lg-12 d-flex justify-content-between">
                    @if($data['change']['status']=='first'&&(\Auth::user()->role=='administrator')) 
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
                            <label>行政審核：</label>
                            <input type="text" name="managed" class="rounded-pill form-control" value={{\Auth::user()->name}} readonly>
                            <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">第一階段審核</span></button>
                        </form>
                    @elseif($data['change']['status']=='second'&&(\Auth::user()->role=='supervisor'))
                        <div class="col-lg-8 p-0" style="text-align:center;">
                            <form action="withdraw" method="POST">
                                @csrf
                                <div class="form-row align-items-center">
                                    <div class="col-lg-6 ">
                                        <input autocomplete="off" type="text" class="rounded-pill form-control" name="reason" placeholder="原因" required>
                                    </div>
                                    <button type="submit" class="btn btn-red rounded-pill">撤回</button>
                                </div>
                            </form>
                        </div>
                        <form action="match" method="POST" class="d-flex justify-content-between">
                            @csrf
                            <label>主管審核：</label>
                            <input type="text" name="managed" class="rounded-pill form-control" value={{\Auth::user()->name}} readonly>
                            <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">第二階段審核</span></button>
                        </form>
                    @elseif($data['change']['status']=='third'&&(\Auth::user()->role=='proprietor'))
                        <div class="col-lg-8 p-0" style="text-align:center;">
                            <form action="withdraw" method="POST">
                                @csrf
                                <div class="form-row align-items-center">
                                    <div class="col-lg-6 ">
                                        <input autocomplete="off" type="text" class="rounded-pill form-control" name="reason" placeholder="原因" required>
                                    </div>
                                    <button type="submit" class="btn btn-red rounded-pill">撤回</button>
                                </div>
                            </form>
                        </div>
                        <form action="match" method="POST" class="d-flex justify-content-between">
                            @csrf
                            <label>老闆審核：</label>
                            <input type="text" name="managed" class="rounded-pill form-control" value={{\Auth::user()->name}} readonly>
                            <button type="submit" class="btn btn-green rounded-pill"><span class="mx-2">第三階段審核</span></button>
                        </form>
                    
                    @elseif($data['change']['status']=='matched'&&($data['change']['matched']==\Auth::user()->nickname))
                    <div class="w-100">
                            <form action="match" method="POST" class="d-flex justify-content-end">
                                @csrf
                                <div class="row" style="display: flex;justify-content: space-around;">
                                    <div class="form-group">
                                        <input type="date" class="rounded-pill form-control" id="finished_date" name="finished_date" />
                                    </div>
                                    <div class="col-lg-6 my-1">
                                        <input autocomplete="off" type="text" class="rounded-pill form-control" name="finished_message" placeholder="完成更動說明">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-green rounded-pill">處理完成審核</button>
                                    </div>
                                </div>
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
@stop