@extends('layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-9" >
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="col-lg-12">
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
                            <small>已經收到收據</small>
                        </div>
                        <div class='progress w-100'>
                            <div class='progress-bar bg-info' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>
                        </div>
                    </div>
                    @endif
                    
                </div>
                <div class="col-lg-12">

                </div>
            </div>
        </div>
    </div>
</div>

@stop