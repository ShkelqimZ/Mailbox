<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\inbox;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inbox_controller = new InboxController();
        $numberOfMessages = $inbox_controller->numberOfUnSeenMails();
        return view('dashboard',['numberOfMessages'=>$numberOfMessages]);
    }

    public function inbox()
    {
        $inbox_controller = new InboxController();
        $inbox = $inbox_controller->getInboxMails();
        $numberOfMessages = $inbox_controller->numberOfUnSeenMails();

        return view('inbox',['inboxes'=>$inbox,'numberOfMessages'=>$numberOfMessages]);
    }

    public function sent()
    {
        $inbox_controller = new InboxController();
        $sent = $inbox_controller->getSentMails();
        $numberOfMessages = $inbox_controller->numberOfUnSeenMails();

        return view('sent',['sents'=>$sent,'numberOfMessages'=>$numberOfMessages]);
    }

    public function deleted()
    {
        $inbox_controller = new InboxController();
        $deleted = $inbox_controller->getDeletedMails();
        $numberOfMessages = $inbox_controller->numberOfUnSeenMails();

        return view('deleted',['deleted_mails'=>$deleted,'numberOfMessages'=>$numberOfMessages]);
    }

    public function inboxDetail($inbox_id){

        $inbox_controller = new InboxController();
        $inbox_details = $inbox_controller->getInboxMailDetails($inbox_id);
        $numberOfMessages = $inbox_controller->numberOfUnSeenMails();

        if(Auth::user()->id == $inbox_details[0]->to_user_id){

            $inbox= new inbox;
            $user_id = Auth::user()->id;
            $inbox->where("inbox_id",$inbox_id)->where('to_user_id',$user_id)->update([
                "seen" => true,
            ]);
            return view('inbox_details',['inbox_details'=>$inbox_details,'numberOfMessages'=>$numberOfMessages]);
        }
        else{
            return redirect('/inbox');
        }
        
    }

    public function sentDetail($inbox_id){

        $inbox_controller = new InboxController();
        $sent_details = $inbox_controller->getSentMailDetails($inbox_id);
        $numberOfMessages = $inbox_controller->numberOfUnSeenMails();

        if(Auth::user()->id == $sent_details[0]->from_user_id){
            return view('sent_details',['sent_details'=>$sent_details,'numberOfMessages'=>$numberOfMessages]);
        }
        else{
            return redirect('/sent');
        }
        
    }

    public function deletedDetail($inbox_id){

        $inbox_controller = new InboxController();
        $deleted_details = $inbox_controller->getDeletedMailDetails($inbox_id);
        $numberOfMessages = $inbox_controller->numberOfUnSeenMails();

        if(Auth::user()->id == $deleted_details[0]->from_user_id || Auth::user()->id == $deleted_details[0]->to_user_id){
            return view('deleted_details',['deleted_details'=>$deleted_details,'numberOfMessages'=>$numberOfMessages]);
        }
        else{
            return redirect('/deleted');
        }
        
    }


}
