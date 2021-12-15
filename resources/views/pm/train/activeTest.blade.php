@extends('layouts.app')
@section('content')
    
    <div style="float: right;">
        <div style="padding-top:15px;padding-right:2cm">
            <button type="button" class="btn btn-secondary"  onclick="location.href='{{URL::route('train.three')}}'">下一步</button>
        </div>
    </div>

@stop
@section('script')
<script type="text/javascript">
    
</script>
@stop