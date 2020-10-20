@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-header text-center">
                    @foreach($data->toArray() as $key => $value)
                        @if($key == "title" )
                        <h1>{{$value}}</h1>
                        @endif
                    @endforeach
                </div>
                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach($data->toArray() as $key => $value)
                        @if($key == "content" )
                            {{$value}}
                            
                        @endif
                    @endforeach
                    @if (\Auth::user()->role=='manager')
                        <hr>
                        <div style="float:left;">
                            <button class="btn btn-primary" onclick="location.href='{{route('home.edit', $data->home_id)}}'">{{__('customize.Edit')}}</button>
                        </div>
                    @endif
                </div>
               
            </div>
        </div>
    </div>
@endsection
