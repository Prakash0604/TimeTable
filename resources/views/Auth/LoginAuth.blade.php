@extends('index')
@section('content')
<div class="container mt-3 col-4">
    <h4 class="text-center mt-3">Login</h4>
    <div class="card p-3">
    <form id="loginUser">
        @csrf
        <div class="mb-3">
            <label for="" class="form-label">Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
            />
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
            />
        </div>
        <button type="submit" id="btnlogin" class="btn btn-primary btn-lg">Login</button>
    </form>
</div>
</div>
<script>
    $(document).ready(function(){
        $("#loginUser").submit(function(event){
            event.preventDefault();
            $("#btnlogin").text("Loading...");
            $("#btnlogin").prop("disabled",true);
            var formdata=new FormData(this);
            $.ajax({
                method:"POST",
                url:"{{ url('/login') }}",
                data:formdata,
                contentType:false,
                processData:false,
                success:function(data){
                    console.log(data);
                    if(data.success==true){
                        Swal.fire({
                            icon:"success",
                            title:"redirect to dashboard",
                            showConfirmButton:false,
                            timer:1500
                        });
                        setTimeout(() => {
                            window.location="{{ url('/dashboard') }}";
                        }, 1500);
                    }
                    if(data.success==false){
                        Swal.fire({
                            icon:"error",
                            title:data.message,
                            showConfirmButton:false,
                            timer:1500,
                        });
                        $("#btnlogin").text("Login");
                        $("#btnlogin").prop("disabled",false);
                    }
                }
            })
        });

    })
</script>
@endsection
