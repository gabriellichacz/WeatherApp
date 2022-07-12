@extends('layouts.app')

@section('content')


<div class="container-fluid text-white-50 bg-dark-custom">
    <div class="px-lg-3">
        <div class="text-center">
            <!-- Charts -->
            <div class="row py-2 text-center">
                <div class="col m-4">
                <p class="display-6"> {{ __('Wykres temperatur') }} </p>
                <p id="HistoryChartContainer"></p>
                </div>
                <div class="col m-4">
                <p class="display-6"> {{ __('Wykres wilgotności') }} </p>
                <p id="HistoryChartContainer1"></p>
                </div>
            </div>
            <!-- end of Charts -->
        </div>
    </div>
</div>


<!-- Scripts for charts -->
<script src="https://unpkg.com/chart.js@^2.9.3/dist/Chart.min.js"></script>
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
<script>
  const chart = new Chartisan({
    el: '#HistoryChartContainer',
    url: "@chart('history_chart')" + "?id={{ $cityID }}",
    hooks: new ChartisanHooks()
    .colors()
    .datasets('scatter'),
});

const chart1 = new Chartisan({
    el: '#HistoryChartContainer1',
    url: "@chart('history_chart1')" + "?id={{ $cityID }}",
    hooks: new ChartisanHooks()
    .colors()
    .datasets('scatter'),
})
</script>
<!-- end of Scripts for charts -->

@endsection