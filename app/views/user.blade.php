@extends('layout')

@section('content')
<div class="row">
  <div class="span12">
    <div class="widget widget-nopad">
      <div class="widget-header"> <i class="icon-list-alt"></i>
        <h3> User</h3>
      </div>
      <div class="widget-content">
        <div class="widget big-stats-container">
          <div class="widget-content">
            <div style="padding:10px;">
              <button type="button" class="btn btn-success addbtn">Add User</button>
            </div>
            <table class="table table-striped" id="tableUser">
              <thead>
                <tr>
                  <th>#</th>
                  <th width="30%">Name</th>
                  <th width="25%">Username</th>
                  <th width="25%">Role</th>
                  <th>Action</th>
                </tr>
              <thead>
              <tbody>
                @foreach($users as $i => $objUser)
                <tr id="tr_{{$objUser->user_id}}">
                  <td class="nbr">{{$i+1}}</td>
                  <td>{{$objUser->name}}</td>
                  <td>{{$objUser->email}}</td>
                  <td>{{$objUser->role->keterangan}}</td>
                  <td>
                    <button type="button" class="btn btn-warning editBtn" data-userid="{{$objUser->user_id}}">Edit</button>
                    &nbsp;
                    <button type="button" class="btn btn-danger deleteBtn" data-userid="{{$objUser->user_id}}">Delete</button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>                
        </div>
      </div>
    </div>
  </div>
</div>
@stop
@section('modals')
<div class="modal fade modalUser">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formUser">
          <fieldset>
            <div class="row control-group">
              <label class="control-label" for="name">Name</label>
              <div class="controls">
                <input id="name" name="name" class="span4" placeholder="Name" type="text" value="">
              </div>
            </div>
            <div class="row control-group">
              <label class="control-label" for="email">Username</label>
              <div class="controls">
                <input id="email" name="email" class="span4" placeholder="Email" type="text" value="">
              </div>
            </div>
            <div class="row control-group">
              <label class="control-label" for="password">Password</label>
              <div class="controls">
                <input id="password" name="password" class="span4" placeholder="Password" type="password" value="">
              </div>
            </div>
            <div class="row control-group">
              <label class="control-label" for="role">Role</label>
              <div class="controls">
                <select class="form-control" id="role" name="role">
                  @foreach($roles as $role)
                  <option value="{{$role->role_id}}">{{$role->keterangan}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <div class="pull-left" id="msg_"></div>
        <div class="pull-right">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id="saveUser" class="btn btn-primary">Save</button>
          <button type="button" id="updateUser" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade modalConfirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formUserDelete">
          Are you sure want to delete this data ?
          <input type="hidden" id="user_id" name="user_id" />
        </form>
      </div>
      <div class="modal-footer">
        <div class="pull-left" id="msg_"></div>
        <div class="pull-right">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cencel</button>
          <button type="button" id="deleteUser" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop
@section('scriptjs')
<script type="text/javascript">
  $(document).ready(function(){
    $("body").on('click', '.addbtn', function(){
      $("#msg_").text('');
      $(':input').val('');
      $(".modalUser .modal-title").text("Add User");
      $("#saveUser").show();
      $("#updateUser").hide();
      $(".modalUser").modal();
    });
    $("body").on('click', '.editBtn', function(){
      var id = $(this).data('userid');
      $("#msg_").text('');
      $(':input').val('');
      $(".modalUser .modal-title").text("Edit User");
      $("#saveUser").hide();
      $("#updateUser").show();
      $.ajax({
        type: 'GET',
        url: 'user/search?id='+id,
        success: function(data) {
          $("#formUser #user_id").remove();
          $("#formUser").append('<input type="hidden" id="user_id" name="user_id" value="'+id+'" />')
          $("#name").val(data.data[0].name);
          $("#email").val(data.data[0].email);
          $("#password").attr('disabled', 'disabled');
          $("#role").val(data.data[0].role_id)
        }
      });
      $(".modalUser").modal();
    });
    $("body").on('click', '.deleteBtn', function(){
      var id = $(this).data('userid');
      $("#msg_").text('');
      $(':input').val('');
      $(".modalConfirm .modal-title").text("Delete User");
      $(".modalConfirm #user_id").val(id);
      $(".modalConfirm").modal();
    });
    $("#saveUser").click(function(){
      $.ajax({
        type: 'POST',
        data: $("#formUser").serialize(),
        url: 'user/new',
        success:function(data) {
          if (data.code === "1") {
            $("#msg_").text(data.message);
            var no = $("#tableUser tbody tr").length;
            $("#tableUser tbody").append('<tr>\n\
              <td>'+(no + 1)+'</td>\n\
              <td>'+data.data.name+'</td>\n\
              <td>'+data.data.email+'</td>\n\
              <td>'+data.data.keterangan+'</td>\n\
              <td>\n\
                <button type="button" class="btn btn-warning editBtn" data-userid="'+data.data.user_id+'">\n\
                Edit</button>\n\
                &nbsp;\n\
                <button type="button" class="btn btn-danger deleteBtn" data-userid="'+data.data.user_id+'">\n\
                Delete</button>\n\
              </td>\n\
            </tr>');
            setTimeout(function() {
              $('.modalUser').modal('hide')
            }, 2000);
          } else {
            $("#msg_").text(data.message);
          }
        }
      });
    });
    $("#updateUser").click(function(){
      $.ajax({
        type: 'POST',
        data: $("#formUser").serialize(),
        url: 'user/update',
        success:function(data) {
          if (data.code === "1") {
            $("#msg_").text(data.message);
            var no = $("#tr_"+data.data.user_id+" .nbr").text();
            $("#tr_"+data.data.user_id).html('<td>'+no+'</td>\n\
              <td>'+data.data.name+'</td>\n\
              <td>'+data.data.email+'</td>\n\
              <td>'+data.data.keterangan+'</td>\n\
              <td>\n\
                <button type="button" class="btn btn-warning editBtn" data-userid="'+data.data.user_id+'">\n\
                Edit</button>\n\
                &nbsp;\n\
                <button type="button" class="btn btn-danger deleteBtn" data-userid="'+data.data.user_id+'">\n\
                Delete</button>\n\
              </td>');
            setTimeout(function() {
              $('.modalUser').modal('hide')
            }, 2000);
          } else {
            $("#msg_").text(data.message);
          }
        }
      });
    });
    $("#deleteUser").click(function(){
      $.ajax({
        type: 'POST',
        data: $("#formUserDelete").serialize(),
        url: 'user/delete',
        success:function(data) {
          if (data.code === "1") {
            window.location.reload();
          } else {
            $("#msg_").text(data.message);
          }
        }
      });
    });
  });
</script>
@stop