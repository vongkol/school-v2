<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class LogController extends Controller
{
    // index
    public function index(Request $r)
    {
        $data['logs'] = DB::table('logs')
        ->join('users','logs.user_id', 'users.id')
        ->select('logs.*', 'users.name as user_id')
        ->orderBy('logs.id', 'desc')
        ->where('logs.active', 1)
        ->paginate(18);
        
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.active', 1)
            ->count();
        
        if($r->action !== null || $r->user_id !== null || $r->on_table !== null || $r->start_date !== null || $r->end_date !== null) {
            $data['logs'] = DB::table('logs')
                ->join('users','logs.user_id', 'users.id')
                ->select('logs.*', 'users.name as user_id')
                ->orderBy('logs.id', 'desc')
                ->where('logs.action_type', $_GET['action'])
                ->where('logs.table_action', $_GET['on_table'])
                ->where('logs.user_id', $_GET['user_id'])
                ->where('logs.log_date', '>=', $_GET['start_date'])
                ->where('logs.log_date', '<=', $_GET['end_date'])
                ->where('logs.active', 1)
                ->paginate(18);
            $data['total'] = DB::table('logs')
                ->join('users','logs.user_id', 'users.id')
                ->select('logs.*', 'users.name as user_id')
                ->orderBy('logs.id', 'desc')
                ->where('logs.action_type', $_GET['action'])
                ->where('logs.user_id', $_GET['user_id'])
                ->where('logs.table_action', $_GET['on_table'])
                ->where('logs.log_date', '>=', $_GET['start_date'])
                ->where('logs.log_date', '<=', $_GET['end_date'])
                ->where('logs.active', 1)
                ->count();
        } 
        if ($r->action !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.active', 1)
            ->count();
        } 
        if ($r->user_id !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.active', 1)
            ->count();
        } 
        if ($r->on_table !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.active', 1)
            ->count();
        } if ($r->start_date !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.log_date', 'asc')
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->count();
        } if ($r->end_date !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.log_date', 'desc')
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.active', 1)
            ->count();
        } 
        
        if ($r->end_date !== null && $r->start_date ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.log_date', 'desc')
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.active', 1)
            ->count();
        } if ($r->end_date !== null && $r->user_id !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.active', 1)
            ->count();
        } if ($r->end_date !== null && $r->action !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.active', 1)
            ->count();
        } 
        if ($r->end_date !== null && $r->on_table !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.active', 1)
            ->count();
        } if ($r->start_date !== null && $r->on_table !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->count();
        } if ($r->start_date !== null && $r->user_id !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->count();
        } if ($r->start_date !== null && $r->action !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->count();
        } if ($r->start_date !== null && $r->on_table !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->count();
        } if ($r->user_id !== null && $r->on_table !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.active', 1)
            ->count();
        }  if ($r->action !== null && $r->on_table !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.active', 1)
            ->count();
        }  if ($r->action !== null && $r->user_id !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.active', 1)
            ->count();
        } if ($r->action !== null && $r->user_id !== null && $r->start_date !== null) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->count();
        } if ($r->action !== null && $r->user_id !== null && $r->end_date !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.active', 1)
            ->count();
        }if ($r->action !== null && $r->on_table !== null && $r->end_date !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.active', 1)
            ->count();
        }if ($r->action !== null && $r->on_table !== null && $r->start_date !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->count();
        }
        if ($r->action !== null && $r->on_table !== null && $r->user_id !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.user_id', '>=', $_GET['user_id'])
            ->where('logs.active', 1)
            ->count();
        }
         if ($r->end_date !== null && $r->on_table !== null && $r->start_date !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.log_date','<=', $_GET['end_date'])
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->paginate(18);
            $data['total'] = DB::table('logs')
                ->join('users','logs.user_id', 'users.id')
                ->select('logs.*', 'users.name as user_id')
                ->where('logs.log_date','<=', $_GET['end_date'])
                ->where('logs.table_action', $_GET['on_table'])
                ->where('logs.log_date', '>=', $_GET['start_date'])
                ->where('logs.active', 1)
                ->count();
        }
        if ($r->action !== null && $r->user_id !== null && $r->end_date !== null && $r->start_date !== null) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.user_id', $_GET['user_id'])
            ->where('logs.log_date', '<=', $_GET['end_date'])
            ->where('logs.log_date', '>=', $_GET['start_date'])
            ->where('logs.active', 1)
            ->count();
        }
          
        $data['users'] = DB::table('users')
            ->orderBy('name')
            ->get();
        return view('logs.index', $data);
    }
    public function delete($id)
    {
        DB::table('logs')->where('id', $id)->update(["active"=>0]);
        $page = @$_GET['page'];
        if ($page>0)
        {
            return redirect('/log?page='.$page);
        }

        return redirect('/log');
    }
    public function detail($id , $table) {
        if($table == 'invoices') {
            $data['invoice'] = DB::table('invoices')
            ->join('students', 'students.id', 'invoices.customer_id')
            ->join('users' ,'invoices.invoice_by', 'users.id')
            ->select('invoices.*', 'students.*', 'invoices.id as invoice_id', 'users.name as invoice_by')
            ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
            ->where('invoices.id', $id)
            ->first();
            return view('logs.invoice', $data);
        }
      
        if($table == 'users') {
            $data['user'] = DB::table('users')
                ->where('id', $id)
                ->first();
            $data['role'] = DB::table('roles')
                ->where('id', $data['user']->role_id)
                ->first();
            return view('logs.user', $data);
        }

        if($table == 'items') {
            $data['item'] = DB::table('items')
                ->leftJoin('item_categories', 'item_categories.id', '=', 'items.item_category_id')
                ->join('branches', 'branches.id', '=', 'items.branch_id')
                ->select('items.*', 'branches.name as branch_id' ,'item_categories.name as item_category')
                ->where('items.id', $id)->first();
            return view('logs.item', $data);
        }

        if($table == 'staffs') {
            $data['staff'] = DB::table('staffs')->where('id', $id)->first();
            $data['documents'] = DB::table('staff_documents')
                ->where('active', 1)
                ->where('staff_id', $id)
                ->get();
            return view('logs.staff', $data);
        }

        if($table == 'students') {
            $data['shifts'] = DB::table('shifts')
                        ->where('active',1)
                        ->get();
            $data['branches'] = DB::table('branches')
                        ->whereIn('id', Right::branch(Auth::user()->id))
                        ->orderBy('name')
                        ->get();
            $data['student'] = DB::table('students')
                        ->where('id', $id)
                        ->first();
            $data['families'] = DB::table('families')
                        ->where('active', 1)
                        ->where('student_id', $id)
                        ->get();
            $data['documents'] = DB::table('documents')
                        ->where('active', 1)
                        ->where('student_id', $id)
                        ->get();
            $data['classes'] = DB::table('classes')
                        ->orderBy('name')
                        ->get();
            $data['years'] = DB::table('school_years')
                        ->orderBy('name')
                        ->get();
            $data['registrations'] = DB::table('registrations')
                            ->join('classes','registrations.class_id', "=", "classes.id")
                            ->join('school_years', "registrations.year_id", "=", "school_years.id")
                            ->join('shifts', 'shifts.id', 'registrations.shift_id')
                            ->where("registrations.active", 1)
                            ->where("registrations.student_id", $id)
                            ->select("registrations.*", "shifts.*", "shifts.name as shift_name", "classes.name as class_name", "school_years.name as year_name")
                            ->get();
            $data['invoices'] = DB::table('invoices')
                ->join('students', 'students.id', 'invoices.customer_id')
                ->select('invoices.*', 'students.*' ,'invoices.id as invoice_id')
                ->where('invoices.active',1)
                ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
                ->where('invoices.customer_id', $id)
                ->orderBy('invoices.id', 'desc')
                ->get();
            return view('logs.student', $data);
        }
    }
}
