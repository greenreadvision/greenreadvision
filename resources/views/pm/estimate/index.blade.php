@extends('layouts.app')
@section('content')
<button class=" btn btn-blue rounded-pill" onclick="location.href='{{route('estimate.create')}}'"><span class="mx-2">新增</span> </button>

@stop
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.14.0/dist/xlsx.full.min.js"></script>

@stop