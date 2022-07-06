@extends('layouts.app')

@section('content')



<div class="container-fluid text-white-50 bg-dark-custom">
  <div class="px-lg-3">

    <!-- Header -->
    <div class="row py-5">
      <div class="col-lg-12 mx-auto">
        <div class="text-black p-3 shadow-sm rounded banner text-center text-white-50">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
          <h4 class="display-3"> {{ __('Jesteś zalogowany') }} </h1>
        </div>
      </div>
    </div>
    <!-- End of header -->

    <!-- Cards -->
    <div class="row"> 

      <!-- City card -->
      <div class="col-xl-4 col-lg-3 col-md-6 mb-4">
        <div class="p-2">
          <div class="rounded shadow-sm">
            <img src="#" class="img-fluid card-img-top" alt="City">
          </div>
        </div>
        <div class="p-3 text-white-50 text-center">
          <h4 class="text-decoration-none"> Nazwa miasta </h4>
          <p class="mb-0"> Temperatura: </p>
          <p class="mb-0"> Temperatura odczuwalna: </p>
          <p class="mb-0"> Temperatura min: </p>
          <p class="mb-0"> Temperatura max: </p>
          <p class="mb-0"> Wilgotność: </p>
        </div>
      </div>
      <!-- End of City card -->

      <!-- City card -->
      <div class="col-xl-4 col-lg-3 col-md-6 mb-4">
        <div class="p-2">
          <div class="rounded shadow-sm">
            <img src="#" class="img-fluid card-img-top" alt="City">
          </div>
        </div>
        <div class="p-3 text-white-50 text-center">
          <h4 class="text-decoration-none"> Nazwa miasta </h4>
          <p class="mb-0"> Temperatura: </p>
          <p class="mb-0"> Temperatura odczuwalna: </p>
          <p class="mb-0"> Temperatura min: </p>
          <p class="mb-0"> Temperatura max: </p>
          <p class="mb-0"> Wilgotność: </p>
        </div>
      </div>
      <!-- End of City card -->

      <!-- City card -->
      <div class="col-xl-4 col-lg-3 col-md-6 mb-4">
        <div class="p-2">
          <div class="rounded shadow-sm">
            <img src="#" class="img-fluid card-img-top" alt="City">
          </div>
        </div>
        <div class="p-3 text-white-50 text-center">
          <h4 class="text-decoration-none"> Nazwa miasta </h4>
          <p class="mb-0"> Temperatura: </p>
          <p class="mb-0"> Temperatura odczuwalna: </p>
          <p class="mb-0"> Temperatura min: </p>
          <p class="mb-0"> Temperatura max: </p>
          <p class="mb-0"> Wilgotność: </p>
        </div>
      </div>
      <!-- End of City card -->


    </div>
    <!-- end of Cards -->

  </div>
</div>

@endsection
