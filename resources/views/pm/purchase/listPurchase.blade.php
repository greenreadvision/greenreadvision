@extends('layouts.app')
@section('content')
@foreach ($purchase_groups as $key => $purchases)
@if($purchases[0]->project->project_id==$projects_id)
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3 ">
            <h2>{{$purchases[0]->project->name}}</h2>
        </div>
        <div class="col-lg-6 mb-3">
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('purchase.create')}}'"><i class='fas fa-plus'></i><span class="ml-3">{{__('customize.Add')}}</span> </button>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card card-style">
            <div class="card-body ">
                <div class="col-lg-12">
                    <div class="col-lg-12">

                        <div class="col-lg-12 table-style-invoice">
                            <form action="list/multipleMatch" method="POST">
                                @csrf
                                @foreach($years as $year)
                                <div class="text-center col-lg-12 collapse-style py-1 " data-toggle="collapse" data-target="#multiCollapse{{$year}}" aria-expanded="false" aria-controls="multiCollapse{{$year}}">{{$year}}年</div>
                                <div class="collapse multi-collapse" id="multiCollapse{{$year}}">
                                    @foreach($months as $month)
                                    @if(substr($month,0,4) == $year)
                                    <div class="col-lg-12 collapse-style py-1 pl-5" data-toggle="collapse" data-target="#multiCollapse{{$month}}" aria-expanded="false" aria-controls="multiCollapse{{$month}}">{{substr($month,5,2)}}月</div>
                                    <div class="collapse multi-collapse" id="multiCollapse{{$month}}">
                                <table>
                                    <tr style="background-color:{{$purchases[0]->project->color}}21">
                                        <th>採購單號</th>
                                        <th>採購人</th>
                                        <th>專案名稱</th>
                                        <th>廠商名稱</th>
                                        <th>採購日期</th>
                                    </tr>

                                    @foreach ($purchases as $purchase)
                                    @if(substr($month,0,7)==substr($purchase->created_at,0,7))
                                    <tr >
                                        <td style="white-space:pre-line;">
                                            <a href="{{route('purchase.review', $purchase->purchase_id)}}">{{$purchase->id}}</a>
                                        </td>
                                        <td>
                                            {{$purchase->user['name']}}
                                        </td>
                                        <td>{{$purchase->project->name}}</td>
                                        <td>{{$purchase->company}}</td>
                                        <td>{{$purchase->purchase_date}}</td>
                                    </tr>
                                    @endif
                                    @endforeach



                                </table>
                                </div>
                                    @endif
                                    @endforeach
                                    </div>
                                    @endforeach
                            </form>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach
@stop
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
@stop