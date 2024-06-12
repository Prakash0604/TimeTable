<?php

namespace App\Http\Controllers;

use App\Models\grade;
use App\Models\subject;
use App\Models\teacher;
use App\Models\timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Setupcontroller extends Controller
{
    public function grade(){
        $grades=grade::all();
        return view('Content.Grade',compact('grades'));
    }
    public function storegrade(Request $request){
        try{
            $request->validate([
                'grade_name'=>'required|string|unique:grades',
            ]);
            grade::create([
                'grade_name'=>$request->grade_name,
                'description'=>$request->description,
                'status'=>$request->status,
            ]);
            return response()->json(['success'=>true]);
        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function editGrade($id){
        try{
            $grade=grade::find($id);
            return response()->json(['success'=>true,'message'=>$grade]);

        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }
    public function updateGrade(Request $request){
        try{
           $request->validate([
                'edit_grade_name'=>'required|string',
            ]);
            $id=$request->id;
            grade::find($id)->update([
                'grade_name'=>$request->edit_grade_name,
                'description'=>$request->edit_description,
                'status'=>$request->edit_status,
            ]);
            return response()->json(['success'=>true]);
        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function deleteGrade($id){
        $grade=grade::find($id);
        if($grade!=null){
            $grade->delete();
            return response()->json(['success'=>true,$grade]);
        }else{
            return response()->json(['success'=>false,'message'=>'Grade not found']);
        }
    }



    // Subject Controller Start

    public function subject(){
        $subjects=subject::all();
        return view('Content.Subject',compact('subjects'));
    }
    public function storeSubject(Request $request){
        try{
            $request->validate([
                'subject_name'=>'required|string|unique:subjects',
            ]);
            subject::create([
                'subject_name'=>$request->subject_name,
                'description'=>$request->description,
                'status'=>$request->status,
            ]);
            $response_code=200;
            return response()->json(['success'=>true,$response_code]);
        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function editSubject($id){
        try{
            $subjects=subject::find($id);
            return response()->json(['success'=>true,'message'=>$subjects]);

        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }
    public function updateSubject(Request $request){
        try{
           $request->validate([
                'edit_subject_name'=>'required|string',
            ]);
            $id=$request->id;
            subject::find($id)->update([
                'subject_name'=>$request->edit_subject_name,
                'description'=>$request->edit_description,
                'status'=>$request->edit_status,
            ]);
            return response()->json(['success'=>true]);
        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function deleteSubject($id){
        $subjects=subject::find($id);
        if($subjects!=null){
            $subjects->delete();
            return response()->json(['success'=>true,$subjects]);
        }else{
            return response()->json(['success'=>false,'message'=>'Grade not found']);
        }
    }

    // Subject Controller End



    // Teacher Controller Start
    public function teacher(Request $request){
        // $data=$request->only('select_grade','select_subject');
        $grade=$request->input('grade_select');
        $subject=$request->input('subject_select');

        // Fetch Active List Only
        $grades=grade::where('status',1)->get();
        $subjects=subject::where('status',1)->get();
        $query=teacher::with('subject','grade');
        if(!empty($grade)){
            $query->where("grade_id","like", "%" .$grade."%");
        }
        if(!empty($subject)){
            $query->where('subject_id','like','%'.$subject.'%');
        }

       $teachers=$query->paginate(3);

        return view('Content.teacher',compact('grades','subjects','teachers'));
    }

    public function storeTeacher(Request $request){
        try{
            $request->validate([
                'teacher_name'=>'required|string|min:3',
                'grade_name'=>'required',
                'subject_name'=>'required',
                'image'=>'mimes:jpg,png,jpeg',
            ]);
            $imagename=null;
            $image=$request->file('image');
            if($image!=null){
                $imagename=time().'.'.$image->getClientOriginalName();
                $image->storeAs('public/images/'.$imagename);
            }
            teacher::create([
                'teacher_name'=>$request->teacher_name,
                'grade_id'=>$request->grade_name,
                'subject_id'=>$request->subject_name,
                'image'=>$imagename,
                'status'=>$request->status,
            ]);
            return response()->json(['success'=>true]);
        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function editTeacher($id){
        try{
            $teacher=teacher::with('subject','grade')->find($id);
            return response()->json(['success'=>true,'teacher'=>$teacher]);
        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function updateTeacher(Request $request){
        try{
            $id=$request->id;
            $teacher=teacher::find($id);
            $imageName=$teacher->image;
            // if($request->file('edit_image')){
            //     if($teacher->file_exists(public_path('storage/images/'.$teacher->image) && $teacher->image)){
            //         unlink(public_path('storage/images/'.$teacher->image));
            //     }
            //     $imagename=$request->file('edit_image');
            //     $teacherimages=time().'.'.$imagename->getClientOriginalName();
            //     $imagename->storeAs('public/images/'.$teacherimages);
            // }
            if ($request->hasFile('edit_image')) {
                // Check if the old image exists and delete it
                if ($teacher->image && file_exists(public_path('storage/images/' . $teacher->image))) {
                    unlink(public_path('storage/images/' . $teacher->image));
                }

                // Store the new image
                $image = $request->file('edit_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/images', $imageName);

            }
            $teacher->update([
                'teacher_name'=>$request->edit_teacher_name,
                'subject_id'=>$request->edit_subject_name,
                'grade_id'=>$request->edit_grade_name,
                'image'=>$imageName,
                'status'=>$request->edit_status,
            ]);
            return response()->json(['success'=>true,$teacher]);
        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }

    }

    public  function deleteTeacher($id){
        try{
            $teacher=teacher::find($id);
            $teacher->delete();
            return response()->json(['success'=>true,$teacher]);

        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }


    }
    // Teacher Controller Ending

    public function viewDetail($id){
        $gradesteacher=grade::with(['teacher.subject'])->where('id',$id)->first();
        // return response()->json(['success'=>true,'gradesteacher'=>$gradesteacher]);
        return view('Content.gradeteacherlist',compact('gradesteacher'));
    }

    public function generateTimetable(){
        // For all teachers list in form
        $teachers=teacher::all();

        // For table data
        $sunday=timetable::with(['teacher.subject'])->where('day_of_week','Sunday')->get();
        $Monday=timetable::with('teacher.subject')->where('day_of_week','Monday')->get();
        $Tuesday=timetable::with('teacher.subject')->where('day_of_week','Tuesday')->get();
        $Wednesday=timetable::with('teacher.subject')->where('day_of_week','Wednesday')->get();
        $Thursday=timetable::with('teacher.subject')->where('day_of_week','Thursday')->get();
        $Friday=timetable::with('teacher.subject')->where('day_of_week','Friday')->get();
        $Saturday=timetable::with('teacher.subject')->where('day_of_week','Saturday')->get();
        $timetables=timetable::paginate(5);
        $data=compact('sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','teachers','timetables');
        return view('Content.TimetableIndex',$data);
        // return view('Content.TimetableIndex',compact('teachers','timetables'));
    }

    public function createTimetable(Request $request){
        try{

          $formdata=  $request->validate([
                'teacher_name'=>'required',
                'starting_date'=>'required|date',
                'ending_date'=>'required|date',
                'starting_time'=>'required',
                'ending_time'=>'required',
                'day_of_week'=>'required',
            ]);
            timetable::create([
                'teacher_id'=>$request->teacher_name,
                'starting_date'=>$request->starting_date,
                'ending_date'=>$request->ending_date,
                'starting_time'=>$request->starting_time,
                'ending_time'=>$request->ending_time,
                'day_of_week'=>$request->day_of_week,
            ]);
            return response()->json(['success'=>true,'message'=>'Data saved',$formdata,200]);
        }
        catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()],500);
        }
    }

}
