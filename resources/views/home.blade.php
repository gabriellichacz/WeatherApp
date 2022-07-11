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
            @for ($i = 0; $i < count($Cities); $i++) <!-- Data from DB -->
            <option value="{{ $CitiesIDs[$i] }}|{{ $Cities[$i] }}"> {{ $Cities[$i] }} </option>
            @endfor
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
            <p class="m-2">
              <a href="/details/{{ $data_array[$i][3] }}" class="btn bg-white text-black" type="button">
                Wyświetl historię
              </a>
            </p>
          </div>
        </div>
        <!-- End of City card -->
      @endfor
    </div>
    <!-- end of Cards -->


  </div>
</div>


<!-- Links for multiselect list -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"> </script>

@endsection
