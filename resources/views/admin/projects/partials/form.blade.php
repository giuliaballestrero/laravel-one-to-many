{{--Creo un unico form per edit e create || 
    creo una variabile per la rotta--}}

<form action="{{ route($routeName, $project) }}" method="POST" enctype="multipart/form-data" class="py-5">
    @csrf
    {{--Inserisco il metodo PUT per la rotta update // vedere rotte con route:list--}}
    @method($method)

    <div class="card px-5 py-5">

        <div class="form-outline w-25 mb-3">
            <label for="Title" class="form-label @error('title') is-invalid @enderror">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Insert title" name="title" value="{{old('title', $project->title)}}">
            {{--inserisco l'errore sotto al singolo input--}}
            @error('title')
                <div class="invalid-feedback px-2">
                    <i class="fa-solid fa-circle-exclamation pe-1"></i>{{ $message }}
                </div>
            @enderror         
        </div>

        <div class="form-outline w-100 mb-3">
            <label for="Description<" class="form-label @error('description') is-invalid @enderror">Description</label>
            <input type="text" class="form-control" id="description" placeholder="Insert description" name="description" value="{{old('description', $project->description)}}">
            @error('description')
                <div class="invalid-feedback px-2">
                    <i class="fa-solid fa-circle-exclamation pe-1"></i>{{ $message }}
                </div>
            @enderror                  
        </div>

        <div class="form-outline w-25 mb-3">
            <label for="Thumb" class="form-label @error('thumb') is-invalid @enderror">Select image:</label>
            <input type="file" class="form-control" id="thumb" placeholder="Insert path" name="thumb" value="{{old('thumb', $project->thumb)}}">
        @error('thumb')
            <div class="invalid-feedback px-2">
                <i class="fa-solid fa-circle-exclamation pe-1"></i>{{ $message }}
            </div>
        @enderror  
        </div>

        <div class="form-outline w-25 mb-3">
            <label for="creation_date" class="form-label @error('creation_date') is-invalid @enderror">Creation Date</label>
            <input type="date" class="form-control" id="creation_date" placeholder="Insert creation date" name="creation_date" value="{{old('creation_date', $project->creation_date)}}">
        @error('creation_date')
            <div class="invalid-feedback px-2">
                <i class="fa-solid fa-circle-exclamation pe-1"></i>{{ $message }}
            </div>
        @enderror  
        </div>

        <div class="form-outline w-25 mb-3">
            <label for="Type" class="form-label @error('type_id') is-invalid @enderror">Type</label>
            <select  class="form-control" id="type_id" name="type_id" >
                <option value="">Select type...</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}"
                        {{ old('type_id', $project->type_id) ==  $type->id ? 'selected' : 'Select type...' }}> {{ $type->name }}
                    </option>
                @endforeach
            </select>
        @error('type_id')
            <div class="invalid-feedback px-2">
                <i class="fa-solid fa-circle-exclamation pe-1"></i>{{ $message }}
            </div>
        @enderror  
        </div>
        
        <div class="mb-3">
            <input class="form-check-input" type="checkbox" value="1" {{ old('completed', $project->completed) ? 'checked' : '' }} name="completed" id="completed">
            <label class="form-check-label" for="completed">Completed</label>
        </div>
    </div>

    <div class="card-footer text-end py-4 d-flex justify-content-between">
        <a href="{{ route('admin.projects.index')}}" class="btn btn-dark rounded-circle"><i class="fa-solid fa-angles-left"></i></a>
        <button type="submit" class="btn btn-success rounded-circle"><i class="fa-solid fa-plus"></i></i></button>
    </div>

</form>