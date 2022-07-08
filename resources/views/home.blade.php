@extends('layouts.app')

@section('content')

<!-- Links for multiselect list -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>




<div class="container-fluid text-white-50 bg-dark-custom">
  <div class="px-lg-3">

    <!-- Header -->
    <div class="row py-2 text-center">
      <div class="col-lg-12 mx-auto">
        <div class="text-black p-3 shadow-sm rounded text-center text-white-50">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif
          <h5 class="display-5"> Wybierz 3 miasta do obserowania </h5>
        </div>
      </div>
    </div>
    <!-- End of header -->

    <!-- List -->
    <div class="row py-2 text-center">
      <form action="/store" enctype="multipart/form-data" method="post">
        @csrf
          <select name="CitySelector[]" class="form-control selectpicker" multiple data-max-options="3">
            @foreach ($Cities as $City) <!-- Data from DB -->
            <option value="{{ $City }}"> {{ $City }} </option>
            @endforeach
          </select>
          <button type="submit" class="btn bg-white text-black m-2"> Zapisz </button>
        </form>
    </div>
    <!-- List -->

    <!-- Cards -->
    <div class="row py-2 text-center">
      @for ($i = 0; $i <= $max_values_selected-1; $i++)
        <!-- City card -->
        <div class="col-xl-4 col-lg-3 col-md-6 mb-4">
          <div class="p-2">
            <!-- <div class="rounded shadow-sm">
              <img src="#" class="img-fluid card-img-top" alt="City">
            </div> -->
          </div>
          <div class="p-3 text-white-50 text-center">
            <p class="text-decoration-none display-6"> {{ $data_array[$i][0] }} </p>
            <p class="mb-0"> Temperatura: {{ $data_array[$i][1] }}°C </p>
            <p class="mb-0"> Wilgotność: {{ $data_array[$i][2] }}% </p>
          </div>
        </div>
        <!-- End of City card -->
      @endfor
    </div>
    <!-- end of Cards -->

    <!-- Collapsible charts' section -->
    <div class="row py-2 text-center">
      <p class="text-center">
        <button class="btn bg-white text-black" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCharts" aria-expanded="false" aria-controls="collapseCharts">
          Wyświetl historię
        </button>
      </p>
      <div class="collapse" id="collapseCharts">
        <div class="card card-body text-white-50 bg-dark-custom">
          <!-- Charts -->
          <div class="row py-2 text-center">
            <div class="col m-4">
              <p class="display-6"> Wykres temperatur </p>
              <p id="HistoryChartContainer"></p>
            </div>
            <div class="col m-4">
              <p class="display-6"> Wykres wilgotności </p>
              <p id="HistoryChartContainer1"></p>
            </div>
          </div>
          <!-- end of Charts -->
        </div>
      </div>
    </div>
    <!-- end of Collapsible charts' section -->

  </div>
</div>



<!-- Scripts for charts -->
<script src="https://unpkg.com/chart.js@^2.9.3/dist/Chart.min.js"></script>
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
<!-- Links for multiselect list -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"> </script>

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
