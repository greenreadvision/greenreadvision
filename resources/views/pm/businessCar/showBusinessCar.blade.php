@extends('layouts.app')
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3 ">
            <h2>{{__('customize.BusinessCar')}}</h2>
        </div>
        <div class="col-lg-6 mb-3">
            @if(\Auth::user()->user_id==$data['user_id'])
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('businessCar.edit', $data->business_car_id)}}'"><i class='fas fa-edit'></i><span class="ml-3"> {{__('customize.Edit')}}</span></button>
            @endif
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card card-styl table-style">
            <table border="1">
                <tr>
                    <td>專案</td>
                    <td colspan="3">{{$data->project->name}}</td>
                    
                </tr>
                <tr>
                <td>借車事由</td>
                    <td colspan="3">{{$data['content']}}</td>
                </tr>
                　<tr>
                    <td>申請人</td>
                    <td >{{$data->user->name}}</td>
                    <td>聯絡電話</td>
                    <td>{{$data->user->phone_number}}</td>
                </tr>
                <tr>
                    <td>{{__('customize.driver')}}</td>
                    <td>{{$data['driver']}}</td>
                    <td>聯絡電話</td>
                    <td>{{$data['phone_number']}}</td>
                </tr>
                <tr>
                    <td>使用日期</td>
                    <td colspan="3">自&nbsp;{{$data['begin_date']}}&nbsp;{{str_split($data['begin_time'],5)[0]}}&nbsp;迄&nbsp;{{$data['end_date']}}&nbsp;{{str_split($data['end_time'],5)[0]}}</td>
                </tr>
                <tr>
                    <td>起點</td>
                    <td>{{$data['begin_location']}}</td>
                    <td>迄點</td>
                    <td>{{$data['end_location']}}</td>
                </tr>
                <tr>
                    <td>里程數</td>
                    <td colspan="3">{{$data['begin_mileage']}}&nbsp;-&nbsp;{{$data['end_mileage']}}</td>
                </tr>
                <tr>
                    <td>付款人</td>
                    <td >{{$data['payer']}}</td>
                    <td>油資</td>
                    <td >{{$data['oil']}}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@stop