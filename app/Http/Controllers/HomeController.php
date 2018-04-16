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
        return view('home');
    }

    public function inbox()
    {
        $inbox_controller = new InboxController();
        $inbox = $inbox_controller->getInboxMails();
        return view('inbox',['inboxes'=>$inbox]);
    }

    public function sent()
    {
        $inbox_controller = new InboxController();
        $sent = $inbox_controller->getSentMails();
        return view('sent',['sents'=>$sent]);
    }

    public function deleted()
    {
        $inbox_controller = new InboxController();
        $deleted = $inbox_controller->getDeletedMails();
        // return $deleted;
        return view('deleted',['deleted_mails'=>$deleted]);
    }

    public function inboxDetail($inbox_id){

        $inbox_controller = new InboxController();
        $inbox_details = $inbox_controller->getInboxMailDetails($inbox_id);

        if(Auth::user()->id == $inbox_details[0]->to_user_id){
            return view('inbox_details',['inbox_details'=>$inbox_details]);
        }
        else{
            return redirect('/inbox');
        }
        
    }

    public function sentDetail($inbox_id){

        $inbox_controller = new InboxController();
        $sent_details = $inbox_controller->getSentMailDetails($inbox_id);

        if(Auth::user()->id == $sent_details[0]->from_user_id){
            return view('sent_details',['sent_details'=>$sent_details]);
        }
        else{
            return redirect('/sent');
        }
        
    }

    public function deletedDetail($inbox_id){

        $inbox_controller = new InboxController();
        $deleted_details = $inbox_controller->getDeletedMailDetails($inbox_id);

        if(Auth::user()->id == $deleted_details[0]->from_user_id || Auth::user()->id == $deleted_details[0]->to_user_id){
            return view('deleted_details',['deleted_details'=>$deleted_details]);
        }
        else{
            return redirect('/deleted');
        }
        
    }

}
