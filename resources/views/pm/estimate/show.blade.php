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
                    @elseif($estimate['status']== 'account')
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
                    @elseif($estimate['status']=='recipt')
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
                                        <h5>$estimate['active_name']</h5>
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
                    <form action="update/account" method="post" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="signer">檔案上傳</label>
                            <input type="file" id="account_file" name="account_file" class="form-control rounded-pill{{ $errors->has('receipt_file') ? ' is-invalid' : '' }}">
                            <label class="label-style col-form-label" for="signer">回簽日期</label>
                            <input type="date" id="account_date" name="account_date" class="form-control rounded-pill{{ $errors->has('account_date') ? ' is-invalid' : '' }}">

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
                            <select name="project_id" id="project_id" class="form-control rounded-pill">
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
                    <form action="update/padding" method="post" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="signer">檔案上傳</label>
                            <input type="file" id="padding_file" name="padding_file" class="form-control rounded-pill{{ $errors->has('padding_file') ? ' is-invalid' : '' }}">
                            <label class="label-style col-form-label" for="signer">付款日期</label>
                            <input type="date" id="padding_date" name="padding_date" class="form-control rounded-pill{{ $errors->has('padding_date') ? ' is-invalid' : '' }}">

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
                    <form action="update/receipt" method="post" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="col-lg-12 form-group">
                            <label class="label-style col-form-label" for="signer">檔案上傳</label>
                            <input type="file" id="receipt_file" name="receipt_file" class="form-control rounded-pill{{ $errors->has('receipt_file') ? ' is-invalid' : '' }}">
                            <label class="label-style col-form-label" for="signer">付款日期</label>
                            <input type="date" id="receipt_date" name="receipt_date" class="form-control rounded-pill{{ $errors->has('receipt_date') ? ' is-invalid' : '' }}">

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
<script>
    function showModal(type){
        $('#'+type).modal('show');
    }
</script>