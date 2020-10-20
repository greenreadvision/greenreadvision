@extends('layouts.app')
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6 mb-3">
            <!-- <h2>{{__('customize.Project')}}</h2> -->
        </div>
        <div class="col-lg-6 mb-3">
            <button class="float-right btn btn-primary btn-primary-style" onclick="location.href='{{route('purchase.create')}}'"><i class='fas fa-plus'></i><span class="ml-3">{{__('customize.Add')}}</span> </button>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    <div class="col-lg-10">
        <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
            <label class="btn btn-secondary active">
                <input type="radio" name="type1" id="type1" onchange="changeCompanyType(0)" autocomplete="off" checked> {{__('customize.grv')}}
            </label>
            <label class="btn btn-secondary ">
                <input type="radio" name="type2" id="type2" onchange="changeCompanyType(1)" autocomplete="off"> {{__('customize.rv')}}
            </label>
        </div>

        <div id="purchase-grv">
            <div class="card card-style">
                <div class="card-body ">
                    <div class="col-lg-12">
                    @foreach($years as $year)
                    <div class="text-center col-lg-12 collapse-style py-3 " data-toggle="collapse" data-target="#multiCollapse{{$year}}" aria-expanded="false" aria-controls="multiCollapse{{$year}}">{{$year}}年</div>
                    <div class="collapse multi-collapse" id="multiCollapse{{$year}}">
                        @foreach ($purchase_groups as $key => $purchases)
                        @if($purchases[0]->project['company_name']=='grv'&& substr($purchases[0]->project->open_date,0,4)==$year)
                        <div class="col-lg-12">
                            <div onclick="location.href='{{route('purchase.list', $purchases[0]->project['project_id'])}}'" class="row collapse-style" style=" background-color:{{$purchases[0]->project->color}}11">
                                <div class="col-lg-12 py-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <span style="background-color:{{$purchases[0]->project->color}}; border-radius: 100rem; width: 10px; height: 10px; display: inline-block; margin-right: .5rem; box-shadow:0 0 5px {{$purchases[0]->project->color}};"></span>
                                        <span class="d-inline-block " style="text-decoration:none;">{{$purchases[0]->project['name']}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div id="purchase-rv">
            <div class="card card-style">
                <div class="card-body ">
                    <div class="col-lg-12">
                    @foreach($years as $year)
                    <div class="text-center col-lg-12 collapse-style py-3 " data-toggle="collapse" data-target="#RVmultiCollapse{{$year}}" aria-expanded="false" aria-controls="RVmultiCollapse{{$year}}">{{$year}}年</div>
                    <div class="collapse multi-collapse" id="RVmultiCollapse{{$year}}">
                    @foreach ($purchase_groups as $key => $purchases)
                        @if($purchases[0]->project['company_name']=='rv' && substr($purchases[0]->project->open_date,0,4)==$year)
                        <div class="col-lg-12">
                            <div onclick="location.href='{{route('purchase.list', $purchases[0]->project['project_id'])}}'" class="row collapse-style" style=" background-color:{{$purchases[0]->project->color}}11">
                                <div class="col-lg-12 py-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <span style="background-color:{{$purchases[0]->project->color}}; border-radius: 100rem; width: 10px; height: 10px; display: inline-block; margin-right: .5rem; box-shadow:0 0 5px {{$purchases[0]->project->color}};"></span>
                                        <span class="d-inline-block " style="text-decoration:none;">{{$purchases[0]->project['name']}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        </div>
                    @endforeach
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>
    function changeCompanyType(i) {
        if (i == 0) {
            document.getElementById('purchase-grv').style.display = "block"
            document.getElementById('purchase-rv').style.display = "none"

        } else {
            document.getElementById('purchase-grv').style.display = "none"
            document.getElementById('purchase-rv').style.display = "block"
        }

    }
</script>
<script src="{{ URL::asset('js/grv.js') }}"></script>
@stop