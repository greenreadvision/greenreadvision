@extends('layouts.app')
@section('content')
@foreach ($invoice_groups as $key => $invoices)
@if($invoices[0]->project->project_id==$projects_id)
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3 ">
            <h2>{{$invoices[0]->project->name}}</h2>
        </div>
        <div class="col-lg-6 mb-3">
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('invoice.create')}}'"><i class='fas fa-plus'></i><span class="ml-3">{{__('customize.Add')}}</span> </button>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="card card-style">
            <div class="card-body ">
                <div class="col-lg-12">
                    <div class="col-lg-12">

                        <div class="col-lg-12 table-style-invoice">
                            <form action="list/multipleMatch" method="POST">
                                @csrf
                                @foreach($years as $year)
                                <div class="text-center col-lg-12 collapse-style py-1 " data-toggle="collapse" data-target="#multiCollapse{{$year}}" aria-expanded="false" aria-controls="multiCollapse{{$year}}">{{$year}}年</div>
                                <div class="collapse multi-collapse" id="multiCollapse{{$year}}">
                                    @foreach($months as $month)
                                    @if(substr($month,0,4) == $year)
                                    <div class="col-lg-12 collapse-style py-1 pl-5" data-toggle="collapse" data-target="#multiCollapse{{$month}}" aria-expanded="false" aria-controls="multiCollapse{{$month}}">{{substr($month,5,2)}}月</div>
                                    <div class="collapse multi-collapse" id="multiCollapse{{$month}}">
                                        
                                        <table>
                                            <tr style="background-color:{{$invoices[0]->project->color}}21">
                                                <th></th>
                                                <th>請款人</th>
                                                <th>請款項目</th>

                                                <th>請款費用</th>
                                                
                                                <th>請款日期</th>
                                                <th></th>
                                            </tr>

                                            @foreach($state as $data)
                                            @foreach ($invoices as $invoice)
                                            @if(substr($month,0,7)==substr($invoice->created_at,0,7))
                                            @if($invoice->status==$data)
                                            <tr>
                                                <td>
                                                    @if($invoice->status!='waiting')
                                                    @if($invoice->status=='check'&&\Auth::user()->role=='manager')
                                                    <input onchange="changeDisabled()" type="checkbox" name="checkbox[]" value="{{$invoice->invoice_id}}" id="{{$invoice->invoice_id}}" />

                                                    @elseif($invoice->status=='managed'&&\Auth::user()->role=='accountant')
                                                    <input onchange="changeDisabled()" type="checkbox" name="checkbox[]" value="{{$invoice->invoice_id}}" id="{{$invoice->invoice_id}}" />
                                                    @elseif($invoice->status=='matched'&&\Auth::user()->role=='accountant')
                                                    <input onchange="changeDisabled()" type="checkbox" name="checkbox[]" value="{{$invoice->invoice_id}}" id="{{$invoice->invoice_id}}" />
                                                    @endif

                                                    @endif
                                                </td>
                                                <td>
                                                    {{$invoice->user['nickname']}}
                                                </td>
                                                <td>
                                                <a href="{{route('invoice.review', $invoice->invoice_id)}}"> {{$invoice->title}}</a>
                                                </td>
                                                <td style="white-space:pre-line;">
                                                    <a href="{{route('invoice.review', $invoice->invoice_id)}}">{{number_format($invoice->price)}}</a>
                                                </td>
                                                <td>{{$invoice->created_at->format('Y-m-d')}}</td>
                                                <td> @switch($invoice->status)
                                                    @case('waiting')
                                                    <span class="badge badge-pill badge-danger mr-2" style="background:#dc3545">@lang('customize.'.$invoice->status)</span>
                                                    @break
                                                    @case('waiting-fix')
                                                    <span class="badge badge-pill badge-danger mr-2" style="background:#ff7a87">修改中</span>
                                                    @break
                                                    @case('check-fix')
                                                    <span class="badge badge-pill badge-danger mr-2" style="background:#ff7a87">修改中</span>
                                                    @break
                                                    @case('check')
                                                    <span class="badge badge-pill badge-warning mr-2" style="background:#ffb13c">@lang('customize.'.$invoice->status)</span>
                                                    @break
                                                    @case('managed')
                                                    <span class="badge badge-pill badge-warning mr-2">@lang('customize.'.$invoice->status)</span>
                                                    @break
                                                    @case('matched')
                                                    <span class="badge badge-pill badge-success mr-2">@lang('customize.'.$invoice->status)</span>
                                                    @break
                                                    @case('complete')
                                                    <span class="badge badge-pill badge-light mr-2">@lang('customize.'.$invoice->status)</span>
                                                    @break
                                                    @default
                                                    <span class="badge mr-2">@lang('customize.'.$invoice->status)</span>
                                                    @endswitch</td>
                                            </tr>
                                            @endif
                                            @endif
                                            @endforeach
                                            @endforeach

                                        </table>
                                        
                                    </div>
                                    @endif
                                    @endforeach
                                    </div>
                                    @endforeach
                               
                                @if(\Auth::user()->role=='manager'||\Auth::user()->role=='accountant')
                                <button id="match-btn" type="submit" class="btn btn-primary btn-primary-style" disabled>審核</button>
                                @endif
                            </form>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach
@stop
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    function changeInvoiceType(i) {
        if (i == 0) {
            document.getElementById('invoice-grv').style.display = "block"
            document.getElementById('invoice-rv').style.display = "none"

        } else {
            document.getElementById('invoice-grv').style.display = "none"
            document.getElementById('invoice-rv').style.display = "block"
        }
    }

    function changeDisabled() {
        if ($("input[name='checkbox[]']:checked").length == 0) {
            $("#match-btn").attr("disabled", true);
        } else {
            $("#match-btn").attr("disabled", false);
        }
    }
</script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
@stop