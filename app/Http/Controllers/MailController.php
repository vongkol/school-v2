<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use PHPMailer\PHPMailer\PHPMailer;
class MailController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()==null)
            {
                return redirect("/login");
            }
            return $next($request);
        });
    }
    // index
    public function index()
    {
        if(!Right::check('Mail Marketing', 'l'))
        {
            return view('permissions.no');
        }
        $data['mails'] = DB::table("mails")
            ->orderBy("id", "desc")
            ->paginate(18);
        return view("mails.index", $data);
    }
    public function create()
    {
        if(!Right::check('Mail Marketing', 'i'))
        {
            return view('permissions.no');
        }
        if (Auth::user()==null)
        {
            return redirect('/admin');
        }
        $data['mails'] = DB::table("students")
            ->where("active",1)
            ->orderBy('email')
            ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
            ->get();
        return view("mails.create", $data);
    }
    public function detail($id)
    {
        if(!Right::check('Mail Marketing', 'l')){
            return view('permissions.no');
        }

        $data['mail'] = DB::table('mails')->where('id', $id)->first();
        return view('mails.detail', $data);
    }

    public function send(Request $r)
    {
        for($i=0;$i<count($r->list);$i++)
        {
            try {
                
                $mail = new PHPMailer(true); // notice the \  you have to use root namespace here
                $mail->isSMTP(); // tell to use smtp
                $mail->CharSet = "utf-8"; // set charset to utf8
                $mail->SMTPAuth = true;  // use smpt auth
                $mail->SMTPSecure = "ssl"; // or ssl
                $mail->MailerDebug = false;
                $mail->Host = "gator3163.hostgator.com";
                $mail->Port = 465; // most likely something different for you. This is the mailtrap.io port i use for testing.
                $mail->Username = "marketing@hrangkor.com";
                $mail->Password = "Khmer@123";
                $mail->setFrom("info@sunriseinformatics.tech", "Sunrise Institute for Technology");
                $mail->Subject = "Sunrise Institute for Technology : ". $r->subject;
                $mail->MsgHTML($r->description);
                $mail->addAddress($r->list[$i]);
                $mail->send();
             } catch (phpmailerException $e) {
   
             } catch (Exception $e) {

            }
          
        }
        // insert message to db
        $data = array(
            "subject" => $r->subject,
            "description" => $r->description,
            "send_to" => ('Student'),
            "send_date" => date('Y-m-d')
        );
        DB::table("mails")->insert($data);
        
        $r->session()->flash("sms", "Emails have sent!");
        return redirect("/mail/create");
    }
    // get employee mail
    public function get_email($id)
    {
        if ($id==0)
        {
            return DB::table("students")->where("active",1)->orderBy("email")->whereIn('students.branch_id', Right::branch(Auth::user()->id))->get();
        }
        else{
            return DB::table("students")->where("active",1)->orderBy("email")
            ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
            ->get();
        }

    }
    public function delete($id)
    {
        if(!Right::check('Mail Marketing', 'd'))
        {
            return view('permissions.no');
        }
        $i = DB::table("mails")->where("id", $id)->delete();
        return redirect("/mail");
    }

}
