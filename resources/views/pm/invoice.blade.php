@extends('layouts.app') 
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">
            <div class="card" style="margin: 10px 0px;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h1>{{__('customize.Invoice')}}</h1>
                    <button class="btn btn-primary" onclick="location.href='{{route('invoice.create')}}'">{{__('customize.Add')}}</button>
                </div>
                <div class="card-body">
                    @foreach ($invoice_groups as $key => $invoices)
                        <span style="background-color:{{$invoices[0]->project->color}}; border-radius: 100rem; width: 15px; height: 15px; display: inline-block; margin-right: .5rem; box-shadow:0 0 10px {{$invoices[0]->project->color}};"></span>
                        <a href="{{route('project.review', $invoices[0]->project_id)}}" class="d-inline-block mb-2" style="color:black; font-size:1.1rem;">{{$invoices[0]->project['name']}}</a>
                        <ol>
                            @foreach ($invoices as $invoice)
                                <li class="mb-1">
                                    <div class="row justify-content-between">
                                        <div class="col">
                                            <span>{{$invoice->user['nickname']}}</span>
                                            <a href="{{route('invoice.review', $invoice->invoice_id)}}">{{$invoice->content}}</a>
                                        </div>
                                        <div class="col-auto">
                                            <span>{{$invoice->company}}</a>
                                        </div>
                                        <div class="col-auto">
                                            <span class="mr-2 text-secondary" style="font-size: .8rem;">{{$invoice->created_at->format('Y-m-d')}}</span>
                                            @switch($invoice->status)
                                                @case('waiting')
                                                    <span class="badge badge-danger mr-2">@lang('customize.'.$invoice->status)</span>
                                                    @break
                                                @case('matched')
                                                    <span class="badge badge-warning mr-2">@lang('customize.'.$invoice->status)</span>
                                                    @break
                                                @case('managed')
                                                    <span class="badge badge-success mr-2">@lang('customize.'.$invoice->status)</span>
                                                    @break
                                                @default
                                                    <span class="badge mr-2">@lang('customize.'.$invoice->status)</span>
                                            @endswitch
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                        @if ($key + 1 < count($invoice_groups))
                            <hr>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        {{--
        <div class="col-md-12 col-lg-10 col-xl-8">
            <hr>
        </div> --}}
    </div>

@stop