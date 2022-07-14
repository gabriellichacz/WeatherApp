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
            <div class="alert alert-success md-2" role="alert">
              {{ session('status') }}
            </div>
          @endif
          <h5 class="display-5"> {{ __('Dodaj miejscowość do obserwowanych') }} </h5>
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
    <!-- end of List -->

    <!-- testing -->
    <div>

    </div>
    <!-- end of testing -->


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


<!-- List livesearch -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<div class="container mt-5">
  <form action="/store" enctype="multipart/form-data" method="post">
    @csrf
    <select class="livesearch form-control" name="livesearch">
    </select>
    <button type="submit" class="btn bg-white text-black m-2"> Zapisz </button>
  </form>
</div>

<script type="text/javascript">
  $('.livesearch').select2({
    placeholder: 'Wybierz miasto',
    ajax: {
      url: '/select_search',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.id,
              text: item.name
            }
          })
        };
      },
      cache: true
    }
    });
  </script>
<!-- end of List livesearch -->


@endsection