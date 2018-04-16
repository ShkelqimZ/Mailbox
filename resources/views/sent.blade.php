@extends('layouts.website_layout')

@section('content')
<div class="col-md-12 col-sm-12">
  <div class="row">
    <div class="col-md-3 col-sm-3">
        <ul id="mail-folders">
          <li>Folders</li>
          <li><a href="/inbox"><i class="fa fa-inbox"></i>&nbsp;&nbsp;&nbsp;Inbox</a></li>
          <li><a href="/sent" class="active"><i class="fa fa-paper-plane"></i>&nbsp;&nbsp;&nbsp;Sent</a></li>
          <li><a href="/deleted"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;Deleted</a></li>
        </ul>
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="row">
        <div class="col-md-12">
          <div class="btns">
              <button ng-click="refreshSent()"><i class="fa fa-refresh fa-1x" style="font-size:30px; margin:auto;"></i></button>
              <button data-toggle="modal" data-target="#newMail"><i class="fa fa-pencil-square-o fa-1x" style="font-size:30px; margin:auto;"></i></button>
              <button ng-click="deleteSentMail()" ng-if="checkForDelete"><i class="fa fa-trash fa-1x" style="font-size:30px; margin:auto;"></i></button>
          </div>
        </div>
      </div>
      <table id="mail-table" class="table text-center" id="inbox">
        <tr>
            <td></td>
            <th class="text-center">To</th>
            <th class="text-center">Subject</th>
            <th class="text-center">Date</th>
        </tr>
        <tbody>
          @foreach($sents as $sent)
          <tr>
            <td><input type="checkbox" name="inbox_ids" ng-click="fillArrayWithMailsToDelete(<?php echo $sent->inbox_id; ?>)"></td>
            <td style="padding:0;"><a href="/sent/{{$sent->inbox_id}}" style="display:block;padding:8px;">{{$sent->name}} {{$sent->last_name}}</a></td>
            <td style="padding:0;"><a href="/sent/{{$sent->inbox_id}}" style="display:block;padding:8px;">{{$sent->subject}}</a></td>
            <td style="padding:0;"><a href="/sent/{{$sent->inbox_id}}" style="display:block;padding:8px;">{{$sent->created_at->diffForHumans()}}</a></td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{$sents->links()}}
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