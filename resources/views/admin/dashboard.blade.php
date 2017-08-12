@extends('admin.layouts.base')

@section('title')
    {{ $title }}
@endsection

@section('description')
    {{ $description }}
@endsection

@section('info-box')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                        <span class="info-box-icon bg-red">
                            <i class="icon fa fa-sitemap"></i>
                        </span>
                <div class="info-box-content">
                    <span class="info-box-text">دسته بندی ها</span>
                    <span class="info-box-number">{{ $category_count }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                        <span class="info-box-icon bg-green">
                            <i class="icon ion-pizza"></i>
                        </span>
                <div class="info-box-content">
                    <span class="info-box-text">محصولات</span>
                    <span class="info-box-number">{{ $product_count }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                        <span class="info-box-icon bg-aqua">
                            <i class="icon fa fa-shopping-basket"></i>
                        </span>
                <div class="info-box-content">
                    <span class="info-box-text">سفارشات</span>
                    <span class="info-box-number">{{ $order_count }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                        <span class="info-box-icon bg-yellow">
                            <i class="icon ion-ios-people"></i>
                        </span>
                <div class="info-box-content">
                    <span class="info-box-text">کاربران</span>
                    <span class="info-box-number">{{ $user_count }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        var salesChartCanvas = $('#ordersChart').get(0).getContext('2d');
        var salesChart = new Chart(salesChartCanvas);
        var salesChartData = {
            labels: [
                @foreach($weeks as $week)
                    '{{ $week }}',
                @endforeach
            ],
            datasets: [
                {
                    label: 'Products',
                    fillColor: 'rgb(210, 214, 222)',
                    strokeColor: 'rgb(210, 214, 222)',
                    pointColor: 'rgb(210, 214, 222)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgb(220,220,220)',
                    data: [
                        @foreach($orders as $order)
                        {{ $order }},
                        @endforeach
                    ]
                }
            ]
        };
        var salesChartOptions = {
            showScale: true,
            scaleShowGridLines: false,
            scaleGridLineColor: 'rgba(0,0,0,.05)',
            scaleGridLineWidth: 1,
            scaleShowHorizontalLines: true,
            scaleShowVerticalLines: true,
            bezierCurve: true,
            bezierCurveTension: 0.3,
            pointDot: false,
            pointDotRadius: 4,
            pointDotStrokeWidth: 1,
            pointHitDetectionRadius: 20,
            datasetStroke: true,
            datasetStrokeWidth: 2,
            datasetFill: true,
            maintainAspectRatio: true,
            responsive: true
        };
        salesChart.Line(salesChartData, salesChartOptions);
    </script>
@endsection