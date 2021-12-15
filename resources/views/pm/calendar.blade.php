@extends('layouts.app') 
@section('content')
<div class="card">
    <div class="card-header text-center">
        <h1>@lang('customize.Calendar')</h1>
    </div>

    <div class="card-body" style="padding:0;">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
        <?php
            include app_path().'/Functions/Calendar.php';
            $calendar = new Calendar();
            echo $calendar->show($data['year'], $data['month'], $data['event'], $data['project'], $data['user']);
        ?>
    </div>
</div>
@endsection
 
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    $(function () {
        $('[data-toggle="popover"]').popover({
            trigger: 'focus'
        });
    });

</script>
@endsection