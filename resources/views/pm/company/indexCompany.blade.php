@extends('layouts.app')
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3 d-flex">
        </div>
        <div class="col-lg-6 mb-3">
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('company.create')}}'"><i class='fas fa-plus'></i><span class="ml-3">{{__('customize.Add')}}</span> </button>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card card-style">
            <div class="card-body ">
                <div class="col-lg-12 table-style">
                    <table>
                        <tr>
                            <th>廠商編號</th>
                            <th>廠商名稱</th>
                        </tr>
                        @foreach ($data as $temp)
                        <tr class="tr-choose" onclick="location.href='{{route('company.edit', $temp->company_id)}}'">
                            <td>{{$temp->number}}</td>
                            <td>{{$temp->name}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop