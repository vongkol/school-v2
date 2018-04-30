<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class HealthController extends Controller
{
    // get health recored by student id
    public function get($id)
    {
    
    }
    // save health to db
    public function save(Request $r)
    {
        $data = [
            'check_date' => $r->check_date,
            'check_time' => $r->check_time,
            'weight' => $r->weight,
            'height' => $r->height,
            'left_eye' => $r->left_eye,
            'right_eye' => $r->right_eye,
            'left_ear' => $r->left_ear,
            'right_ear' => $r->right_ear,
            'top_tooth' => $r->top_tooth,
            'bottom_tooth' => $r->bottom_tooth,
            'other' => $r->other,
            'conclusion' => $r->conclusion
        ];
        if($r->id>0)
        {
            // update
            DB::table('healths')->where('id', $r->id)->update($data);
            return $r->id;
        }
        else{
            $data['student_id'] = $r->student_id;
            $i = DB::table('healths')->insertGetId($data);
            return $i;
        }
    }
    // delete health by id
    public function delete($id)
    {
        $i = DB::table('healths')
                ->where('id', $id)
                ->update(['active'=>0]);
        return $i;
    }
}
