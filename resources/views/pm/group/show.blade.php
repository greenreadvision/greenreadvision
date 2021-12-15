@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-center">
    <div class="col-lg-8">
        <div class="row" style="margin: 15px">
            <div class="col-lg-12 d-flex justify-content-end">
                <button class="btn btn-green rounded-pill" onclick="location.href='{{route('group.edit',$group->group_id)}}'"><span class="mx-2">{{__('customize.Edit')}}</span> </button>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-6">
                <div class="card border-0 shadow  rounded-pill-top">
                    <div class="card-header rounded-pill-top" style="font-size: 18px;text-align: center">資本資料</div>
                    <div class="card-body">
                        <div>
                            <label class="label-style col-form-label" for="data"> 團體/公司名稱</label>
                            <div style="text-align: center;font-size: 16pt">{{$group->name}}</div>
                        </div>
                        <div>
                            <label class="label-style col-form-label" for="data"> 聯絡資料</label>
                            <div class="row">
                                 <div class="col-lg-4" style="text-align: center">
                                     <p style="font-size: 16pt">
                                        市話：
                                    </p>
                                </div>
                                <div class="col-lg-8" style="text-align: left">
                                    <p style="font-size: 16pt">{{$group->phone==null? '未填寫' : $group->phone}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4" style="text-align: center">
                                    <p style="font-size: 16pt">
                                        手機：
                                    </p>
                                </div>
                                <div class="col-lg-8" style="text-align: left">
                                    <p style="font-size: 16pt">{{$group->telephone==null? '未填寫' : $group->telephone}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4" style="text-align: center">
                                    <p style="font-size: 16pt">
                                        傳真：
                                    </p>
                                </div>
                                <div class="col-lg-8" style="text-align: left">
                                    <p style="font-size: 16pt">{{$group->fax==null? '未填寫' : $group->fax}}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="label-style col-form-label" for="data"> 所在地區</label>
                            <div style="text-align: center;font-size: 16pt">{{$group->address}}</div>
                        </div>
                        <div>
                            <label class="label-style col-form-label" for="data"> 官方連結</label>
                            @if($group->webAddress==null)
                            <div style="text-align: center;font-size: 16pt">-未填寫-</div>
                            @else
                            <div style="text-align: center;font-size: 16pt"><a href="{{$group->webAddress}}"  target="_blank">{{$group->webAddress}}</a></div>
                            @endif
                            
                        </div>
                        
                    </div>
                </div>
                <div style="margin-top: 10px">
                    <div class="card border-0 shadow rounded-pill-top">
                        <div class="card-header rounded-pill-top" style="font-size: 18px;text-align: center">介紹內容</div>
                        <div class="card-body">
                            <p style="font-size: 14pt;margin: 5px" >&emsp;&emsp;{{$group->content!=null? $group->content : ''}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow rounded-pill-top">
                    <div class="card-header rounded-pill-top" style="font-size: 18px;text-align: center">協助經歷</div>
                    <div class="card-body">
                        @if(count($group_active_projectName)==0)
                        <p style="font-size: 14pt;margin: 5px;text-align: center" >-未填寫-</p>
                        @else
                            @foreach ($group_active_projectName as $data)
                            <label class="label-style col-form-label"  style="font-size: 16pt;text-align: center"> {{$data->projectName}}</label>
                                @foreach ($group_active as $item)
                                <p style="font-size: 14pt;margin: 5px" >&emsp;&emsp;{{$item->projectName==$data->projectName? $item->activeName : ''}}</p>
                                @endforeach
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop