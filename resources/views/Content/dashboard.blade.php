@extends('index')
@section('content')
<div class="container">
<div class="row">
<div class="card text-center mt-4 mr-3" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">Total Teacher Count</h5>
      <p class="card-text"><span class="badge badge-pill bg-success">{{ $teacher }}</span></p>
      <a href="{{ route('teacher') }}" class="btn btn-primary">View Teacher</a>
    </div>
  </div>
  <br>
<div class="card text-center mt-4 ml-4" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">Total Grade Count</h5>
      <p class="card-text"><span class="badge badge-pill bg-success">{{ $grade }}</span></p>
      <a href="{{ route('grade') }}" class="btn btn-primary">View Grade</a>
    </div>
  </div><br>
<div class="card text-center mt-4" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">Total Subject Count</h5>
      <p class="card-text"><span class="badge badge-pill bg-success">{{ $subject }}</span></p>
      <a href="{{ route('subject') }}" class="btn btn-primary">View Subject</a>
    </div>
  </div>
  <br>
<div class="card text-center mt-4" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">Special title treatment</h5>
      <p class="card-text"><span class="badge badge-pill bg-success">5</span></p>
      <a href="#" class="btn btn-primary">Click Here</a>
    </div>
  </div>
  <br>
<div class="card text-center mt-4" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">Change Password</h5>
      <a class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#modalId">Change</a>
    </div>
  </div>
  <br>
<div class="card text-center mt-4" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">Delete Account</h5>
      <a href="#" class="btn btn-danger">Delete</a>
    </div>
  </div>
  <br>
</div>

</div>


{{-- Change Password Modal start --}}

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
            <form id="updatePassword">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="modalTitleId">
                    Change Password
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
                        <label for="" class="form-label">Current Password</label>
                        <input
                            type="password"
                            class="form-control"
                            name="oldpassword"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">New Password</label>
                        <input
                            type="password"
                            class="form-control"
                            name="newpassword"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Confirm Password</label>
                        <input
                            type="password"
                            class="form-control"
                            name="confirmpassword"
                        />
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
                <button type="submit" id="btnchange" class="btn btn-primary">Update Password</button>
            </div>
        </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#updatePassword").submit(function(event){
            event.preventDefault();
            $("#btnchange").text("changing...");
            $("#btnchange").prop("disabled",true);
            let formdata=new FormData(this);
            $.ajax({
                method:"POST",
                url:"{{ url('setup/password/change') }}",
                data:formdata,
                processData:false,
                contentType:false,
                success:function(data){
                    console.log(data);
                }
            });
        });
    })
</script>

{{-- Change Password Modal End --}}
@endsection
