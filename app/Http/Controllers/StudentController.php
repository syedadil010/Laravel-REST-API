<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;



class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students=Student::all();
        return $students;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */


    public function store(Request $request)
    {
        $this->validate($request,[
            'student_number' => 'required|unique:students,student_number|alpha_num',
            'first_name' => 'required',
            'last_name' => 'required',
            'classroom_id' => 'required|exists:classrooms,id'
        ]);

        $student= new Student();
        $student->student_number=$request->student_number;
        $student->first_name=$request->first_name;
        $student->last_name=$request->last_name;
        $student->classroom_id=$request->classroom_id;
        $student->save();
        return response($student, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student=Student::find($id);
        return $student;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */


    public function update(Request $request, $id)
    {
        if (Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            if ($request->student_number == $student->student_number){
                $student->first_name = is_null($request->first_name) ? $student->first_name : $request->first_name;
            $student->last_name = is_null($request->last_name) ? $student->last_name : $request->last_name;
            $student->classroom_id = is_null($request->classroom_id) ? $student->classroom_id : $request->classroom_id;
            $student->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
        }else{
                return response()->json([
                    "message" => "Student_number cannot be updated"
                ], 404);
            }
        } else {
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student=Student::find($id);
        $student->delete();
    }
}
