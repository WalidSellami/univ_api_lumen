<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use Exception;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function create(Request $request){

        $this->validate($request, [
            'project_name' => 'required|string|between:2,50',
            'year' => 'required|integer',
            'first_student_name' => 'required|string|between:2,50',
            'supervisor_name' => 'required|string|between:2,50',
            'supervisor_mark' => 'required',
            'president_name' => 'required|string|between:2,50',
            'president_mark' => 'required',
            'examiner_name' => 'required|string|between:2,50',
            'examiner_mark' => 'required',
            'user_id' => 'required|integer',

        ]);

        try{

            $detail = new Detail;
            $detail->project_name = $request->input('project_name');
            $detail->year = $request->input('year');
            $detail->first_student_name = $request->input('first_student_name');
            $detail->second_student_name = $request->input('second_student_name');
            $detail->third_student_name = $request->input('third_student_name');
            $detail->supervisor_name = $request->input('supervisor_name');
            $detail->supervisor_mark = $request->input('supervisor_mark');
            $detail->president_name = $request->input('president_name');
            $detail->president_mark = $request->input('president_mark');
            $detail->examiner_name = $request->input('examiner_name');
            $detail->examiner_mark = $request->input('examiner_mark');
            $detail->user_id = $request->input('user_id');

            $supervisor_mark = $detail->supervisor_mark;
            $president_mark = $detail->president_mark;
            $examiner_mark = $detail->examiner_mark;

            $final_mark = (0.3 * $supervisor_mark) + (0.3 * $president_mark) + ( 0.3 * $examiner_mark) ;

            $detail->final_mark = $final_mark;

            if($detail->save()){

                $output = [
                    'status' => true,
                    'message' => 'Project created successfully',
                    'detail' => $detail,
                ];

            }else{

                $output = [
                    'status' => false,
                    'message' => 'Failed to create project',
                    'detail' => null,
                ];

            }
        }catch(Exception $e){

            $output = [
                'status' => false,
                'message' => $e->getMessage(),
                'detail' => null,
            ];

        }

       return response()->json($output);

    }


    public function getProject($user_id){

        $detail = Detail::where('user_id', $user_id)->get();

        $output = [
         'detail' => $detail,
        ];

        return response()->json($output);

    }


    public function allProjects(){

        $detail = Detail::all();

        $output = [
         'detail' => $detail,
        ];

        return response()->json($output);

     }




     public function deleteProject($detail_id){

        $detail = Detail::where('detail_id', $detail_id);

        if($detail->delete()){

            $output = [
                'status' => true,
                'message' => 'Project deleted successfully',
                'detail' => null,
            ];
        }else{

            $output = [
                'status' => false,
                'message' => 'Failed to delete project',
                'detail' => null,
            ];
        }

        return response()->json($output);

     }
}
