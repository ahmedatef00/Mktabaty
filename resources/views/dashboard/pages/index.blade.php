@extends('dashboard.layouts.main')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <div class="card card-chart">
                    <div class="card-header card-header-success">
                        <div class="ct-chart" id="dailySalesChart"></div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Daily Sales</h4>
                        <p class="card-category">
                            <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today
                            sales.
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">access_time</i> updated 4 minutes ago
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection