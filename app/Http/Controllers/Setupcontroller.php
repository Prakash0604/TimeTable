<?php

namespace App\Http\Controllers;

use App\Models\grade;
use App\Models\subject;
use App\Models\teacher;
use Illuminate\Http\Request;

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
            return response()->json(['success'=>true]);
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
    public function teacher(){
        $grades=grade::where('status',1)->get();
        $subjects=subject::where('status',1)->get();
        $teachers=teacher::with('subject','grade')->get();
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

    // Teacher Controller End
}
