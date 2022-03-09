@extends('layouts.app')
@section('content')

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-3  col-12">
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col-lg-9  col-12">
            <div class="card border-0 shadow rounded-pill">
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>


@stop

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.0/dist/xlsx.full.min.js"></script>

@stop