@extends('index')
@section('content')
    <div class="container col-3 p-3">
        <div class="card-body border border-primary  p-2 rounded">
            <form id="btnform" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Name</label>
                    <input type="text" name="name" id=""
                        class="form-control  @error('name')  is-invalid @enderror" />
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email')  is-invalid @enderror" />
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control  @error('password')  is-invalid @enderror" />
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Confirm Password</label>
                    <input type="password" name="cpassword"
                        class="form-control  @error('cpassword')  is-invalid @enderror" />
                    @error('cpassword')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Profile</label>
                    <input type="file" name="profile" class="form-control   @error('profile')  is-invalid @enderror" />
                    @error('profile')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button  type="submit" class="btn btn-primary" id="btnregister">Register</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $("#btnform").submit(function(e){
                e.preventDefault();
                $("#btnregister").text("Loading...");
                $("#btnregister").prop("disabled",true);
                var formdata=new FormData(this);
                $.ajax({
                    method:"POST",
                    url:"{{ url('/register') }}",
                    contentType:false,
                    processData:false,
                    data:formdata,
                    success:function(data){
                        console.log(data);
                        if(data.success==true){
                            Swal.fire({
                                icon:"success",
                                title:"Register has been successfully",
                                showConfirmButton:false,
                                timer:1500
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                            $("input[type='text']").val("");
                            $("input[type='email']").val("");
                        }
                        if(data.success==false){
                            Swal.fire({
                                icon:"error",
                                title:data.msg,
                                showConfirmButton:false,
                                timer:1500
                            });
                            $("#btnregister").text("Register");
                            $("#btnregister").prop("disabled",false);
                        }
                    }

                })
            });
        })
    </script>
@endsection
