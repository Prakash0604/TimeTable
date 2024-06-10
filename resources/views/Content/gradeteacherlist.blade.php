@extends('index')
@section('content')
    <div class="container mt-4">
        <h1 class="text-center">Grade Teacher List</h1>
     <div class="row mt-4">
        @forelse ($gradesteacher->teacher as $teacher)
        <div class="col-md-4 mb-4">
        <div class="card">
            @if ($teacher->image!="")
            <img src="{{ asset('storage/images/'.$teacher->image) }}" class="card-img-top" width="200px" height="200px" alt="...">
            @else
            <img src="{{ asset('default.jpg') }}" class="card-img-top" width="200px" height="200px" alt="...">
            @endif
            <div class="card-body">
              <h5 class="card-title">Name :{{ $teacher->teacher_name }}</h5>
              <p class="card-text">Subject:{{ $teacher->subject->subject_name }}</p>
            </div>
        </div>
        </div>
        @empty
        <div class="container">
            <h3 class="text-center">
                No data found
            </h3>
        </div>
        @endforelse
        </div>
    </div>
@endsection
