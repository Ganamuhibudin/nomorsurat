@extends('layout')

@section('content')
<div class="row">
  <div class="span12">
    <div class="widget widget-nopad">
      <div class="widget-header"> <i class="icon-list-alt"></i>
        <h3> Form Surat</h3>
      </div>
      <div class="widget-content">
        <div class="widget big-stats-container">
          <div class="widget-content">
            <div style="padding:10px;">
              <form id="frmSurat" class="form-horizontal">
                <fieldset>
                  <input type="hidden" id="surat_id" name="surat_id" value="@if(! empty($surat)){{$surat[0]->surat_id}}@endif" />
                  <div class="control-group">
                    <label class="control-label" for="kodesurat">Kode Surat</label>
                    <div class="controls">
                      <input id="kodesurat" name="kode_surat" class="span2" type="text" maxlength="5" value="@if(! empty($surat)){{$surat[0]->kode_surat}}@endif">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="keterangan">Keterangan</label>
                    <div class="controls">
                      <input id="keterangan" name="keterangan" class="span4" type="text" value="@if(! empty($surat)){{$surat[0]->keterangan}}@endif" />
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="radiobtns">Jumlah Segmen </label>
                    <div class="controls">
                      <div class="input-append">
                        <input id="jumlah_segmen" name="jumlah_segmen" class="span1 m-wrap" type="text" value="@if(! empty($surat)){{$surat[0]->jumlah_segmen}}@endif">
                        <button class="btn btnSegmen" type="button">
                          <i class="icon-large icon-ok "></i>
                        </button>
                        &nbsp;
                        <b>
                          <i>Isikan jumlah segmen dengan angka kemudian tekan tombol check(<i class="icon-large icon-ok "></i>)</i>
                        </b>
                      </div>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Format</label>
                    <div class="controls">
                      <table id="tblFormat">
                      @if(! empty($surat))
                        @if($surat[0]->surat_id)
                        <?php  $arrformat = explode("/", $surat[0]->format) ?>
                        <?php
                          foreach ($format as $obj) {
                            $objFormat[$obj->tipe] = $obj->tipe." - ".$obj->keterangan;
                          }
                        ?>
                        @for($i = 1; $i <= $surat[0]->jumlah_segmen; $i++)
                        <tr>
                          <td>Segmen {{$i}}</td>
                          <td>
                          <?php
                            if ($arrformat[$i-1] != "AUTO" && $arrformat[$i-1] != "YEAR") {
                              $selected = 'FREETEXT';
                            } else {
                              $selected = $arrformat[$i-1];
                            }
                          ?>
                          {{ Form::select('format['.$i.']', $objFormat, $selected, array('class'=>'form-control')) }}
                          </td>
                          <td id="additional_{{$i}}">
                            @if($selected == "FREETEXT")
                            <input type="text" name="freetext[{{$i}}]" placeholder="Input Teks" value="{{$arrformat[$i-1]}}" />
                            @endif
                          </td>
                        </tr>
                        @endfor
                        @endif
                      @endif
                      </table>
                    </div>
                  </div>
                  <div class="form-actions">
                    <button class="btn btn-primary" id="saveSurat" type="button">Save</button>
                    <button class="btn">Cancel</button>
                  </div>
                </fieldset>
                <div class="pull-left" id="msg_"></div>
              </form>
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
    var site_url = '/nomorsurat/public/';
    $('#jumlah_segmen').on('input', function (event) { 
        this.value = this.value.replace(/[^1-9]/g, '');
    });
    $("body").on('click', '.btnSegmen', function(){
      var jumlah_segmen = $("#jumlah_segmen").val();
      if (jumlah_segmen != "") {
        $("#tblFormat").html('');
        $.ajax({
          type: 'GET',
          url: 'getFormat',
          success: function(data) {
            var opt = data.length;
            var addHtml = '';
            for (var x = 0; x < opt; x++) {
              addHtml = addHtml + '<option value="'+data[x].tipe+'">'+data[x].tipe+' - '+data[x].keterangan+'</option>';
            }
            for (var i = 1; i <= jumlah_segmen; i++) {
              $("#tblFormat").append('<tr>\n\
                                        <td>Segmen '+i+'</td>\n\
                                        <td>\n\
                                        <select id="format_'+i+'" name="format['+i+']" onchange="cekFormat('+i+')">'+addHtml+'</select>\n\
                                        </td>\n\
                                        <td id="additional_'+i+'"></td>\n\
                                      </tr>');
            }
          }
        });
      } else {
        alert('Silahkan mengisi jumlah segmen terlebih dahulu !');
      }
    });
    $("body").on('click', '#saveSurat', function(){
      var surat_id = $("#surat_id").val();
      var urlPost = 'newSurat';
      if (surat_id != '') {
        urlPost = 'update'
      }
      $.ajax({
        type: 'POST',
        url: urlPost,
        data: $("#frmSurat").serialize(),
        success: function(data) {
          if (data.code === "1") {
            location.href = site_url+'surat';
          } else {
            $("#msg_").text(data.message);
          }
        }
      });
    });
  });
  
  function cekFormat(id) {
    var picked = $("#format_"+id).val();
    if (picked == 'FREETEXT') {
      $("#additional_"+id).html('');
      $("#additional_"+id).append('<input type="text" name="freetext['+id+']" placeholder="Input Teks" />');
    } else {
      $("#additional_"+id).html('');
    }
  }
</script>
@stop