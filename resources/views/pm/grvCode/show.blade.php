@extends('layouts.app')
@section('content')

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3">
            <h2>實名制</h2>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    <div class="col-lg-3">
    </div>
</div>
<div id="qrcode" style="width:100px; height:100px; margin:15px;"></div>

@stop

@section('javascript')
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="http://static.runoob.com/assets/qrcode/qrcode.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: 100,
            height: 100
        });

        function makeCode() {
            var elText = '{{$real_name_id}}';
            console.log(elText)

            qrcode.makeCode(elText);
        }

        makeCode();
    })
</script>
@stop