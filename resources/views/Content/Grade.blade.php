@extends('index')
@section('content')
    <div class="container">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-lg mt-4 mb-4" data-bs-toggle="modal" data-bs-target="#modalId">
            Add Grade
        </button>

        <!-- Modal -->
        <div class="text-center mb-3">
            <h1>Grade List</h1>
        </div>
        <div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="addClass">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">
                                Create classroom
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                @csrf
                                <div class="mb-3">
                                    <label for="" class="form-label">Grade</label>
                                    <input type="text" name="grade_name" class="form-control"
                                        placeholder="Enter classroom" />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Status</label>
                                    <select class="form-select form-select-lg" name="status" id="">
                                        <option selected value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" id="btncreate" class="btn btn-primary">create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th scope="col">S.N</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $n = 1;
                        @endphp
                        @foreach ($grades as $grade)
                            <tr class="">
                                <td>{{ $n }}</td>
                                <td><a href="{{ url('/setup/grade/view/'.$grade->id) }}" style="text-decoration: none">{{ $grade->grade_name }}</a></td>
                                <td>{!! Str::limit($grade->description, 50, '....') !!}</td>
                                <td>
                                    <span
                                        class="badge badge-pill rounded-pill bg-{{ $grade->status ? 'success' : 'danger' }}">{{ $grade->status ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td>
                                    <a class="btn btn-primary editgrade" data-id="{{ $grade->id }}" data-bs-toggle="modal" data-bs-target="#editModal">Edit</a>
                                    <a class="btn btn-danger deletegrade" data-id="{{ $grade->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal"> Delete</a>
                                </td>
                            </tr>
                            @php
                                $n = $n + 1;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- Edit Grade Start Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editClass">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Edit classroom
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="id" id="id">
                                <label for="" class="form-label">Grade</label>
                                <input type="text" name="edit_grade_name" id="edit_grade_name" class="form-control"
                                    placeholder="Enter classroom" />
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Description</label>
                                <textarea class="form-control" name="edit_description" id="edit_description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Status</label>
                                <select class="form-select form-select-lg" name="edit_status" id="edit_status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" id="btnupdate" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Delete Modal Start --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="deleteClass">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Delete classroom
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <h5>Are you sure your want to delete ?</h5>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" id="btndelete" class="btn btn-danger">Confirm Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Modal End --}}

    {{-- Edit Grade End Modal --}}
    <script>
        $(document).ready(function() {
            $("#addClass").submit(function(event) {
                event.preventDefault();
                $("#btncreate").text("Loading...");
                $("#btncreate").prop("disabled", true);
                let formdata = new FormData(this);
                $.ajax({
                    method: "POST",
                    url: "{{ url('/setup/grade') }}",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        console.log(data);
                        if (data.success == true) {
                            Swal.fire({
                                icon: "success",
                                title: "Successfully Added",
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            setTimeout(() => {
                                location.reload();
                                $("input[type='text']").val("");
                                $("textarea").val("");
                            }, 1500);
                        } else {
                            Swal.fire({
                                icon: "info",
                                title: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $("#btncreate").prop("disabled", false);
                            $("#btncreate").text("create");
                        }
                    }
                });
            });

            // Edit Grade start
            $(document).on("click", ".editgrade", function() {
                const id = $(this).attr("data-id");
                // console.log(id);
                $.ajax({
                    method:"get",
                    url:"{{ url('/setup/grade/edit') }}/"+id,
                    success:function(data){
                        // console.log(data);
                        if(data.success==true){
                            $("#edit_grade_name").val(data.message.grade_name);
                            $("#edit_description").val(data.message.description);
                            $("#edit_status").val(data.message.status);
                            $("#id").val(data.message.id);
                        }
                    }
                });
            });
            // Edit Grade End

            // update Grade Start
            $("#editClass").submit(function(event){
                event.preventDefault();
                const formdata=new FormData(this);
                $("#btnupdate").text("Updating...");
                $("#btnupdate").prop("disabled",true);
                $.ajax({
                    method:"POST",
                    url:"{{ url('/setup/grade/edit') }}",
                    data:formdata,
                    processData:false,
                    contentType:false,
                    success:function(data){
                        console.log(data);
                        if(data.success==true){
                            Swal.fire({
                                icon:"success",
                                title:"Grade updated successfully",
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
                            $("#btnupdate").prop("disabled",false);
                            $("#btnupdate").text("Update");
                        }
                    }
                })
            })
            // update Grade End

            // Delete Grade Start
            $(document).on("click",".deletegrade",function(){
                let id=$(this).attr("data-id");
                $("#deleteClass").submit(function(event){
                    event.preventDefault();
                    $("#btndelete").text("Deleting...");
                    $("#btndelete").prop("disabled",true);
                    $.ajax({
                        method:"get",
                        url:"{{ url('/setup/grade/delete') }}/"+id,
                        success:function(data){
                            console.log(data);
                            if(data.success==true){
                                Swal.fire({
                                    icon:"success",
                                    title:"Grade deleted successfully",
                                    showConfirmButton:false,
                                    timer:1500,
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            }else{
                                Swal.fire({
                                    icon:"info",
                                    title:data.message,
                                    showConfirmButton:false,
                                    timer:1500,
                                });
                            }
                        }
                    })
                })
            })
            // Delete Grade End

        });
    </script>
@endsection
