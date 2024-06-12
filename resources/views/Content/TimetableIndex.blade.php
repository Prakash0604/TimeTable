@extends('index')
@section('content')
    <div class="container no-print">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-lg mt-4" data-bs-toggle="modal" data-bs-target="#modalId">
            Add Timetable
        </button>

        <a id="viewlog" class="btn btn-warning btn-lg mt-4">View Log</a>
        <button class="btn btn-secondary btn-lg mt-4" id="slide">View Timetable</button>
        <button onclick="printDiv('printableArea')" class="btn btn-primary no-print btn-lg mt-4"><i class="bi bi-printer-fill"></i>Print</button>

        <!-- Modal -->
        <div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="updateTimetable">
                        <div class="modal-header bg-gradient bg-primary">
                            <h5 class="modal-title" id="modalTitleId">
                                TimeTable
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <label for="" class="form-label">Teachers</label>
                                        <select class="form-select" name="teacher_name">
                                            <option value=""></option>
                                            @forelse ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->teacher_name }}</option>
                                            @empty
                                                <option value="">Istanbul</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="" class="form-label">Select week</label>
                                    <select class="form-select" name="day_of_week">
                                        <option value=""></option>
                                        <option value="Sunday">Sunday</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                    </select>
                                </div>
                                <div class="row mb-4 mt-4">
                                    <div class="col-6">
                                        <label for="" class="form-label">Starting date</label>
                                        <input type="date" name="starting_date" class="form-control" />
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label">Ending date</label>
                                        <input type="date" name="ending_date" class="form-control" />
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-6">
                                        <label for="" class="form-label">Starting time</label>
                                        <input type="time" name="starting_time" class="form-control" />
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label">Ending time</label>
                                        <input type="time" name="ending_time" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="" class="form-label">Status</label>
                                    <select class="form-select" name="status">
                                        <option value="">Select one</option>
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
                            <button type="submit" id="btnsave" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Time table log --}}
    <div class="container timetablecontent mt-4 mb-4">
        <h1 class="text-center">Time table</h1>
        <div
            class="table-responsive"
        >

            <table
                class="table table-bordered "
            >
                <thead>
                    <tr>
                        <th scope="col">S.n</th>
                        <th scope="col">Teacher Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                        <th scope="col">Weekend</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $n=1;
                    @endphp
                    @forelse ($timetables as $timetable)
                    <tr class="">
                        <td scope="row">{{ $n }}</td>
                        <td>{{ $timetable->teacher->teacher_name }}</td>
                        <td>
                            <p> {{ $timetable->starting_date }} </p>
                            <p> {{ $timetable->ending_date }} </p>
                        </td>
                        <td>
                            <p> {{ $timetable->starting_time }}</p>
                            <p> {{ $timetable->ending_time }}</p>
                        </td>
                        <td>{{ $timetable->day_of_week }}</td>
                        <td>
                            <span class="badge badge-pill rounded-pill bg-{{ $timetable->status ? "success":"danger" }}">{{ $timetable->status ? "Active":"Inactive" }}</span>
                        </td>
                        <td>
                            <a href="" class="btn btn-primary">Edit</a>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @php
                        $n=$n+1;
                    @endphp
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No data found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="container">
            {{ $timetables->links("pagination::bootstrap-5") }}
        </div>

    </div>

    {{-- Time table Graph --}}
    <div class="container slideuptoggle" id="printableArea">
        <div class="w-95 w-md-75 w-lg-60 w-xl-55 mx-auto mb-6 text-center">
            <div class="subtitle alt-font"><span class="text-primary">#04</span><span class="title">Timetable</span></div>
            <h2 class="display-18 display-md-16 display-lg-14 mb-0">Committed to fabulous and great <span
                    class="text-primary">#Timetable</span></h2>
        </div>
        <div
            class="table-responsive"
        >
            <table
                class="table table-striped table-hover table-borderless table-primary align-middle table-bordered"
            >
                <thead class="table-light">
                    <tr>
                        <th>Days</th>
                        <th colspan="12">Periods</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr>

                        <td scope="row">Sunday</td>
                        @foreach ($sunday as $sun)
                        <td>
                            <div class="card text-start text-center">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $sun->teacher->subject->subject_name}}</h6>
                                    <span class="card-text"> {{ $sun->teacher->teacher_name }}</span><br>
                                    <span class="card-text">{{ $sun->starting_date }}-{{ $sun->ending_date }}</span>
                                    <span class="card-text">({{ $sun->starting_time }}AM-{{ $sun->ending_time }}PM)</span>
                                </div>
                            </div>
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td scope="row">Monday</td>
                        @foreach ($Monday as $mon)
                        <td>
                            <div class="card text-start text-center" style="background-image: url('asset('default.jpg')'); background-size: cover; background-position: center;">
                                <div class="card-body ">
                                    <h6 class="card-title">{{ $mon->teacher->subject->subject_name}}</h6>
                                    <span class="card-text"> {{ $mon->teacher->teacher_name }}</span><br>
                                    <span class="card-text">{{ $mon->starting_date }}-{{ $mon->ending_date }}</span>
                                    <span class="card-text">({{ $mon->starting_time }}AM-{{ $mon->ending_time }}PM)</span>
                                </div>
                            </div>
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td scope="row">Tuesday</td>
                        @foreach ($Tuesday as $tue)
                        <td>
                            <div class="card text-start text-center">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $tue->teacher->subject->subject_name}}</h6>
                                    <span class="card-text"> {{ $tue->teacher->teacher_name }}</span><br>
                                    <span class="card-text">{{ $tue->starting_date }}-{{ $tue->ending_date }}</span>
                                    <span class="card-text">({{ $tue->starting_time }}AM-{{ $tue->ending_time }}PM)</span>
                                </div>
                            </div>
                        </td>
                        @endforeach
                    </tr> <tr>
                        <td scope="row">Wednesday</td>
                        @foreach ($Wednesday as $wed)
                        <td>
                            <div class="card text-start text-center">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $wed->teacher->subject->subject_name}}</h6>
                                    <span class="card-text"> {{ $wed->teacher->teacher_name }}</span><br>
                                    <span class="card-text">{{ $wed->starting_date }}-{{ $wed->ending_date }}</span>
                                    <span class="card-text">({{ $wed->starting_time }}AM-{{ $wed->ending_time }}PM)</span>
                                </div>
                            </div>
                        </td>
                        @endforeach
                    </tr> <tr>
                        <td scope="row">Thursday</td>
                        @foreach ($Thursday as $thu)
                        <td>
                            <div class="card text-start text-center">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $thu->teacher->subject->subject_name}}</h6>
                                    <span class="card-text"> {{ $thu->teacher->teacher_name }}</span><br>
                                    <span class="card-text">{{ $thu->starting_date }}-{{ $thu->ending_date }}</span>
                                    <span class="card-text">({{ $thu->starting_time }}AM-{{ $thu->ending_time }}PM)</span>
                                </div>
                            </div>
                        </td>
                        @endforeach
                    </tr> <tr>
                        <td scope="row">Friday</td>
                        @foreach ($Friday as $fri)
                        <td>
                            <div class="card text-start text-center">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $fri->teacher->subject->subject_name}}</h6>
                                    <span class="card-text"> {{ $fri->teacher->teacher_name }}</span><br>
                                    <span class="card-text">{{ $fri->starting_date }}-{{ $fri->ending_date }}</span>
                                    <span class="card-text">({{ $fri->starting_time }}AM-{{ $fri->ending_time }}PM)</span>
                                </div>
                            </div>
                        </td>
                        @endforeach
                    </tr> <tr>
                        <td scope="row">Saturday</td>
                        @foreach ($Saturday as $sat)
                        <td>
                            <div class="card text-start text-center">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $sat->teacher->subject->subject_name}}</h6>
                                    <span class="card-text"> {{ $sat->teacher->teacher_name }}</span><br>
                                    <span class="card-text">{{ $sat->starting_date }}-{{ $sat->ending_date }}</span>
                                    <span class="card-text">({{ $sat->starting_time }}AM-{{ $sat->ending_time }}PM)</span>
                                </div>
                            </div>
                        </td>
                        @endforeach
                    </tr>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>

    </div>


    <script>
        // Prinr option
        function printDiv(divId) {
    window.print();
}
        $(document).ready(function() {
            // $(".timetablecontent").hide();

            // $("#slide").on("click", function() {
            //     $(".slideuptoggle").toggle(2000);
            // });

            // $("#viewlog").on("click",function(){
            //     $(".timetablecontent").toggle(1500);
            // });

            $("#updateTimetable").submit(function(event){
                event.preventDefault();
                $("#btnsave").text("Saving...");
                $("#btnsave").prop("disabled",true);
                let formdata=new FormData(this);
                $.ajax({
                    method:"POST",
                    url:"{{ url('setup/timetable/create') }}",
                    data:formdata,
                    contentType:false,
                    processData:false,
                    success:function(data){
                        console.log(data);
                        if(data.success==true){
                            Swal.fire({
                                icon:"success",
                                title:"Successfully Added",
                                showConfirmButton:false,
                                timer:1500,
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                            $("input[type='select']").val("");
                            $("input[type='date']").val("");
                            $("input[type='time']").val("");
                        }else{
                            Swal.fire({
                                icon:"error",
                                title:data.message,
                                showConfirmButton:false,
                                timer:1500,
                            });
                            $("#btnsave").text("Save");
                            $("#btnsave").prop("disabled",false);
                        }
                    }
                });
            });
        })
    </script>
@endsection
