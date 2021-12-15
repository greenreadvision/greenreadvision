@extends('layouts.app') 
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h4>{{__($data['name'])}}</h4>
                </div>
                <div class="card-body">
                    <form action="edit" method="get">
                        <div class="row">
                            @foreach($data as $key => $value) @if (strpos($key, '_at')&&\Auth::user()->role!="manager") @continue @endif
                            <div class="col-sm-6 row">
                                <div class="col-md-6">
                                    <li><label class="col-form-label">{{__('customize.'.$key)}} :</label></li>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label">{{$value}}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <hr> @if(\Auth::user()->user_id==$data['user_id'])
                        <div style="float: left;">
                            <button type="submit" class="btn btn-primary">{{__('customize.Edit')}}</button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop