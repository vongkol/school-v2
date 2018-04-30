<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class DocumentController extends Controller
{
    // save document
    public function save(Request $r)
    {
        $data = [
            'description' => $r->description,
            'student_id' => $r->student_id
        ];
        $i = DB::table('documents')->insertGetId($data);
        if($i>0)
        {
            // upload doc to documents folder
            if($r->hasFile('doc_file_name'))
            {
                $file = $r->file('doc_file_name');
                $file_name = $i . "-" .$file->getClientOriginalName();
                $destinationPath = 'documents/';
                $file->move($destinationPath, $file_name);
                DB::table('documents')->where('id', $i)->update(['file_name' => $file_name]);
            }
           
       }
        $doc = DB::table('documents')
            ->where('id', $i)->first();
        return json_encode($doc);
    }
    public function delete($id)
    {
        $data = ["active"=>0];
        $i = DB::table('documents')
            ->where('id', $id)
            ->update($data);
        return $i;
    }
}
