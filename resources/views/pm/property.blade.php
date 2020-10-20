@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h4>{{$data['finance']['name']}}</h4>
                </div>
                <div class="card-body">
                    <div class="col-md-10">
                        @foreach ($data['finance'] as $key => $value)
                            @if ($key == 'property')
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>{{__('customize.Name')}}</th>
                                            <th>{{__('customize.Amount')}}</th>
                                            <th>{{__('customize.Price')}}</th>
                                            <th>{{__('customize.Url')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($value as $propertyKey => $property)
                                        <tr>
                                            <th>{{$propertyKey+1}}</th>
                                            <th>{{$property['name']}}</th>
                                            <th>{{$property['amount']}}</th>
                                            <th>{{$property['price']}}</th>
                                            <th>{{$property['url']}}</th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h6>{{__('customize.'.$key)}} : {{$value}}</h6>
                            @endif
                        @endforeach
                    </div>
                    <button class="btn btn-primary" onclick="location.href='{{route('finance.edit', $data['finance']['finance_id'])}}'">{{__('customize.Edit')}}</button>
                </div>
            </div>
        </div>
    </div>
@stop