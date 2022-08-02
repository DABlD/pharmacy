@extends('layouts.app')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>
                            <div class="row">
                                <div class="col-md-4">{{ $rt }}</div>
                                <div class="col-md-4">{{ $rtm }}</div>
                            </div>
                        </h3>
                        <p>
                            <div class="row">
                                <div class="col-md-4">Today</div>
                                <div class="col-md-4">Month</div>
                            </div>
                        </p>
                        <p style="font-weight: bold;">Requests</p>
                    </div>

                    <div class="icon">
                        <i class="fa-solid fa-clipboard-list-check"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>
                            <div class="row">
                                <div class="col-md-4">{{ $it }}</div>
                                <div class="col-md-4">{{ $itm }}</div>
                            </div>
                        </h3>
                        <p>
                            <div class="row">
                                <div class="col-md-4">Today</div>
                                <div class="col-md-4">Month</div>
                            </div>
                        </p>
                        <p style="font-weight: bold;">Issued To</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-clipboard-list-check"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>
                            <div class="row">
                                <div class="col-md-4">{{ $rcvtm }}</div>
                                <div class="col-md-4">{{ $rcvt }}</div>
                            </div>
                        </h3>
                        <p>
                            <div class="row">
                                <div class="col-md-4">Today</div>
                                <div class="col-md-4">Month</div>
                            </div>
                        </p>
                        <p style="font-weight: bold;">Receive</p>
                    </div>

                    <div class="icon">
                        <i class="fa-solid fa-clipboard-list-check"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>
                            <div class="row">
                                <div class="col-md-4">{{ $atm }}</div>
                                <div class="col-md-4">{{ $at }}</div>
                            </div>
                        </h3>
                        <p>
                            <div class="row">
                                <div class="col-md-4">Today</div>
                                <div class="col-md-4">Month</div>
                            </div>
                        </p>
                        <p style="font-weight: bold;">Alerts</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-bell-exclamation"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <section class="col-lg-12 connectedSortable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{-- <i class="fas fa-chart-pie mr-1"></i>
                            Sales --}}
                        </h3>

                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#tab1" data-toggle="tab">Tab 1</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab2" data-toggle="tab">Tab 2</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="tab-content p-0">
                            <div class="chart tab-pane active" id="tab1" style="position: relative; height: 300px;">
                                {{-- TAB 1 --}}
                            </div>
                            <div class="chart tab-pane" id="tab2" style="position: relative; height: 300px;">
                                {{-- TAB 2 --}}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>

@endsection