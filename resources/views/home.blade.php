@extends('layouts.app')

@section('content')

<div class="container-fluid text-white-50 bg-dark-custom">
  <div class="px-lg-3">

    <!-- Header -->
    <div class="row py-5">
      <div class="col-lg-12 mx-auto">
        <div class="text-black p-3 shadow-sm rounded text-center text-white-50">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif
          <h5 class="display-5"> Jesteś zalogowany </h5>
          <a href="/choose" class="btn bg-white text-black m-2"> Wybierz miasta </a>
        </div>
      </div>
    </div>
    <!-- End of header -->

    <!-- Cards -->
    <div class="row"> 
      @for ($i = 0; $i <= $max_values_selected-1; $i++)
        <!-- City card -->
        <div class="col-xl-4 col-lg-3 col-md-6 mb-4">
          <div class="p-2">
            <!-- <div class="rounded shadow-sm">
              <img src="#" class="img-fluid card-img-top" alt="City">
            </div> -->
          </div>
          <div class="p-3 text-white-50 text-center">
            <h4 class="text-decoration-none"> {{ $data_array[$i][0] }} </h4>
            <p class="mb-0"> Temperatura: {{ $data_array[$i][1] }}°C </p>
            <p class="mb-0"> Wilgotność: {{ $data_array[$i][2] }}% </p>
          </div>
        </div>
        <!-- End of City card -->
      @endfor
    </div>
    <!-- end of Cards -->

    <!-- Chart's container -->
    <div id="HistoryChartContainer"></div>
    <!-- end of Chart's container -->

    <!-- Chart's container -->
    <div id="HistoryChartContainer1"></div>
    <!-- end of Chart's container -->

  </div>
</div>


<!-- Scripts for charts -->
<script src="https://unpkg.com/chart.js@^2.9.3/dist/Chart.min.js"></script>
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

<script>
  const chart = new Chartisan({
    el: '#HistoryChartContainer',
    url: "@chart('history_chart')",
    hooks: new ChartisanHooks()
    .colors()
    .datasets('scatter'),
})

const chart1 = new Chartisan({
    el: '#HistoryChartContainer1',
    url: "@chart('history_chart1')",
    hooks: new ChartisanHooks()
    .colors()
    .datasets('scatter'),
})
</script>
<!-- end of Scripts for charts -->

@endsection
