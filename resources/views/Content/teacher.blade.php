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


        <div class="container mt-2">
            <form action="" method="GET" class="d-flex">
                <div class="col-3 p-2">
                    <label for="" class="form-label">Grade</label>
                    <select
                        class="form-select form-select-lg"
                        name="grade_select"
                        id=""
                    >
                    <option value="">Select one</option>
                    @forelse ($grades as $grade)
                    <option value="{{ $grade->id }}">{{ $grade->grade_name }}</option>
                    @empty
                    No data found
                    @endforelse
                    </select>
                </div>
                <div class="col-3 p-2">
                    <label for="" class="form-label">Subject</label>
                    <select
                        class="form-select form-select-lg"
                        name="subject_select"
                        id=""
                    >
                        <option value="">Select one</option>
                        @forelse ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                        @empty
                            No data found
                        @endforelse
                    </select>
                </div>
                <div class="col-3 mt-4 d-flex p-3" >
                    <button type="submit" class="btn btn-primary btn-lg">Filter</button>
                </div>
            </form>
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
                        @forelse ($teachers as $teacher)
                        <tr class="">
                            <td>{{ $n }}</td>
                            <td>
                                @if ($teacher->image!=null)
                                <img src="{{ asset('storage/images/'.$teacher->image) }}" alt="" class="img-thumbnail" height="100" width="100">
                                @else
                                <img src="{{ asset('default.jpg') }}" alt="" class="rounded-circle" height="100" width="100">

                                @endif
                            </td>
                            <td>{{ $teacher->teacher_name }}</td>
                            <td>{{ $teacher->grade->grade_name }}</td>
                            <td>{{ $teacher->subject->subject_name }}</td>
                            <td><span class="badge badge-pill bg-{{ $teacher->status ? "success":"danger" }} rounded-pill">{{ $teacher->status ?"Active":"Inactive" }}</span></td>
                            <td>
                                <a href="" class="btn btn-primary editteacher" data-id="{{ $teacher->id }}" data-bs-toggle="modal" data-bs-target="#editModal">Edit</a>
                                <a href="" class="btn btn-danger deleteteacher" data-id="{{ $teacher->id }}"  data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</a>
                            </td>
                        </tr>
                        @php
                            $n=$n+1;
                        @endphp
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No data found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <div>
            {{ $teachers->links('pagination::bootstrap-5'); }}
        </div>
        {{-- Edit Modal Start --}}

        <!-- Modal -->
        <div
            class="modal fade"
            id="editModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="modalTitleId"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="updateTeacher">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Edit Teacher
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
                            <div class="mb-3">
                                @csrf
                                <label for="" class="form-label">Teacher Name</label>
                                <input type="hidden" name="id" id="id">
                                <input
                                    type="text"
                                    name="edit_teacher_name"
                                    id="edit_teacher_name"
                                    class="form-control"
                                />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Grade</label>
                                <select
                                    class="form-select form-select-lg"
                                    name="edit_grade_name"
                                    id="edit_grade_name"
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
                                    name="edit_subject_name"
                                    id="edit_subject_name"
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
                                    name="edit_image"
                                    id="edit_image"
                                    class="form-control"
                                />
                                <div id="image">

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Status</label>
                                <select
                                    class="form-select form-select-lg"
                                    name="edit_status"
                                    id="edit_status"
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
                        <button type="submit" id="btnupdate" class="btn btn-primary">Update</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        {{-- Edit Modal End --}}

        {{-- Delete Modal Start  --}}
        <div
    class="modal fade"
    id="deleteModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modalTitleId"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="deleteTeacher">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="modalTitleId">
                    Delete Teacher
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
                    <h4>Are you sure you want to delete ?</h4>
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
                <button type="submit" id="btndelete" class="btn btn-danger">Confirm Delete</button>
            </div>
        </form>
        </div>
    </div>
</div>


        {{-- Delete Modal End --}}
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
                            if(data.success==true){
                                Swal.fire({
                                    icon:"success",
                                    title:"Teacher added successfully",
                                    showConfirmButton:false,
                                    timer:1500,
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            }else{
                                Swal.fire({
                                    icon:"error",
                                    title:data.message,
                                    showConfirmButton:false,
                                    timer:1500,
                                });
                                $("#btnsave").prop("disabled",false);
                                $("#btnsave").text("Save");
                            }
                        }

                    })
                });

                // Edit Teacher Modal Start
                $(document).on("click",".editteacher",function(){
                    let id=$(this).attr("data-id");
                    console.log(id);
                    $.ajax({
                        method:"get",
                        url:"{{ url('/setup/teacher/edit') }}/"+id,
                        success:function(data){
                            console.log(data);
                            $("#edit_teacher_name").val(data.teacher.teacher_name);
                            $("#edit_grade_name").val(data.teacher.grade_id);
                            $("#edit_subject_name").val(data.teacher.subject_id);
                            $("#image").html(`<img src="{{ asset('storage/images/')}}/${data.teacher.image}" alt="images" width="100" height="100">`);
                            $("#edit_status").val(data.teacher.status);
                            $("#id").val(data.teacher.id);
                        }
                    });
                });
                // Edit Teacher Modal End

                // Update Teacher Start
                $("#updateTeacher").submit(function(event){
                    event.preventDefault();
                    $("#btnupdate").prop("disabled",true);
                    $("#btnupdate").text("Updating...");
                    let formdata=new FormData(this);
                    $.ajax({
                        method:"POST",
                        url:"{{ url('/setup/teacher/edit') }}",
                        data:formdata,
                        contentType:false,
                        processData:false,
                        success:function(data){
                            console.log(data);
                            if(data.success==true){
                                Swal.fire({
                                    icon:"success",
                                    title:"teacher update successfully",
                                    showConfirmButton:false,
                                    timer:1500,
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            }
                            if(data.success==false){
                                Swal.fire({
                                    icon:"error",
                                    title:data.message,
                                    showConfirmButton:false,
                                    timer:1500,
                                });
                                $("#btnupdate").text("Upadte");
                                $("#btnupdate").prop("disabled",false);
                            }
                        }
                    });
                });
                // Update Teacher End

                // Delete Teacher Start
                $(document).on("click",".deleteteacher",function(){
                    let id=$(this).attr("data-id");
                    console.log(id);
                    $("#deleteTeacher").submit(function(event){
                        event.preventDefault();
                        $("#btndelete").text("Deleting...");
                        $("#btndelete").prop("disabled",true);
                        $.ajax({
                            method:"get",
                            url:"{{ url('/setup/teacher/delete/') }}/"+id,
                            success:function(data){
                                console.log(data);
                                if(data.success==true){
                                    Swal.fire({
                                        icon:"success",
                                        title:"Teacher delete successfully",
                                        showConfirmButton:false,
                                        timer:1500,
                                    });
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1500);
                                }

                                if(data.success==false){
                                    Swal.fire({
                                        icon:"error",
                                        title:data.message,
                                        showConfirmButton:false,
                                        timer:1500,
                                    });
                                    $("#btndelete").text("Confirm Delete");
                                    $("#btndelete").prop("disabled",false);
                                }
                            }
                        });
                    });
                });
                // Delete Teacher End
            });
        </script>
        {{-- Add Teacher Modal End --}}
    </div>
@endsection


<!-- Button trigger modal -->
<!-- Modal -->

