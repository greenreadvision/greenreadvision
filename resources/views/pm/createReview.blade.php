@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header">
                    <h4>{{__('customize.Add')}}</h4>
                </div>
                <div class="card-body">
                    <form action="edit" method="get">
                        <div class="row">
                            @foreach($data as $key => $value)
                            <div class="col-md-6">
                                @if ($key == 'test')
                                    @dump($value)
                                @else
                                    <li><label class="col-form-label">{{__('customize.'.$key)}} </label><p>{{$value}}</p></li>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        <div style="float: right;">
                            <button type="submit" class="btn btn-primary">{{__('customize.Edit')}}</button>
                        </div>
                    </form>

                    <form action="delete" method="POST">
                        @method('DELETE')
                        @csrf
                        <div style="float: left;">
                            <button type="submit" class="btn btn-primary">{{__('customize.Delete')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop