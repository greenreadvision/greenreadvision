@extends('layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-9" >
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="col-lg-12" style="bottom: 1rem">
                    @if ($estimate['status']== 'waitting')
                    <div class="w-100">
                        <div class="w-100 text-center">
                            <small>報價中</small>
                        </div>
                        <div class='progress w-100'>
                            <div class='progress-bar bg-danger' role='progressbar' style='width: 0%' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>
                        </div>
                    </div>
                    @elseif($estimate['project_id']==null && $estimate['status']== 'account')
                    <div class="w-100">
                        <div class="w-100 text-center">
                            <small>已回簽，籌畫執行中</small>
                        </div>
                        <div class='progress w-100'>
                            <div class='progress-bar bg-danger' role='progressbar' style='width: 25%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div>
                        </div>
                    </div>
                    @elseif($estimate['project_id']!=null && $estimate['status']== 'account' )
                    <div class="w-100">
                        <div class="w-100 text-center">
                            <small>活動正在執行</small>
                        </div>
                        <div class='progress w-100'>
                            <div class='progress-bar bg-warning' role='progressbar' style='width: 50%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'></div>
                        </div>
                    </div>
                    @elseif($estimate['status']=='padding')
                    <div class="w-100">
                        <div class="w-100 text-center">
                            <small>委託方已付款</small>
                        </div>
                        <div class='progress w-100'>
                            <div class='progress-bar bg-success' role='progressbar' style='width: 75%' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100'></div>
                        </div>
                    </div>
                    @elseif($estimate['status']=='receipt')
                    <div class="w-100">
                        <div class="w-100 text-center">
                            <small>已開收據(存根聯)</small>
                        </div>
                        <div class='progress w-100'>
                            <div class='progress-bar bg-info' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                        </div>
                    </div>
                    @endif
                    
                </div>
                <div class="col-lg-12 table-style-invoice">
                    <table class="table_border">
                        <tbody>
                            <tr class="text-white">
                                
                                <th width="25%">
                                    @if($estimate['account_date']!=null&& $estimate['account_file'] !=null)
                                        回簽檔案<br>({{$estimate['account_date']}}已上傳)
                                        @if(\Auth::user()->user_id == $estimate['user_id'] ||  \Auth::user()->role == 'administrator' || \Auth::user()->role == 'manager')
                                        <i class='fas fa-edit icon-gray' data-toggle="modal" onclick="showModal('accountEditModal')"></i>
                                        @else
                                        <i class='fas fa-edit icon-gray' data-toggle="modal" onclick="showModal('accountEditModal')"   hidden></i>
                                        @endif
                                    @else
                                        回簽檔案
                                    @endif
                                </th>                               
                                <th width="25%">
                                    專案連結
                                    <i class='fas fa-edit icon-gray' data-toggle="modal" onclick="showModal('projectEditModal')"></i>
                                </th>
                                <th width="25%">
                                    
                                    @if($estimate['padding_date']!=null&& $estimate['padding_file'] !=null)
                                        存摺收款證明<br>({{$estimate['padding_date']}}已上傳)
                                        @if(\Auth::user()->user_id == $estimate['user_id'] ||  \Auth::user()->role == 'administrator' || \Auth::user()->role == 'manager')
                                        <i class='fas fa-edit icon-gray' data-toggle="modal" onclick="showModal('paddingEditModal')"></i>
                                        @else
                                        <i class='fas fa-edit icon-gray' data-toggle="modal" onclick="showModal('paddingEditModal')"   hidden></i>
                                        @endif
                                    @else
                                        回簽檔案
                                    @endif
                                </th>
                                <th width="25%">
                                    
                                    @if($estimate['receipt_date']!=null&& $estimate['receipt_file'] !=null)
                                        存根聯<br>({{$estimate['receipt_date']}}已上傳)
                                        @if(\Auth::user()->user_id == $estimate['user_id'] ||  \Auth::user()->role == 'administrator' || \Auth::user()->role == 'manager')
                                        <i class='fas fa-edit icon-gray' data-toggle="modal" onclick="showModal('receiptEditModal')"></i>
                                        @else
                                        <i class='fas fa-edit icon-gray' data-toggle="modal" onclick="showModal('receiptEditModal')"   hidden></i>
                                        @endif
                                    @else
                                        回簽檔案
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                
                                <td width="25%">
                                    @if($estimate['account_date']!=null&& $estimate['account_file'] !=null)
                                        @if (is_array($estimate['account_file']))
                                        <a class="btn btn-blue rounded-pill text-white" href="{{route('threedownload',$estimate['account_file'])}}">檔案下載</a>
                                        @endif
                                    @else
                                    <a class="btn btn-green rounded-pill text-white" data-toggle="modal"  onclick="showModal('accountEditModal')">檔案上傳</a>
                                    @endif
                                </td>                                
                                
                                <td width="25%">
                                    @if($estimate['project_id']!=null)
                                        <a href="{{route('project.review',$estimate['project_id'])}}"><h5>{{$estimate->project->name}}</h5></a>
                                    @else
                                        <h5>{{$estimate['active_name']}}</h5>
                                    @endif
                                </td>
                                
                                <td width="25%">
                                    @if($estimate['padding_date']!=null&& $estimate['padding_file'] !=null)
                                        @if (is_array($estimate['padding_file']))
                                        <a class="btn btn-blue rounded-pill text-white" href="{{route('threedownload',$estimate['padding_file'])}}">檔案下載</a>
                                        @endif
                                    @else
                                    <a class="btn btn-green rounded-pill text-white" data-toggle="modal"  onclick="showModal('paddingEditModal')">檔案上傳</a>
                                    @endif
                                </td>
                                <td>
                                    @if($estimate['receipt_date']!=null&& $estimate['receipt_file'] !=null)
                                        @if (is_array($estimate['receipt_file']))
                                        <a class="btn btn-blue rounded-pill text-white" href="{{route('threedownload',$estimate['receipt_file'])}}">檔案下載</a>
                                        @endif
                                    @else
                                    <a class="btn btn-green rounded-pill text-white" data-toggle="modal"  onclick="showModal('receiptEditModal')">檔案上傳</a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
                <hr size="8px" align="center" width="100%">
                <div class="col-lg-12 d-flex justify-content-between">
                    <div style="color:black;font-size:1rem;font-family: DFKai-sb,Times New Roman,STKaiti;">
                        <div class="col-md-12" style="text-align:right   ;"><label>{{__('customize.id')}} : {{$estimate->final_id}}</label></div>
                    </div>
                    <div>
                        <button type="button" id="print_button" class="btn btn-blue rounded-pill"><span class="mx-2">列印</span></button>
                    </div>
                </div>
                <div class="mb-3" id="print_box" name="print_box">
                    <!--print_start min-width:1043px;min-height:485px;-->
                    <div style="padding:2cm 0;text-align:center;color:black;font-size:1rem;font-family: DFKai-sb,Times New Roman,STKaiti;">
                        <div class="col-md-12 table-style" style="text-align:center;">
                            @if($estimate->company_name == 'grv')
                                <img src="{{ URL::asset('img/綠雷德LOGO.png') }}" height="50px">
                                <label style="font-size:xx-large;">綠雷德文創股份有限公司-報價單</label>
                            @elseif($estimate->company_name == 'rv')
                                <img src="{{ URL::asset('img/rv_logo.png') }}" height="50px">
                                <label style="font-size:xx-large;">閱野文創股份有限公司-報價單</label>
                            @elseif($estimate->company_name == 'grv_2')
                                <img src="{{ URL::asset('img/綠雷德創新logo.png') }}" height="50px">
                                <label style="font-size:xx-large;">綠雷德創新股份有限公司-報價單</label>
                            @endif
                            <div class="col-lg-12 d-flex justify-content-between">
                                <div>
                                    @if ($estimate->company_name == 'grv_2')
                                    <h3>統一編號：90742969</h3>
                                    @elseif($estimate->company_name == 'rv')
                                    <h3>統一編號：54289140</h3>
                                    @endif
                                </div>
                                <div>
                                    <h3>地址: 臺北市大安區忠孝東路三段1號光華館3樓310室</h3>
                                </div>
                            </div>
                            <table class="table border table_border" style="margin-top: 16px">
                                <tbody>
                                    <tr class="table_split">
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                        <td  width="5%" colspan="1"><h5></h5></td>
                                    </tr>
                                    <tr>
                                        <td width="15%" colspan="3"><h5>公司名稱</h5></td>
                                        <td width="40%" colspan="8"><h5>{{$estimate->customer->name}}</h5></td>
                                        <td width="15%" colspan="3"><h5>電話</h5></td>
                                        <td width="30%" colspan="6"><h5>{{$estimate->customer->phone}}</h5></td>

                                    </tr>
                                    <tr>
                                        <td width="15%" colspan="3"><h5>活動聯絡人</h5></td>
                                        <td width="40%" colspan="8"><h5>{{$estimate->customer->principal}}</h5></td>
                                        <td width="15%" colspan="3"><h5>Mail</h5></td>
                                        <td width="30%" colspan="6"><h5>{{$estimate->customer->email}}</h5></td>
                                    </tr>
                                    <tr>
                                        <td width="15%" colspan="3"><h5>活動名稱</h5></td>
                                        <td width="85%" colspan="17"><h5>{{$estimate->active_name}}</h5></td>
                                    </tr>
                                    <tr>
                                        <td width="15%" colspan="3"><h5>業務承辦人</h5></td>
                                        <td width="40%" colspan="8"><h5>{{$estimate->user->name}}</h5></td>
                                        <td width="20%" colspan="4" rowspan="2" style="vertical-align:middle;"><h5>報價日期</h5></td>
                                        <td width="30%" colspan="6" rowspan="2" style="vertical-align:middle;"><h5>{{substr($estimate->created_at,0,4)-1911}}年{{substr($estimate->created_at,5,2)}}月{{substr($estimate->created_at,8,2)}}日</h5></td>
                                    </tr>
                                    <tr>
                                        <td width="15%" colspan="3"><h5>連絡電話</h5></td>
                                        <td width="40%" colspan="8"><h5>02-8772-2160/02-8772-6321</h5></td>
                                    </tr>
                                    <tr>
                                        <td width="10%" colspan="2"><h5>編號</h5></td>
                                        <td width="20%" colspan="4"><h5>項目</h5></td>
                                        <td width="10%" colspan="2"><h5>單價</h5></td>
                                        <td width="10%" colspan="2"><h5>數量</h5></td>
                                        <td width="10%" colspan="2"><h5>單位</h5></td>
                                        <td width="10%" colspan="2"><h5>金額</h5></td>
                                        <td width="30%" colspan="6"><h5>備註</h5></td>
                                    </tr>
                                    @foreach ($estimate->item as $item)
                                        <tr>
                                            <td width="10%" colspan="2"><h5>{{$item->no}}</h5></td>
                                            <td width="20%" colspan="4"><h5>{{$item->content}}</h5></td>
                                            <td width="10%" colspan="2"><h5>${{number_format($item->price)}}</h5></td>
                                            <td width="10%" colspan="2"><h5>{{$item->quantity}}</h5></td>
                                            <td width="10%" colspan="2"><h5>{{$item->unit}}</h5></td>
                                            <td width="10%" colspan="2"><h5>${{number_format($item->amount)}}</h5></td>
                                            <td width="30%" colspan="6" style="text-align: left"><span>{{$item->note}}</span></td>

                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td width="50%" colspan="10"><h5>小計</h5></td>
                                        <td width="50%" colspan="10"><h5>${{number_format($estimate->total_price)}}</h5></td>
                                    </tr>
                                    <tr>
                                        <td width="50%" colspan="10"><h5>稅金</h5></td>
                                        <td width="50%" colspan="10"><h5>${{number_format($estimate->total_price * 0.05)}}</h5></td>
                                    </tr>
                                    <tr>
                                        <td width="50%" colspan="10"><h5>總計</h5></td>
                                        <td width="50%" colspan="10"><h5>${{number_format($estimate->total_price * 1.05)}}</h5></td>
                                    </tr>
                                    <tr>
                                        <td width="100%" colspan="20" style="text-align: left">
                                            <h5>備註：</h5>
                                            <span style="font-size: 1rem">
                                                &nbsp; 1.此報價七天內有效，並請確認後回傳。<br>

                                                &nbsp; 2.付款方式：報價單回簽後七天內需付款總額的50%；記者會結束後十四天內需付款總額的50%。<br>
                                                {{$estimate->company_name == 'grv'?&nbsp; 3.匯款帳戶：華南銀行；板橋分行；帳號-160-100-086-658；戶名-綠雷德創新股份有限公司；<br>:&nbsp; 3.匯款帳戶：華南銀行；板橋分行；帳號-160-100-086-658；戶名-閱野文創股份有限公司；<br>}}
                                                
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="5%" colspan="1" height="50px"><h5>公司蓋章處</h5></td>
                                        <td width="45%" colspan="9" height="50px"></td>
                                        <td width="5%" colspan="1" height="50px"><h5>客戶確認回簽處</h5></td>
                                        <td width="45%" colspan="9" height="50px"></td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="accountEditModal" tabindex="-1" role="dialog" aria-labelledby="accountEditModal" aria-hidden="true"  data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >上傳回簽報價單之掃描檔案</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 form-group">
                    @if ($estimate->account_file != null)
                    <form action="update/accountUpdate" method="post" enctype="multipart/form-data">
                    @else
                    <form action="update/account" method="post" enctype="multipart/form-data">
                    @endif
                        @method('POST')
                        @csrf
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="signer">檔案上傳</label>
                            <input type="file" id="account_file" name="account_file" class="form-control rounded-pill{{ $errors->has('receipt_file') ? ' is-invalid' : '' }}" required>
                            <label class="label-style col-form-label" for="signer">回簽日期</label>
                            <input type="date" id="account_date" name="account_date" class="form-control rounded-pill{{ $errors->has('account_date') ? ' is-invalid' : '' }}" value="{{$estimate->account_date}}" required>

                        </div>
                        <div class="col-lg-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="projectEditModal" tabindex="-1" role="dialog" aria-labelledby="projectEditModal" aria-hidden="true"  data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">連結專案</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 form-group">
                    <form action="update/project" method="post" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="signer"></label>
                            <select name="project_id" id="project_id" class="form-control rounded-pill" required>
                                <option value=""></option>
                                <optgroup label="綠雷德創新">
                                @foreach ($projects as $item)
                                    @if($item->company_name == 'grv_2')
                                    <option value="{{$item->project_id}}" {{$estimate->project_id==$item->project_id ? 'selected':''}}>{{$item->name}}</option>
                                    @endif
                                @endforeach
                                </optgroup>
                                <optgroup label="閱野文創">
                                    @foreach ($projects as $item)
                                        @if($item->company_name == 'rv')
                                        <option value="{{$item->project_id}}" {{$estimate->project_id ==$item->project_id ? 'selected':''}}>{{$item->name}}</option>
                                        @endif
                                    @endforeach
                                    </optgroup>
                            </select>
                        </div>
                        <div class="col-lg-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paddingEditModal" tabindex="-1" role="dialog" aria-labelledby="paddingEditModal" aria-hidden="true"  data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >上傳回簽報價單之掃描檔案</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 form-group">
                    @if ($estimate->padding_file != null)
                    <form action="update/paddingUpdate" method="post" enctype="multipart/form-data">
                    @else
                    <form action="update/padding" method="post" enctype="multipart/form-data">
                    @endif
                        @method('POST')
                        @csrf
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="signer">檔案上傳</label>
                            <input type="file" id="padding_file" name="padding_file" class="form-control rounded-pill{{ $errors->has('padding_file') ? ' is-invalid' : '' }}" required>
                            <label class="label-style col-form-label" for="signer">付款日期</label>
                            <input type="date" id="padding_date" name="padding_date" class="form-control rounded-pill{{ $errors->has('padding_date') ? ' is-invalid' : '' }}" value="{{$estimate->padding_date}}" required>

                        </div>
                        <div class="col-lg-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="receiptEditModal" tabindex="-1" role="dialog" aria-labelledby="receiptEditModal" aria-hidden="true"  data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >上傳回簽報價單之掃描檔案</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 form-group">
                    @if ($estimate->receipt_file != null)
                    <form action="update/receiptUpdate" method="post" enctype="multipart/form-data">
                    @else
                    <form action="update/receipt" method="post" enctype="multipart/form-data">
                    @endif
                        @method('POST')
                        @csrf
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="signer">檔案上傳</label>
                            <input type="file" id="receipt_file" name="receipt_file" class="form-control rounded-pill{{ $errors->has('receipt_file') ? ' is-invalid' : '' }}" required>
                            <label class="label-style col-form-label" for="signer">付款日期</label>
                            <input type="date" id="receipt_date" name="receipt_date" class="form-control rounded-pill{{ $errors->has('receipt_date') ? ' is-invalid' : '' }}" value="{{$estimate->receipt_date}}" required>

                        </div>
                        <div class="col-lg-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-blue rounded-pill"><span class="mx-2">{{__('customize.Save')}}</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
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
<script>
    function showModal(type){
        $('#'+type).modal('show');
    }
</script>