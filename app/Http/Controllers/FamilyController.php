<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class FamilyController extends Controller
{
    // save and update family records
    public function save(Request $r)
    {
        if($r->family_id>0)
        {
            // update data
            $data = [
                "full_name" => $r->full_name,
                "gender" => $r->gender,
                "dob" => $r->dob,
                "address" => $r->address,
                "phone" => $r->phone,
                "relation_type" => $r->relation_type,
                "career" => $r->career,
                "family_status" => $r->status,
                "is_alived" => $r->isAlive,
                "is_disabled" => $r->isDisabled,
                "is_minority" => $r->isMinority
            ];
            $i = DB::table('families')->where('id', $r->family_id)->update($data);
            return $i;
        }
        else{
            // insert data
            $data = [
                "full_name" => $r->full_name,
                "gender" => $r->gender,
                "dob" => $r->dob,
                "address" => $r->address,
                "phone" => $r->phone,
                "relation_type" => $r->relation_type,
                "student_id" => $r->student_id,
                "career" => $r->career,
                "family_status" => $r->status,
                "is_alived" => $r->isAlive,
                "is_disabled" => $r->isDisabled,
                "is_minority" => $r->isMinority

            ];
            $i = DB::table('families')->insertGetId($data);
            return $i;
        }

    }
    // delete a family
    public  function delete($id)
    {
        $data = ["active" => 0];
        $i = DB::table("families")->where('id', $id)->update($data);
        return $i;
    }
}
