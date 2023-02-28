
@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h1 class="text-center py-2 mb-2">Edit project: "{{$project->title}}"</h1>

    @include('admin.projects.partials.form', [ 'method' => 'PUT', 'routeName' => 'admin.projects.update'])

</div>
@endsection