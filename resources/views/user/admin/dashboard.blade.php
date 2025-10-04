<?php
$dish = \App\Models\Dish::all();
$waiter = \App\Models\User::where('role', 4)->get();
$kitchen = \App\Models\User::where('role', 3)->get();

?>

<div class="row">
    <div class="col-md-6 col-lg-4">
        <div class="widget-bg-color-icon card-box fadeInDown animated">
            <div class="bg-icon bg-icon-success pull-left">
                <i class="md md-trending-up text-success"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter">
                            {{ number_format($today_order->total_paid ) }}
                    </b></h3>
                <p class="text-muted">Today's Sell</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-warning pull-left">
                <i class="md md-remove-circle text-warning"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter">
                        {{config('restaurant.currency.symbol')}} {{number_format($today_expanse)}}
                    </b></h3>
                <p class="text-muted">Today's expanse</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-info pull-left">
                <i class="md md-receipt text-info"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter">
                       {{ $today_order->order_count }}
                    </b></h3>
                <p class="text-muted">Today's Order</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-success pull-left">
                <i class="md md-account-balance-wallet text-success"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter">
                        {{ number_format($today_order->total_paid-$today_expanse ) }}
                    </b></h3>
                <p class="text-muted">Today's Income</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-primary pull-left">
                <i class="md md-account-balance text-primary"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b class="counter">
                        {{ number_format($total_order_paid ) }}
                    </b></h3>
                <p class="text-muted">qasa</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

</div>

<div class="col-lg-12">
    <div class="card-box">
        <h4 class="text-dark header-title m-t-0">Dish Sells today</h4>
        <div class="text-center">

        </div>
        <div id="myfirstchart" style="height: 303px;">

        </div>

    </div>
</div>

<div class="col-lg-12">
    <div class="card-box">
        <h4 class="text-dark header-title m-t-0">Daily Order by Waiter</h4>
        <div class="text-center"></div>
        <div id="dailyOrderByWaiter" style="height: 303px;">

        </div>

    </div>
</div>

<div class="col-lg-12">
    <div class="card-box">
        <h4 class="text-dark header-title m-t-0">Daily Order by Kitchen</h4>
        <div class="text-center"></div>
        <div id="dailyOrderByKitchen" style="height: 303px;">

        </div>

    </div>
</div>

{{--
<pre>--}}
{{--{{count($kitchen[0]->kitchenOrderToday)}}--}}
{{--{{count($kitchen[1]->kitchenOrderToday)}}--}}
{{--</pre>--}}

@section('extra-js')

<script src="{{url('/dashboard/plugins/raphael/raphael-min.js')}}"></script>
<script src="{{url('/dashboard/plugins/morris/morris.min.js')}}"></script>
<script>
    $(document).ready(function () {
            new Morris.Bar({
                // ID of the element in which to draw the chart.
                element: 'myfirstchart',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data:

                    [
                            @foreach($dish as $d)
                        {
                            year: '{{$d->dish}}' + '({{count($d->todaysOrderDish)}})',
                            value: {{count($d->todaysOrderDish)}}
                        },
                        @endforeach
                    ],
                goalLineColors: ['red', 'green', 'blue'],
                // The name of the data record attribute that contains x-values.
                xkey: 'year',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['value'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['Total Order'],
                barColors: ['orangered'],
                gridTextColor: '#000',
                gridTextSize: '15px',
                resize: true
            });

            new Morris.Bar({
                // ID of the element in which to draw the chart.
                element: 'dailyOrderByWaiter',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data:

                    [@foreach($waiter as $w)
                    {
                        year: '{{$w->name}}' + '({{count($w->waiterOrdersToday)}})',
                        value: {{count($w->waiterOrdersToday)}}
                    },
                        @endforeach
                    ],

                // The name of the data record attribute that contains x-values.
                xkey: 'year',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['value'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['Total Order'],
                barColors: ['blue'],
                gridTextColor: '#000',
                gridTextSize: '15px',
                resize: true
            });

            new Morris.Bar({
                // ID of the element in which to draw the chart.
                element: 'dailyOrderByKitchen',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data:

                    [@foreach($kitchen as $k)
                    {
                        year: '{{$k->name}}' + '({{count($k->kitchenOrderToday)}})',
                        value: {{count($k->kitchenOrderToday)}}
                    },
                        @endforeach
                    ],

                // The name of the data record attribute that contains x-values.
                xkey: 'year',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['value'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['Total Order'],
                barColors: ['green'],
                gridTextColor: '#000',
                gridTextSize: '15px',
                resize: true
            });
        })
</script>
@endsection
