
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-3 pt-5 text-center">
        Create a new post from <span class="fw-semibold">{{ Auth::user()->name }} </span>
    </h1>

    @include('admin.projects.partials.form', [ 'method' => 'POST', 'routeName' => 'admin.projects.store'])

</div>
@endsection