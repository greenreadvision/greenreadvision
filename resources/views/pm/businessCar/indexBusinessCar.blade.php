@extends('layouts.app')
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3 ">
            <!-- <h2>{{__('customize.BusinessCar')}}</h2> -->
        </div>
        <div class="col-lg-6 mb-3">
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('businessCar.create')}}'"><i class='fas fa-plus'></i><span class="ml-3">{{__('customize.Add')}}</span> </button>
        </div>

    </div>
</div>
<!-- <div class="col-lg-6 mb-3">
    <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('warning.send')}}'"><i class='fas fa-plus'></i><span class="ml-3">{{__('customize.Add')}}</span> </button>
</div> -->
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card card-style">
            <div class="card-body ">

                <div class="col-lg-12 table-style">
                    <table>
                        <tr>
                            <th>申請人</th>
                            <th>標案</th>
                            <th>借車事由</th>
                            <th>使用日期(自)</th>
                            <th>使用日期(迄)</th>
                        </tr>
                        @foreach ($data as $temp)
                        <tr class="tr-choose" onclick="location.href='{{route('businessCar.review', $temp->business_car_id)}}/'">
                            <td>{{$temp->user->name}}</td>
                            <td>{{$temp->project->name}}</td>
                            <td>{{$temp->content}}</td>
                            <td>{{$temp->begin_date}} {{str_split($temp->begin_time,5)[0]}} </td>
                            <td>{{$temp->end_date}} {{str_split($temp->end_time,5)[0]}} </td>

                        </tr>
                        @endforeach
                    </table>
                </div>


            </div>

        </div>
    </div>
</div>

@stop