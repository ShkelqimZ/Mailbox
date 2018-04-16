@extends('layouts.website_layout')

@section('content')
<div class="col-md-12 col-sm-12">
    <div class="col-md-3 col-sm-3">
        <ul id="mail-folders">
          <li>Folders</li>
          <li><a href="/inbox"><i class="fa fa-inbox"></i>&nbsp;&nbsp;&nbsp;Inbox</a></li>
          <li><a href="/sent"><i class="fa fa-paper-plane"></i>&nbsp;&nbsp;&nbsp;Sent</a></li>
          <li><a href="/deleted" class="active"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;Deleted</a></li>
        </ul>
    </div>
    <div class="col-md-9 col-sm-9">
        <div class="row">
            <div class="col-md-12">
            <div class="btns">
                <button data-toggle="modal" data-target="#newMail"><i class="fa fa-pencil-square-o fa-1x" style="font-size:30px; margin:auto;"></i></button>
                <button ng-click="removeThisInboxMail(<?php echo $deleted_details[0]->inbox_id; ?>)"><i class="fa fa-trash fa-1x" style="font-size:30px; margin:auto;"></i></button>
            </div>
            </div>
        </div>
        <div id="mail-table">
            <h3 class="text-center">{{$deleted_details[0]->subject}}</h3>
            <hr>
             <span><strong>To:</strong>
                @if($deleted_details[0]->to_user_id == Auth::user()->id)
                    You
                @else
                    {{$deleted_details[0]->name}} {{$deleted_details[0]->last_name}}
                @endif
              </span>
            <div class="message">
                {{$deleted_details[0]->message}}
            </div>
        </div>
    </div>
</div>
@endsection