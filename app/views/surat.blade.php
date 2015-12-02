@extends('layout')

@section('content')
<div class="row">
  <div class="span12">
    <div class="widget widget-nopad">
      <div class="widget-header"> <i class="icon-list-alt"></i>
        <h3> Surat</h3>
      </div>
      <div class="widget-content">
        <div class="widget big-stats-container">
          <div class="widget-content">
            <div style="padding:10px;">
              <button type="button" class="btn btn-success addbtn">Add Surat</button>
            </div>
            <table class="table table-striped" id="tableUser">
              <thead>
                <tr>
                  <th>#</th>
                  <th width="25%">Kode Surat</th>
                  <th width="25%">Format</th>
                  <th width="25%">Keterangan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($surats as $i => $objSurat)
                <tr id="tr_">
                  <td class="nbr">{{$i+1}}</td>
                  <td>{{$objSurat->kode_surat}}</td>
                  <td>{{$objSurat->format}}</td>
                  <td>{{$objSurat->keterangan}}</td>
                  <td>
                    @if($user->role_id == "1")
                    <button type="button" class="btn btn-warning editBtn" data-suratid="{{$objSurat->surat_id}}">Edit</button>
                    &nbsp;
                    <button type="button" class="btn btn-danger deleteBtn" data-suratid="{{$objSurat->surat_id}}">Delete</button>
                    &nbsp;
                    @endif
                    <button type="button" class="btn btn-info pilihBtn" data-suratid="{{$objSurat->surat_id}}">Pilih</button>
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
<div class="modal fade modalConfirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formSuratDelete">
          Are you sure want to delete this data ?
          <input type="hidden" id="surat_id" name="surat_id" />
        </form>
      </div>
      <div class="modal-footer">
        <div class="pull-left" id="msg_"></div>
        <div class="pull-right">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cencel</button>
          <button type="button" id="deleteSurat" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade modalPilih">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formPilih">
          <input type="hidden" id="surat_id" name="surat_id" />
          <input type="hidden" id="format" name="format" />
          <fieldset>
            <div class="row control-group">
              <label class="control-label" for="name">Last Number</label>
              <div class="controls">
                <input id="last_number" name="last_number" class="span4" disabled="" type="text" value="">
              </div>
            </div>
            <div class="row control-group">
              <label class="control-label" for="name">Your Number</label>
              <div class="controls">
                <div class="span4" id="msg_"></div>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <div class="pull-right">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id="generateSurat" class="btn btn-success">Generate</button>
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
      window.location.href = "surat/new";
    });
    $("body").on('click', '.editBtn', function(){
      var id = $(this).data('suratid');
      window.location.href = "surat/search?id="+id;
      return false;
    });
    $("body").on('click', '.deleteBtn', function(){
      var id = $(this).data('suratid');
      $("#msg_").text('');
      $(':input').val('');
      $(".modalConfirm .modal-title").text("Delete Surat");
      $(".modalConfirm #surat_id").val(id);
      $(".modalConfirm").modal();
    });
    $("body").on('click', '.pilihBtn', function(){
      var id = $(this).data('suratid');
      $("#msg_").text('');
      $(':input').val('');
      $(".modalPilih .modal-title").text("Generate Nomor Surat");
      $(".modalPilih #surat_id").val(id);
      $("#generateSurat").show();
      $("#formPilih #msg_").html('');
      $.ajax({
        type: 'POST',
        url: 'surat/getLast',
        data: {surat_id:id},
        success: function(data) {
          if (data.code === "1") {
            $(".modalPilih #last_number").val(data.data[0].nomor_surat);
            $(".modalPilih #format").val(data.data[0].surat.format);
            $(".modalPilih").modal();
          } else {
            alert('Data Not Found');
          }
        }
      });
    });
    $("#deleteSurat").click(function(){
      $.ajax({
        type: 'POST',
        data: $("#formSuratDelete").serialize(),
        url: 'surat/delete',
        success:function(data) {
          if (data.code === "1") {
            window.location.reload();
          } else {
            $("#msg_").text(data.message);
          }
        }
      });
    });
    $("#generateSurat").click(function(){
      $.ajax({
        type: 'POST',
        data: $("#formPilih").serialize(),
        url: 'surat/generate',
        success:function(data) {
          // alert(data.data.nomor_surat); return false;
          if (data.code === "1") {
            $("#generateSurat").hide();
            $("#formPilih #msg_").html('<b>'+data.data.nomor_surat+'</b>');
          } else {
            $("#msg_").text(data.message);
          }
        }
      });
    });
  });
</script>
@stop