@extends('index')
@section('content')
    <div class="container">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-lg mt-4 mb-4" data-bs-toggle="modal" data-bs-target="#modalId">
            Add subject
        </button>

        <div class="text-center mb-3">
            <h1>Subjects List</h1>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="addSubject">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId">
                                Create Subject
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                @csrf
                                <div class="mb-3">
                                    <label for="" class="form-label">subject</label>
                                    <input type="text" name="subject_name" class="form-control"
                                        placeholder="Enter Subject name" />
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
                            <th scope="col">subject</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $n = 1;
                        @endphp
                        @forelse ($subjects as $subject)
                            <tr class="">
                                <td>{{ $n }}</td>
                                <td>{{ $subject->subject_name }}</td>
                                <td>{!! Str::limit($subject->description, 50, '....') !!}</td>
                                <td>
                                    <span
                                        class="badge badge-pill rounded-pill bg-{{ $subject->status ? 'success' : 'danger' }}">{{ $subject->status ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td>
                                    <a class="btn btn-primary editsubject" data-id="{{ $subject->id }}"
                                        data-bs-toggle="modal" data-bs-target="#editModal">Edit</a>
                                    <a class="btn btn-danger deletesubject" data-id="{{ $subject->id }}"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal"> Delete</a>
                                </td>
                            </tr>
                            @php
                                $n = $n + 1;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No data found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="container">
                    {{ $subjects->links("pagination::bootstrap-5"); }}
                </div>
            </div>

        </div>
    </div>

    {{-- Edit subject Start Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editSubject">
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
                                <label for="" class="form-label">subject</label>
                                <input type="text" name="edit_subject_name" id="edit_subject_name"
                                    class="form-control" placeholder="Enter classroom" />
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
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="deleteSubject">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Delete subject
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

    {{-- Edit subject End Modal --}}
    <script>
        $(document).ready(function() {
            $("#addSubject").submit(function(event) {
                event.preventDefault();
                // $("#btncreate").text("Loading...");
                $("#btncreate").html(`<button class="btn btn-primary" type="button" disabled>
  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
  Loading...
</button>`);
                $("#btncreate").prop("disabled", true);
                let formdata = new FormData(this);
                $.ajax({
                    method: "POST",
                    url: "{{ url('/setup/subject') }}",
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

            // Edit subject start
            $(document).on("click", ".editsubject", function() {
                const id = $(this).attr("data-id");
                // console.log(id);
                $.ajax({
                    method: "get",
                    url: "{{ url('/setup/subject/edit') }}/" + id,
                    success: function(data) {
                        // console.log(data);
                        if (data.success == true) {
                            $("#edit_subject_name").val(data.message.subject_name);
                            $("#edit_description").val(data.message.description);
                            $("#edit_status").val(data.message.status);
                            $("#id").val(data.message.id);
                        }
                    }
                });
            });
            // Edit subject End

            // update subject Start
            $("#editSubject").submit(function(event) {
                event.preventDefault();
                const formdata = new FormData(this);
                $("#btnupdate").text("Updating...");
                $("#btnupdate").prop("disabled", true);
                $.ajax({
                    method: "POST",
                    url: "{{ url('/setup/subject/edit') }}",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        console.log(data);
                        if (data.success == true) {
                            Swal.fire({
                                icon: "success",
                                title: "subject updated successfully",
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                        if (data.success == false) {
                            Swal.fire({
                                icon: "error",
                                title: data.message,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            $("#btnupdate").prop("disabled", false);
                            $("#btnupdate").text("Update");
                        }
                    }
                })
            })
            // update subject End

            // Delete subject Start
            $(document).on("click", ".deletesubject", function() {
                let id = $(this).attr("data-id");
                $("#deleteSubject").submit(function(event) {
                    event.preventDefault();
                    $("#btndelete").text("Deleting...");
                    $("#btndelete").prop("disabled", true);
                    $.ajax({
                        method: "get",
                        url: "{{ url('/setup/subject/delete') }}/" + id,
                        success: function(data) {
                            console.log(data);
                            if (data.success == true) {
                                Swal.fire({
                                    icon: "success",
                                    title: "subject deleted successfully",
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            } else {
                                Swal.fire({
                                    icon: "info",
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                            }
                        }
                    })
                })
            })
            // Delete subject End

        });
    </script>
@endsection
