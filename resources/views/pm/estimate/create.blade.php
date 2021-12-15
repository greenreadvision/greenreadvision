@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow rounded-pill">
            <div class="card-body">
                <div class="col-lg-12">
                    <form name="estimatilForm" action="create/store" method="post" enctype="multipart/form-data">
                        
                    </form>
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