@extends('layouts.app')
@section('content')
<div class="container-fluid p-0">    
    <div class="page_level">
        <div class="page_show">
            <div class="page_title" id="page_title">
                <span class="page_title_span">硬體管理</span>
                <i class="fas fa-chevron-right page_title_arrow"></i>
                <a  href="/purchase" class="page_title_a" >倉儲查詢</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 mb-3">
                <button class="btn btn-green rounded-pill">點此看倉庫平面圖</button>
            </div>
            <div class="col-lg-6 mb-3 d-flex justify-content-end">
                <button class="btn btn-green rounded-pill" onclick="location.href='{{route('reserve.create')}}'">新增物品</button>
            </div>
        </div>
        <div class="row" style="height: 40rem;">
            <div class="col-lg-3 mb-3">
                <div class="card border-0 shadow h-100 effect">
                    <div class="card-body">
                        <div class="col-lg-12 text-center" style="padding-top: 4rem;" onclick="location.href='{{route('reserve.show', 'largeInventory')}}'">
                            <h3>大型雜物</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card border-0 shadow h-100 effect">
                    <div class="card-body">
                        <div class="col-lg-12 text-center" style="padding-top: 4rem;" onclick="location.href='{{route('reserve.show', 'eventInventory')}}'">
                            <h3>活動器具</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card border-0 shadow h-100 effect">
                    <div class="card-body">
                        <div class="col-lg-12 text-center" style="padding-top: 3.5rem;" onclick="location.href='{{route('reserve.show', 'XinWuAndHakaInventory')}}'">
                            <h5>農博及客家器材道具</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card border-0 shadow h-100 effect">
                    <div class="card-body">
                        <div class="col-lg-12 text-center" style="padding-top: 3.5rem;" onclick="location.href='{{route('reserve.show', 'eventSpareAndClothes')}}'">
                            <h5>
                                活動常用
                                <br>
                                備品及衣服
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card border-0 shadow h-100 effect">
                    <div class="card-body">
                        <div class="col-lg-12 text-center" style="padding-top: 4rem;" onclick="location.href='{{route('reserve.show', 'jetpotPrizeEventAppliance')}}'">
                            <h3>抽獎品/活動器具</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card border-0 shadow h-100 effect">
                    <div class="card-body">
                        <div class="col-lg-12 text-center" style="padding-top: 4rem;" onclick="location.href='{{route('reserve.show', 'appliance1')}}'">
                            <h2>器材櫃1</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card border-0 shadow h-100 effect">
                    <div class="card-body">
                        <div class="col-lg-12 text-center" style="padding-top: 4rem;" onclick="location.href='{{route('reserve.show', 'appliance2')}}'">
                            <h2>器材櫃2</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card border-0 shadow h-100 effect">
                    <div class="card-body">
                        <div class="col-lg-12 text-center" style="padding-top: 4rem;" onclick="location.href='{{route('reserve.show', 'historyDocument')}}'">
                            <h2>歷年教案</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card border-0 shadow h-100 effect">
                    <div class="card-body">
                        <div class="col-lg-12 text-center" style="padding-top: 3rem;" onclick="location.href='{{route('reserve.show', 'historyAccountingData')}}'">
                            <h2>歷年</h2>
                            <h3>會計資料</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card border-0 shadow h-100 effect">
                    <div class="card-body">
                        <div class="col-lg-12 text-center" style="padding-top: 3rem;" onclick="location.href='{{route('reserve.show', 'historyProject')}}'">
                            <h2>歷年</h2>
                            <h3>專案歸檔</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="card border-0 shadow h-100 effect">
                    <div class="card-body">
                        <div class="col-lg-12 text-center" style="padding-top: 4rem;" onclick="location.href='{{route('reserve.show', 'stationery')}}'">
                            <h2>文具</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script>

</script>

@stop