@extends('layouts.app')

@section('content')

<!-- Body -->
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
          <h5 class="display-5"> {{ __('Wybierz 3 miejscowości do obserowania') }} </h5>
        </div>
      </div>
    </div>
    <!-- End of header -->

    <!-- List -->
    <div class="row py-2 text-center">
      <form action="/store" enctype="multipart/form-data" method="post">
        @csrf
          <select name="CitySelector" class="form-control selectpicker">
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
      @for ($i = 0; $i <= count($chosenCitiesIDs)-1; $i++)
        <!-- City card -->
        <div class="col-xl-4 col-lg-3 col-md-6 mb-4">
          <div class="p-2">
            <!-- <div class="rounded shadow-sm">
              <img src="#" class="img-fluid card-img-top" alt="City">
            </div> -->
          </div>
          <div class="p-3 text-white-50 text-center">
            <p class="text-decoration-none display-6"> {{ $data_array[$i][0] }} </p>
            <p class="mb-0"> {{ __('Temperatura:') }} {{ $data_array[$i][1] }}°C </p>
            <p class="mb-0"> {{ __('Wilgotność:') }} {{ $data_array[$i][2] }}% </p>
            <p class="m-2">
              <a href="/details/{{ $data_array[$i][3] }}" class="btn bg-white text-black" type="button">
                {{ __('Wyświetl historię') }}
              </a>
            </p>
            <p class="m-2">
              <a href="/delete/{{ $data_array[$i][3] }}" class="btn bg-white text-black" type="button">
                {{ __('Usuń z obserowanych') }}
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
<!-- end of Body -->

@endsection
