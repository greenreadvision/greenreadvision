@extends('layouts.app') 
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row box">
                @foreach ($data as $project)
                <div class="col-12 col-lg-6 item">
                    <div class="card" style="margin: 10px 0px;">
                        <div class="card-header" style="display: flex; align-items: center;">
                            <span style="background-color:{{$project->color}}; border-radius: 100rem; width: 15px; height: 15px; display: inline-block; margin-right: .5rem; box-shadow:0 0 10px {{$project->color}};"></span>
                            <a href="{{route('project.review', $project->project_id)}}/" style="color:black; font-size:1.5rem;">{{$project->name}}</a>                            @if($project['finished'])
                            <span class="float-right text-success" style="font-size:1.5rem;">@lang('customize.finished')</span>                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="mb-3" style="font-weight: bold;">{{__('customize.Information')}}</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p>{{__('customize.User')}}<br>{{$project['user']['name']}}</p>
                                    <p>{{__('customize.Beginning')}}{{__('customize.Date')}}<br>{{$project['beginning_date']}}</p>
                                    <p>{{__('customize.Deadline')}}{{__('customize.Date')}}<br>{{$project['deadline_date']}}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p>{{__('customize.Closing')}}{{__('customize.Date')}}<br>{{$project['closing_date']}}</p>
                                    <p>{{__('customize.BidBound')}}<br>{{$project['bid_bound']}}</p>
                                    <p>{{__('customize.Finished')}}<br>{{$project['finished']}}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <h5><b>{{__('customize.Invoice')}}</b></h5>
                                    @if(count($project['invoice']))
                                    <ol class="p-0 pl-3">
                                        @foreach ($project['invoice'] as $key => $invoice)
                                        <li><a href="{{route('invoice.review', $invoice['invoice_id'])}}">{{$invoice['company']}}</a></li>
                                        @endforeach
                                    </ol>
                                    @else
                                    <p>{{__('customize.None')}}</p>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <h5><b>{{__('customize.Todo')}}</b></h5>
                                    @if(count($project['todo']))
                                    <ol class="p-0 pl-3">
                                        @foreach ($project['todo'] as $key => $todo)
                                        <li><a href="{{route('todo.review', $todo['todo_id'])}}">{{$todo['name']}}</a></li>
                                        @endforeach
                                    </ol>
                                    @else
                                    <p>{{__('customize.None')}}</p>
                                    @endif
                                </div>
                                {{--
                                <div class="col-md-6">
                                    <h5><b>{{__('customize.Finance')}}</b></h5>
                                    @if(empty($project['finance']))
                                    <p>{{__('customize.None')}}</p>
                                    @else @foreach ($project['finance'] as $key => $finance)
                                    <p>{{$key+1}} | <a href="{{route('finance.index')}}/{{$finance['finance_id']}}/review">{{$finance['name']}}</a></p>
                                    @endforeach @endif
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-12">
            <hr>
            <button class="btn btn-primary" onclick="location.href='{{route('project.create')}}'">{{__('customize.Add')}}</button>
        </div>
    </div>
@endsection
 
@section('script')
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script>
    const msnyFunc = () => {new Masonry('.box', { itemSelector: '.item' })}
    msnyFunc()
    window.onresize = msnyFunc

</script>



@stop