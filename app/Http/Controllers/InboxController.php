<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\inbox;

class InboxController extends Controller
{
    public function sendMail(Request $request){
        
        $from_user_id = Auth::user()->id;
        $email = $request->input('to_user_id');
        $user = User::select('id')->where('email',$email)->get();
        $to_user_id = $user[0]->id;
        $subject = $request->input('subject');
        $message = $request->input('message');

        $inbox = new inbox();
        $inbox->from_user_id = $from_user_id;
        $inbox->to_user_id = $to_user_id;
        $inbox->subject = $subject;
        $inbox->message = $message;

        $inbox->save();

        return redirect('/sent');
    }

    public function getInboxMails(){

        $to_user_id = Auth::user()->id;

        $inbox = inbox::select('inboxes.inbox_id','inboxes.from_user_id','inboxes.to_user_id','inboxes.subject','inboxes.message','inboxes.created_at','users.name','users.last_name')
        ->where('to_user_id',$to_user_id)
        ->join('users','id','=','from_user_id')
        ->where('deletedTo',0)
        ->orderBy('created_at','desc')
        ->paginate(10);
        return $inbox;
    }

    public function getSentMails(){

        $from_user_id = Auth::user()->id;

        $inbox = inbox::select('inboxes.inbox_id','inboxes.from_user_id','inboxes.to_user_id','inboxes.subject','inboxes.message','inboxes.created_at','users.name','users.last_name')
        ->join('users','id','=','to_user_id')
        ->where('from_user_id',$from_user_id)
        ->where('deletedFrom',0)
        ->orderBy('created_at','DESC')
        ->paginate(10);
        
        return $inbox;
    }

    public function getDeletedMails(){

        $user_id = Auth::user()->id;

        $inbox=inbox::select('inboxes.inbox_id','inboxes.from_user_id','inboxes.to_user_id','inboxes.subject','inboxes.message','inboxes.updated_at','users.name','users.last_name')
        ->join('users','id','=','from_user_id')
        ->where('to_user_id',$user_id)->where('deletedTo',1)
        ->orWhere('from_user_id',$user_id)->where('deletedFrom',1)
        ->orderBy('updated_at','DESC')
        ->paginate(10);
        
        return $inbox;
    }

    public function getInboxMailDetails($inbox_id){

        $inbox_details = inbox::select('inboxes.inbox_id','inboxes.from_user_id','inboxes.to_user_id','inboxes.subject','inboxes.message','inboxes.created_at','users.name','users.last_name')
        ->where('inbox_id',$inbox_id)
        ->join('users','id','=','from_user_id')
        ->get();

        return $inbox_details;

    }

    public function getSentMailDetails($inbox_id){

        $inbox_details = inbox::select('inboxes.inbox_id','inboxes.from_user_id','inboxes.to_user_id','inboxes.subject','inboxes.message','inboxes.created_at','users.name','users.last_name')
        ->where('inbox_id',$inbox_id)
        ->join('users','id','=','to_user_id')
        ->get();

        return $inbox_details;

    }
    public function getDeletedMailDetails($inbox_id){

        $inbox_details = inbox::select('inboxes.inbox_id','inboxes.from_user_id','inboxes.to_user_id','inboxes.subject','inboxes.message','inboxes.created_at','users.name','users.last_name')
        ->where('inbox_id',$inbox_id)
        ->join('users','id','=','to_user_id')
        ->get();

        return $inbox_details;

    }

    public function deleteInboxMail($inbox_id){

        $inbox= new inbox;
        $user_id = Auth::user()->id;
        $inbox->where("inbox_id",$inbox_id)->where('to_user_id',$user_id)->update([
            "deletedTo" => true,
        ]);
        return redirect('/inbox');
    }

    public function deleteInboxMails(Request $request){

        $inbox= new inbox;
        $to_user_id = Auth::user()->id;
        $inbox_id = $request -> input('inbox_ids');
        for($i = 0;$i<count($inbox_id);$i++){
            $inbox->where("inbox_id",$inbox_id[$i])->where('to_user_id',$to_user_id)->update([
                "deletedTo" => true,
            ]);
        }
        return redirect('/inbox');
    }

    public function deleteSentMail($inbox_id){

        $inbox= new inbox;
        $user_id = Auth::user()->id;
        $inbox->where("inbox_id",$inbox_id)->where('from_user_id',$user_id)->update([
            "deletedFrom" => true,
        ]);
        return redirect('/sent');
    }

    public function deleteSentMails(Request $request){

        $inbox= new inbox;
        $from_user_id = Auth::user()->id;
        $inbox_id = $request -> input('inbox_ids');
        for($i = 0;$i<count($inbox_id);$i++){
            $inbox->where("inbox_id",$inbox_id[$i])->where('from_user_id',$from_user_id)->update([
                "deletedFrom" => true,
            ]);
        }
        return redirect('/sent');
    }




    public function deleteInboxMailPermanently($inbox_id){

        $inbox= new inbox;
        $user_id = Auth::user()->id;
        $inbox->where("inbox_id",$inbox_id)->delete();
        return redirect('/inbox');
    }

    public function deleteInboxMailsPermanently(Request $request){

        $inbox= new inbox;
        $to_user_id = Auth::user()->id;
        $inbox_id = $request -> input('inbox_ids');
        for($i = 0;$i<count($inbox_id);$i++){
            $inbox->where("inbox_id",$inbox_id[$i])->delete();
        }
        return redirect('/inbox');
    }

    // public function deleteSentMailPermanently($inbox_id){

    //     $inbox= new inbox;
    //     $user_id = Auth::user()->id;
    //     $inbox->where("inbox_id",$inbox_id)->where('from_user_id',$user_id)->delete();
    //     return redirect('/sent');
    // }

    // public function deleteSentMailsPermanently(Request $request){

    //     $inbox= new inbox;
    //     $from_user_id = Auth::user()->id;
    //     $inbox_id = $request -> input('inbox_ids');
    //     for($i = 0;$i<count($inbox_id);$i++){
    //         $inbox->where("inbox_id",$inbox_id[$i])->where('from_user_id',$from_user_id)->delete();
    //     return redirect('/sent');
    // }



    
}
