@extends('layouts.app')

@section('content')
    @include('admin.partials.popup')

    <div class="container">
        <!--Aggiungo un if session per i messaggi di conferma azioni-->
        @if (session('message'))
            <div class=" mt-5 alert alert-{{ session('alert-type') }}">
                {{ session('message') }}
            </div>
        @endif

        <h1 class="pt-5 text-center">{{ Auth::user()->name }} Projects</h1>

        <div class="pt-3 d-flex justify-content-between">
            <a class="btn btn-danger rounded-circle" href="{{ route('projects.trash') }}">
                <i class="fa-solid fa-trash"></i>
            </a>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-success rounded-circle">
                <i class="fa-solid fa-plus"></i>
            </a>
        </div>
        <table class="table table-striped table-borderless table-hover mt-5">
            <thead>
                <tr>
                    <th scope="col">#id</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Thumb</th>
                    <th scope="col">Date</th>
                    <th scope="col">Type</th>
                    <th scope="col">Completed</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->slug }}</td>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->description }}</td>
                        <td>{{ $project->thumb }}</td>
                        <td>{{ $project->creation_date }}</td>
                        <td>{{ $project->type->name }}</td>
                        <td class="text-center">
                            @if ($project->completed == 0)
                                <i class="fa-solid fa-spinner"></i>
                            @elseif ($project->completed == 1)
                                <i class="fa-regular fa-circle-check"></i>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('admin.projects.show', $project->slug) }}"
                                    class="btn btn-sm btn-primary rounded-circle me-1">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.projects.edit', $project->slug) }}"
                                    class="btn btn-sm btn-warning rounded-circle me-1">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>

                                {{-- per la delete inserire il bottone in un form --}}

                                <form class="delete" action="{{ route('admin.projects.destroy', $project->slug) }}"
                                    method="POST">
                                    @csrf
                                    {{-- utilizzo il metodo delete --}}
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete rounded-circle"
                                        title="delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- inserisco la pagination --}}
        <div class="py-5">
            {{ $projects->links() }}
        </div>

    </div>
@endsection

@section('script')
    @vite('resources/js/confirmDelete.js')
@endsection
