@extends('layouts.app')

@section('content')
@include('admin.partials.popup')

<div class="container py-5">

    <h1 class="text-center">Trashed Projects</h1>
    
    <table class="table table-striped table-borderless table-hover mt-5">
        <thead>
            <tr>
                <th scope="col">#id</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Creation Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>

    @forelse ($projects as $project)    
        <tbody>
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->description }}</td>
                    <td class="text-center">{{ $project->creation_date }}</td>
                    <td>
                        <div class="d-flex">
                            <form action="{{route('projects.restore', $project->id)}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success me-2 rounded-circle" title="restore">
                                    <i class="fa-solid fa-recycle"></i>
                                </button>
                            </form>       

                            <form class="delete double-confirm" action="{{route('projects.force-delete', $project->id)}}" method="POST">
                                @csrf
                                {{--utilizzo il medodo delete per eliminare definitivamente il progetto--}}
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger rounded-circle" title="delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <h5 class="py-5 text-center text-secondary">
                    No projects to show.
                </h5>
            @endforelse
        </tbody>
    </table>

   {{-- inserisco la pagination --}}
  
</div>
@endsection
@section('script')
    @vite('resources/js/confirmDelete.js')
@endsection