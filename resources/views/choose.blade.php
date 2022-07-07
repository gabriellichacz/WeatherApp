@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="container-fluid text-white-50 bg-dark-custom">
  <div class="px-lg-3">

    <!-- Header -->
    <div class="row py-5">
      <div class="col-lg-12 mx-auto">
        <div class="text-black p-3 shadow-sm rounded text-center text-white-50">
          <h3> Wybierz 3 miasta do obserowania </h3>
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

  </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"> </script>

@endsection
