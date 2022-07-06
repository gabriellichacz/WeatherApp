@extends('layouts.app')

@section('content')
<div class="container bg-dark-custom">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">{{ __('Dashboard') }}</div>

                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Jesteś zalogowany') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
