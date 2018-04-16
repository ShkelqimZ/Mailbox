@extends('layouts.website_layout')

@section('content')
<div class="col-md-12 col-sm-12">
    <div class="col-md-3">
        <ul id="mail-folders">
          <li>Folders</li>
          <li><a href="/inbox"><i class="fa fa-inbox"></i>&nbsp;&nbsp;&nbsp;Inbox</a></li>
          <li><a href="/sent" class="active"><i class="fa fa-paper-plane"></i>&nbsp;&nbsp;&nbsp;Sent</a></li>
          <li><a href="/deleted"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;Deleted</a></li>
        </ul>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-12">
            <div class="btns">
                <button data-toggle="modal" data-target="#newMail"><i class="fa fa-pencil-square-o fa-1x" style="font-size:30px; margin:auto;"></i></button>
                <button ng-click="deleteThisSentMail(<?php echo $sent_details[0]->inbox_id; ?>)"><i class="fa fa-trash fa-1x" style="font-size:30px; margin:auto;"></i></button>
            </div>
            </div>
        </div>
        <div id="mail-table">
            <h3 class="text-center">{{$sent_details[0]->subject}}</h3>
            <hr>
            <span><strong>To:</strong> {{$sent_details[0]->name}} {{$sent_details[0]->last_name}}</span>
            <div class="message">
                {{$sent_details[0]->message}}
            </div>
        </div>
    </div>
</div>
@endsection
<div id="newMail" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Message</h4>
            </div>
            <div class="modal-body">
              {{ Form::open(array('url' => 'send-mail', 'method' => 'post','enctype' => 'multipart/form-data')) }}
              
                  <div class="first-info">
                    <input type="text" class="form-control" name="to_user_id" placeholder="To" required>
                    <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                    <textarea name="message" id="" class="form-control" rows="6" style="resize:none;" required></textarea>
                  
                    {!! Form::submit('Send',array('class'=>'btn btn-primary form-control','style'=>'margin-top: 20px;background-color:#6D7FCC;border:0px')) !!}
                  </div>
              {{ Form::close() }}
            </div>
        </div>
    </div>
</div>