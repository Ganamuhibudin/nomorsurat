@extends('layout')

@section('content')
<div class="row">
  <div class="span12">
    <div class="widget widget-nopad">
      <div class="widget-header"> <i class="icon-list-alt"></i>
        <h3> Home</h3>
      </div>
      <div class="widget-content">
        <div class="widget big-stats-container">
          <div class="widget-content">
            <h6 class="bigstats">APLIKASI PENOMORAN SURAT</h6>
            <div style="padding:10px;">
              <form class="form-horizontal" id="formPilih">
                <fieldset>
                  <div class="control-group">
                    <label class="control-label" for="name">Tracking Nomor Surat</label>
                    <div class="controls">
                      <input id="nomor_surat" name="nomor_surat" class="span4" placeholder="Nomor Surat" type="text">
                      <button type="button" class="btn btn-info" id="btnSearch">
                        <i class="icon-large icon-search "></i> Cari
                      </button>
                    </div>
                  </div>
                </fieldset>
              </form>
              <table class="table table-striped" id="tableSearch" style="display:none;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th width="15%">Kode Surat</th>
                    <th width="25%">Nomor Surat</th>
                    <th width="35%">PIC</th>
                    <th width="25%">Waktu Generate</th>
                  </tr>
                </thead>
                </tbody>
              </table>
            </div>
          </div>                
        </div>
      </div>
    </div>
  </div>
</div>
@stop
@section('scriptjs')
<script type="text/javascript">
  $(document).ready(function(){
    $("body").on('click', '#btnSearch', function(){
      var nomor_surat = $("#nomor_surat").val();
      $.ajax({
        type: 'POST',
        url: 'surat/tracking',
        data: {nomor_surat: nomor_surat},
        success: function(data) {
          console.log(data);
          var total = data.data.length;
          if (total > 0) {
            $("#tableSearch .result").remove();
            var html = '<tbody>';
            for (var i = 0; i < total; i++) {
              html = html + '<tr class="result">';
              html = html + '<td>'+(i + 1)+'</td>';
              html = html + '<td>'+data.data[i].surat.kode_surat+'</td>';
              html = html + '<td>'+data.data[i].nomor_surat+'</td>';
              html = html + '<td>'+data.data[i].users.name+'</td>';
              html = html + '<td>'+data.data[i].created_at+'</td>';
              html = html + '</tr>';
            }
            html = html + '</tbody>';
            $("#tableSearch").show();
            $("#tableSearch").append(html);
          } else {
            $("#tableSearch .result").remove();
            var html = '<tbody>';
            html = html + '<tr class="result">';
            html = html + '<td colspan="5"><center>Data Not Found</center></td>';
            html = html + '</tr>';
            html = html + '</tbody>';
            $("#tableSearch").show();
            $("#tableSearch").append(html);
          }
        }
      })
    });
  });
</script>
@stop