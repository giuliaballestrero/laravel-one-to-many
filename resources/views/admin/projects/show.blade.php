@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!--Aggiungo un if session per i messaggi di conferma azioni-->
    @if (session('message'))
        <div class=" mt-5 alert alert-{{ session('alert-type') }}">
                {{ session('message')}}
        </div>
    @endif
    <div class="card text-center">
        <div class="card-header text-light fs-5">
            Author: <span class="fw-bold">{{ Auth::user()->name }} </span>
        </div>
        <div class="card-body p-3 m-3">
            <div class="d-flex justify-content-between">
                @if (@isset($prevProject))
                    <a class="next-prev" href="{{route('admin.projects.show', $prevProject->slug)}}"><i class="fa-solid fa-chevron-left me-1"></i>Prev</a>
                @else 
                    <a class="next-prev-disabled" href=""><i class="fa-solid fa-chevron-left me-1"></i>Prev</a>
                @endif
                @if (@isset($nextProject))
                  <a class="next-prev" href="{{route('admin.projects.show', $nextProject->slug)}}">Next<i class="fa-solid fa-chevron-right ms-1"></i></a>  
                @else 
                    <a class="next-prev-disabled" href="">Next<i class="fa-solid fa-chevron-right ms-1"></i></a>
                @endif
            </div>
            <h2 class="card-title fw-bold p-3">
                {{ $project->title }}
            </h2>

            @if ( $project->isImageAUrl())
            <img src="{{$project->thumb}}" class="card-img-top img-fluid" alt="{{$project->title}}">
            @else
            <img src="{{asset('storage/' . $project->thumb)}}" class="card-img-top img-fluid" alt="{{$project->title}}">
            @endif


            <p class="card-textpt-4 pt-4 mb-4">
                {{ $project->description }}
            </p>
            <p class="fw-bold py-3">
                Tag: <a class="btn btn-disabled rounded-pill" style="background-color: {{$project->type->color}} ">{{$project->type->name}}<a>
            </p>
            <div class="d-flex justify-content-center">
                <a href="{{ route('admin.projects.edit', $project->slug) }}" class="btn btn-success rounded-circle me-2">
                    <i class="fa-solid fa-pencil"></i>
                </a>

                {{-- inserire il bottone in un form --}}
                <form class="delete" action="{{ route('admin.projects.destroy', $project->slug) }}"
                    method="POST">
                    @csrf
                    {{-- utilizzo il metodo delete --}}
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger delete rounded-circle" title="delete">
                    <i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
        </div>
        <div class="card-footer text-muted">
            Created on {{ $project->creation_date }} - Proj. id: {{ $project->slug }}
        </div>
    </div>
</div>
@endsection