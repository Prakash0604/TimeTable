@extends('index')
@section('content')
    <div class="container">
        {{-- Add Teacher Modal Start --}}
        <!-- Button trigger modal -->
        <button
            type="button"
            class="btn btn-primary btn-lg mt-4"
            data-bs-toggle="modal"
            data-bs-target="#modalId"
        >
            Add Teacher
        </button>

        <div class="text-center mt-3 mb-3">
            <h1>Teachers List</h1>
        </div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="modalId"
            tabindex="-1"
            role="dialog"
            aria-labelledby="modalTitleId"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="addTeacher">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Add Teacher
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            @csrf
                                <div class="mb-3">
                                    <label for="" class="form-label">Teacher Name</label>
                                    <input
                                        type="text"
                                        name="teacher_name"
                                        class="form-control"
                                        placeholder="Enter teachers name"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Grade</label>
                                    <select
                                        class="form-select form-select-lg"
                                        name="grade_name"
                                    >
                                        @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->grade_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Subject</label>
                                    <select
                                        class="form-select form-select-lg"
                                        name="subject_name"
                                    >
                                    @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Image</label>
                                    <input
                                        type="file"
                                        name="image"
                                        class="form-control"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Status</label>
                                    <select
                                        class="form-select form-select-lg"
                                        name="status"
                                    >
                                        <option selected value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>




                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                        <button type="submit" id="btnsave" class="btn btn-primary">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>


        <div class="container mt-4">
            <div
                class="table-responsive"
            >
                <table
                    class="table table-bordered"
                >
                    <thead>
                        <tr>
                            <th scope="col">S.N</th>
                            <th scope="col">Image</th>
                            <th scope="col">Teacher Name</th>
                            <th scope="col"> Class</th>
                            <th scope="col"> Subject</th>
                            <th scope="col"> Status</th>
                            <th scope="col"> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $n=1;
                        @endphp
                        @foreach ($teachers as $teacher)
                        <tr class="">
                            <td>{{ $n }}</td>
                            <td>
                                @if ($teacher->image!=null)
                                <img src="{{ asset('storage/images/'.$teacher->image) }}" alt="" class="rounded-circle" height="100" width="100">
                                @else
                                <img src="{{ asset('default.jpg') }}" alt="" class="rounded-circle" height="100" width="100">

                                @endif
                            </td>
                            <td>{{ $teacher->teacher_name }}</td>
                            <td>{{ $teacher->grade->grade_name }}</td>
                            <td>{{ $teacher->subject->subject_name }}</td>
                            <td><span class="badge badge-pill bg-{{ $teacher->status ? "success":"danger" }} rounded-pill">{{ $teacher->status ?"Active":"Inactive" }}</span></td>
                            <td>
                                <a href="" class="btn btn-primary">Edit</a>
                                <a href="" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @php
                            $n=$n+1;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <script>
            $(document).ready(function(){
                $("#addTeacher").submit(function(event){
                    event.preventDefault();
                    $("#btnsave").prop("disabled",true);
                    $("#btnsave").text("Saving...");
                    let formdata=new FormData(this);
                    $.ajax({
                        method:"POST",
                        url:"{{ url('/setup/teacher') }}",
                        data:formdata,
                        processData:false,
                        contentType:false,
                        success:function(data){
                            console.log(data);
                        }
                    })
                });
            });
        </script>

        {{-- Add Teacher Modal End --}}
    </div>
@endsection
