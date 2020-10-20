@extends('layouts.app')
@section('content')

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3 ">
            <h2>{{__('customize.'.$company_name)}}</h2>
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
                <form action="other/multipleMatch" method="POST">
                    @csrf
                    @foreach ($type as $key )
                    <div class="col-lg-12">
                        <div class="row collapse-style" data-toggle="collapse" data-target="#multiCollapse{{$key}}" aria-expanded="false" aria-controls="multiCollapse{{$key}}">
                            <div class="col-lg-12 py-3 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    {{__('customize.'.$key)}}
                                </div>
                            </div>
                        </div>
                        <div class="collapse multi-collapse" id="multiCollapse{{$key}}">
                            @foreach($years as $year)
                            <div class="text-center col-lg-12 collapse-style py-1 " data-toggle="collapse" data-target="#multiCollapse{{$key}}{{$year}}" aria-expanded="false" aria-controls="multiCollapse{{$key}}{{$year}}">{{$year}}年</div>
                            <div class="collapse multi-collapse" id="multiCollapse{{$key}}{{$year}}">
                                @foreach($months as $month)
                                @if(substr($month,0,4) == $year)
                                <div class="col-lg-12 collapse-style py-1 pl-5" data-toggle="collapse" data-target="#multiCollapse{{$key}}{{$month}}" aria-expanded="false" aria-controls="multiCollapse{{$key}}{{$month}}">{{substr($month,5,2)}}月</div>
                                <div class="collapse multi-collapse" id="multiCollapse{{$key}}{{$month}}">
                                    <div class="row">
                                        <div class="col-lg-12 table-style-invoice">

                                            <table>
                                                <tr style="background-color:#f1f3fa">
                                                    <th></th>
                                                    <th>請款人</th>
                                                    <th>請款項目</th>

                                                    <th>請款費用</th>

                                                    <th>請款日期</th>
                                                    <th></th>
                                                </tr>
                                                @foreach($state as $data)
                                                @foreach ($otherInvoice as $invoice)
                                                @if($invoice->type==$key&&$invoice->company_name==$company_name&&$invoice->status==$data && substr($month,0,7)==substr($invoice->created_at,0,7))
                                                <tr>
                                                    <td>
                                                        @if($invoice->status!='waiting')
                                                        @if($invoice->status=='check'&&\Auth::user()->role=='manager')
                                                        <input onchange="changeDisabled()" type="checkbox" name="checkbox[]" value="{{$invoice->other_invoice_id}}" id="{{$invoice->other_invoice_id}}" />

                                                        @elseif($invoice->status=='managed'&&\Auth::user()->role=='accountant')
                                                        <input onchange="changeDisabled()" type="checkbox" name="checkbox[]" value="{{$invoice->other_invoice_id}}" id="{{$invoice->other_invoice_id}}" />
                                                        @elseif($invoice->status=='matched'&&\Auth::user()->role=='accountant')
                                                        <input onchange="changeDisabled()" type="checkbox" name="checkbox[]" value="{{$invoice->other_invoice_id}}" id="{{$invoice->other_invoice_id}}" />
                                                        @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{$invoice->user['nickname']}}
                                                    </td>
                                                    <td>

                                                        <a href="{{route('invoice.review.other', $invoice->other_invoice_id)}}">{{$invoice->title}}</a>
                                                    </td>
                                                    <td style="white-space:pre-line;">
                                                        <a href="{{route('invoice.review.other', $invoice->other_invoice_id)}}">{{number_format($invoice->price)}}</a>
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
                                                @endforeach
                                                @endforeach
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                    @if(\Auth::user()->role=='manager'||\Auth::user()->role=='accountant')
                    <button id="matchs-btn" type="submit" class="btn btn-primary btn-primary-style" disabled>審核</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

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
            $("#matchs-btn").attr("disabled", true);
        } else {
            $("#matchs-btn").attr("disabled", false);
        }
    }
</script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
@stop