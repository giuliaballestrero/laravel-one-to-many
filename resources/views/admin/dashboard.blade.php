@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <h3 class="fs-4 text-secondary pb-5">
        {{ __('Dashboard') }}
    </h3>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header text-light fw-bold fs-5 text-center">
                    {{ __('User Dashboard') }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h5 class="py-5 text-center"> Hello {{ Auth::user()->name }}, {{ __('you are logged in!') }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
