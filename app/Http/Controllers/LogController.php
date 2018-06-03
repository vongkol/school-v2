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
            ->where('logs.table_action', $_GET['user_id'])
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
            ->where('logs.user_id', '>=', $_GET['user_id'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.user_id', '>=', $_GET['user_id'])
            ->where('logs.active', 1)
            ->count();
        }  if ($r->action !== null && $r->on_table !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.action_type', '>=', $_GET['action'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.table_action', $_GET['on_table'])
            ->where('logs.action_type', '>=', $_GET['action'])
            ->where('logs.active', 1)
            ->count();
        }  if ($r->action !== null && $r->user_id !== null ) {
            $data['logs'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->orderBy('logs.id', 'desc')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.user_id', '>=', $_GET['user_id'])
            ->where('logs.active', 1)
            ->paginate(18);
        $data['total'] = DB::table('logs')
            ->join('users','logs.user_id', 'users.id')
            ->select('logs.*', 'users.name as user_id')
            ->where('logs.action_type', $_GET['action'])
            ->where('logs.user_id', '>=', $_GET['user_id'])
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
}
