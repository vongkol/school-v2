<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // function to delete
    public function delete($id)
    {
        $i = DB::table('registrations')
            ->where('id', $id)
            ->update(["active"=>0]);
        return $i;
    }
    // save registration
    public function save(Request $r)
    {
        $check_student = DB::table('registrations')
            ->where('student_id', $r->student_id)
            ->count();
        $check_shift = DB::table('registrations')
            ->where('shift_id', $r->shift_id)
            ->count();
        $check_class = DB::table('registrations')
            ->where('class_id', $r->class_id)
            ->count();
        if($check_student>0) {
            if($check_shift > 0)  {
                DB::table('registrations')->where('student_id', $r->student_id)->where('shift_id', $r->shift_id)->update(["enroll"=>0]);
            }
            if($check_class > 0 ) {
                DB::table('registrations')->where('student_id', $r->student_id)->where('class_id', $r->class_id)->update(["enroll"=>0]);
            }
        }


        $data = [
            "registration_date" => $r->registration_date,
            'start_date' => $r->start_date,
            'end_date' => $r->end_date,
            'student_id' => $r->student_id,
            'class_id' => $r->class_id,
            'shift_id' => $r->shift_id,
            'year_id' => $r->year_id
        ];
        if($r->id>0)
        {
            //update
            DB::table('registrations')
                ->where('id', $r->id)
                ->update($data);
            return $r->id;
        }
        else{
            // insert
            $i = DB::table('registrations')
                    ->insertGetId($data);
            return $i;
        }
    }
}
