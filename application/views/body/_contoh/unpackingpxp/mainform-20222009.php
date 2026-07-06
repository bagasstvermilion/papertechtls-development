<?php //echo md5('oln'); 
?>

<section class="content">

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><span id="vJudulForm1"><b>UNPACKING PxP (Part by part) HML</b></span></h3>
          <div class="card-tools">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->

            <button style="display:none;" onclick="fCariData()" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Cari</button>

            <button style="display:none;" onclick="fDataReload()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Reload Data</button>

            <div class="btn-group" role="group" aria-label="Basic example">

              <button style="display:none;" onclick="addForm('http://intranet.isfa/hrs/armada/kendaraan')" type="button" class="btn btn-warning btn-xs"><i class="fa fa-plus-circle"></i> Tambah</button>

            </div>
          </div>
          <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="background-color:#D3D0CB;">

          <?php
          //$sql = "SELECT count(mmp.partno1) as jmldata from machining_stock_data msd right join machining_master_part mmp on msd.partno1=mmp.partno1 where msd.Qty_EndStock is null";
          $sql = "SELECT count(distinct partno) as jmldata from machining_shipping_plan  where partno not in (select distinct partno1 from (
            select partno1 from machining_stock_data
            union
            select partno1 from machining_master_part
            ) as tabel1)";
          //$row = $this->db->query($sql)->row_array();
          $rs = $this->db->query($sql);
          if ($rs->num_rows() > 0) {
            $row = $this->db->query($sql)->row_array();
            if ($row['jmldata'] > 0) {
          ?>
              <div class="row">
                <div class="col-lg-2">&nbsp;</div>
                <div class="col-lg-8">
                  <div align="center">
                    <div class='alert bg-danger' role='alert'>
                      <!-- <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> -->
                      <span style='color:white;'>Warning: there is <b><?php echo $row['jmldata'] ?></b> unavailable part number in <b>***_stock_data</b> table <a href="<?php echo base_url(); ?>index.php/unpackingpxp/unavailable_master_stock">click here for detail</a></span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-2">&nbsp;</div>
              </div>
          <?php }
          } ?>

          <form name="frm1" id="frm1" method="" action="">

            <audio style="display:none;" id="audio_error" src="<?php echo base_url(); ?>assets/audio/negative_beeps-6008.mp3" controls="" controlslist="nodownload"></audio>
            <audio style="display:none;" id="audio_sukses" src="<?php echo base_url(); ?>assets/audio/dad-says-ok-1-113120.mp3" controls="" controlslist="nodownload"></audio>
            <audio style="display:none;" id="audio_sukses1" src="<?php echo base_url(); ?>assets/audio/female-thank-you.mp3" controls="" controlslist="nodownload"></audio>

            <div class="row">
              <div class="col-lg-8">
                <div class="row" style="">
                  <div class="col-lg-4">
                    <label class="col-form-label"><a href="javascript:void(0);" onclick="fun_modalFrmCaseMark();" title="Click here for Scan Case Mark manual input">Scan Case Mark</a></label>
                    <div class="input-group">
                      <input id="scanCaseMarkTmp" name="scanCaseMarkTmp" placeholder="Scan Case Mark" type="text" class="form-control form-control-lg" autocomplete="off" autofocus>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label class="col-form-label">Case No</label>
                    <div class="input-group">
                      <input id="scmCaseNo" name="scmCaseNo" placeholder="" type="text" class="form-control form-control-lg" readonly>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label class="col-form-label">Case Type</label>
                    <div class="input-group">
                      <input id="scmCaseType" name="scmCaseType" placeholder="" type="text" class="form-control form-control-lg" readonly>
                    </div>
                  </div>

                </div>
                <div class="row">&nbsp;</div>
                <div class="row">
                  <div class="col-lg-5" id="kolom_scan_label_mark_here">
                    <div class="row">
                      <div class="col-lg-12">
                        <label class="col-form-label"><a href="javascript:void(0);" onclick="fun_modalFrmLabelMark();" title="Click here for Scan Label Mark manual input">Scan Label Mark</a></label>
                        <div class="input-group">
                          <input id="scanLabelMarkTmp" name="scanLabelMarkTmp" placeholder="Scan Label HML" type="text" class="form-control form-control-lg" autocomplete="off">
                          <input style="display:none;" id="scanLabelMark" name="scanLabelMark" placeholder="Scan Label HML" type="text" class="form-control form-control-lg" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                        <label class="col-form-label">End Stock Qty</label>
                        <div class="input-group">
                          <input id="qtyEndStock" name="qtyEndStock" placeholder="" type="text" class="form-control form-control-lg" readonly style="font-weight: bold; font-size: 70px; height:80px; background-color: orange;  text-align:center;" value="0" title="Get from Table Machining Stock Data">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-7" id="kolom_status_case_dll">
                    <div class="row">
                      <div class="col-lg-1">&nbsp;</div>
                      <div class="col-lg-3">
                        <label class="col-form-label">Status Case</label>
                      </div>
                      <div class="col-lg-8">
                        <div class="input-group">
                          <input id="statusCase" name="statusCase" placeholder="" type="text" class="form-control form-control-lg" readonly style="margin-bottom: 4px; font-size: 45px; height:60px; font-weight: bold;">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-1">&nbsp;</div>
                      <div class="col-lg-3">
                        <label class="col-form-label">Status Part</label>
                      </div>
                      <div class="col-lg-8">
                        <div class="input-group">
                          <input id="statusPart" name="statusPart" placeholder="" type="text" class="form-control form-control-lg" readonly style="margin-bottom: 4px; font-size: 45px; height:60px; font-weight: bold;">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-1">&nbsp;</div>
                      <div class="col-lg-3">
                        <label class="col-form-label">Rack Address</label>
                      </div>
                      <div class="col-lg-8">
                        <div class="input-group">
                          <input title="Get from Table Master" id="mstRackAddress" name="mstRackAddress" placeholder="" type="text" class="form-control form-control-lg" readonly style="margin-bottom: 4px; font-size: 45px; height:60px; font-weight: bold;">
                        </div>
                      </div>
                    </div>
                    <div class="row" style="display:none;">
                      <div class="col-lg-1">&nbsp;</div>
                      <div class="col-lg-3">
                        <label class="col-form-label">Hamidasi</label>
                      </div>
                      <div class="col-lg-8">
                        <div class="input-group">
                          <input title="Get from Table Master" id="mstHamidasi" name="mstHamidasi" placeholder="" type="text" class="form-control form-control-lg" readonly style="margin-bottom: 4px;">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-1">&nbsp;</div>
                      <div class="col-lg-3">
                        <label class="col-form-label">Supply</label>
                      </div>
                      <div class="col-lg-4">
                        <div class="input-group">
                          <input id="supplyRack" name="supplyRack" placeholder="Rack" type="text" class="form-control form-control-lg" readonly title="IF safetyStock < endStock" style="font-size: 45px; height:60px; font-weight: bold;">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="input-group">
                          <input id="supplyHamidasi" name="supplyHamidasi" placeholder="Hamidasi" type="text" class="form-control form-control-lg" readonly title="IF safetyStock > endStock" style="font-size: 45px; height:60px; font-weight: bold;">
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="row">
                  <div class="col-lg-12">
                    <label class="col-form-label">Status Information</label>
                    <div class="input-group">
                      <input id="statusInfo" name="statusInfo" placeholder="Status Information" type="text" class="form-control form-control-lg" readonly style="background-color: ; color:black; text-align:center; font-size: 65px; height:80px;">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <label class="col-form-label">Total Scan</label>
                    <div class="input-group">
                      <input id="totalScan" style="display:none;" name="totalScan" placeholder="" type="text" class="form-control form-control-lg" readonly style="font-weight: bold; font-size: 120px; height:125px; text-align:center;" value="0">

                      <div style="width: 100%;">
                        <div style="text-align: center; background-color:white; border-style: solid; border-color: black; border-width: 0px;">
                          <span id="totalScanSpan" style="font-weight: bold; font-size: 100px; height:105px;  color:red; display: inline-flex; align-items: center;">0</span>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div align="center"><label class="col-form-label">Plan (Pcs)</label></div>
                    <div class="input-group">
                      <input id="planBox" name="planBox" placeholder="" type="text" class="form-control form-control-lg" style="font-size: 60px; height:70px; font-weight: bold; text-align:center;" readonly>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div align="center"><label class="col-form-label">Actual (Pcs)</label></div>

                    <input id="actualBox" name="actualBox" placeholder="" type="text" class="form-control form-control-lg" style="font-size: 60px; height:70px; font-weight: bold; text-align:center;" readonly onchange="alert(this.value)">

                  </div>

                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-2">
                &nbsp;
              </div>
            </div>

            <div class="row" style="background-color: #9FB1BC;">
              <div class="col-lg-2">
                <div align="center"><label class="col-form-label">Case No</label></div>
                <div class="input-group">
                  <input id="slmCaseNo" name="slmCaseNo" placeholder="" type="text" class="form-control form-control-lg" readonly style="text-align: center;">
                </div>
              </div>
              <div class="col-lg-1">
                <div align="center"><label class="col-form-label">Case Type</label></div>
                <div class="input-group">
                  <input id="slmCaseType" name="slmCaseType" placeholder="" type="text" class="form-control form-control-lg" readonly style="text-align: center;">
                </div>
              </div>
              <div class="col-lg-2">
                <div align="center"><label class="col-form-label">Part No</label></div>
                <div class="input-group">
                  <input id="slmPartNo" name="slmPartNo" placeholder="" type="text" class="form-control form-control-lg" readonly style="text-align: center;">
                </div>
              </div>
              <div class="col-lg-3">
                <div align="center"><label class="col-form-label">Part Name</label></div>
                <div class="input-group">
                  <input id="slmPartName" name="slmPartName" placeholder="" type="text" class="form-control form-control-lg" readonly>
                </div>
              </div>
              <div class="col-lg-1">
                <div align="center"><label class="col-form-label">Qty</label></div>
                <div class="input-group">
                  <input id="slmQty" name="slmQty" placeholder="" type="text" class="form-control form-control-lg" readonly style="text-align: right;">
                </div>
              </div>
              <div class="col-lg-3">
                <div align="center"><label class="col-form-label">Key Code</label></div>
                <div class="input-group">
                  <input id="slmKeyCode" name="slmKeyCode" placeholder="" type="text" class="form-control form-control-lg btn-warning" title="if caseNo Scan Case Mark = caseNo Scan Label Mark">
                </div>
              </div>
            </div>

            <div class="row" style="background-color: #9FB1BC;">&nbsp;</div>
            <div class="row">&nbsp;</div>
            <div class="row">
              <div class="col-md-12" align="center">
                <?php if ($this->session->userdata('isadmin') == 'yes' || $this->session->userdata('ispic') == 'yes') { ?>
                  <a href="<?php echo base_url(); ?>index.php/unpackingpxp/uploadshipmentplan" class="btn btn-primary btn-lg"><i class="fa fa-upload"></i> Upload Shipment Plan</a>&nbsp;
                <?php } ?>
                <a href="<?php echo base_url(); ?>index.php/unpackingpxp/view_finishcase" class="btn btn-primary btn-lg">View Finish Case</a>&nbsp;

                <a href="<?php echo base_url(); ?>index.php/unpackingpxp/view_stockmch" class="btn btn-primary btn-lg">View Stock</a>&nbsp;

                <a href="<?php echo base_url(); ?>index.php/unpackingpxp/view_proggress_unpacking" class="btn btn-primary btn-lg">View Progress Unpacking</a>&nbsp;

                <a href="<?php echo base_url(); ?>index.php/unpackingpxp/view_finish_unpacking" class="btn btn-primary btn-lg">View Finish Unpacking</a>&nbsp;
              </div>
            </div>



          </form>
        </div> <!-- eof main body -->


        <div class="row" style="padding: 10px;">
          <div class="col-lg-12">
            <table id="tabel1" class="table table-striped table-bordered table-responsive-md table-hover" style="font-size: 14px">
              <thead>
                <th class="text-center">No</th><!-- width="5%" -->
                <th class="text-center">Case No</th>
                <th class="text-center">Part No</th>
                <th class="text-center">Part Name</th>
                <th class="text-center">Qty Plan</th>
                <th class="text-center">Qty Actual</th>
                <th class="text-center">State</th>
                <!-- <th class="text-center">Action</th> -->
              </thead>

            </table>
          </div>

        </div>

      </div>

    </div>
  </div>
</section>

<?php require_once('mainform_modalFrmCaseMark.php'); ?>

<?php //require_once('mainform_modalFrmLabelMark.php'); //ga kepake 
?>

<script>
  $('#actualBox').css({
    "background-color": "yellow",
    "color": "black",
  });

  var url;
  let dtTable;

  var dataUrl = '<?php echo base_url(); ?>index.php/Unpackingpxpdata/blank_data';
  //var dataUrl = '<?php echo base_url(); ?>index.php/unpackingpxpdata/get_match_unmatch_actual_vs_plan';

  function getDtTable(myvar1 = '') {
    //akalin uri segment ci biar terima parameter kosong di sql
    /* $('#txtCari1').val().length > 0 ? param1 = $('#txtCari1').val() : param1 = "_BLANK_";
    $('#txtCari2').val().length > 0 ? param2 = $('#txtCari2').val() : param2 = "_BLANK_";
    $('#txtCari3').val().length > 0 ? param3 = $('#txtCari3').val() : param3 = "_BLANK_"; */

    myvar1.length > 0 ? param1 = myvar1 : param1 = "_BLANK_";

    param1 = param1.substring(0, 6); //20220830
    param1 = param1.replace(' ', '');

    dataUrl1 = '<?php echo base_url(); ?>index.php/unpackingpxpdata/get_match_unmatch_actual_vs_plan';
    dataUrl = dataUrl1 + "/" + param1; // + "/" + param2 + "/" + param3;
    dtTable.ajax.url(dataUrl).load();
  }


  $(function() {
    dtTable = $('#tabel1').DataTable({
      "columnDefs": [
        // Hide second, third and fourth columns
        /* {
          "visible": false,
          "targets": [7, 8]
        } */
      ],
      "processing": true,
      "autoWidth": false,
      "responsive": false,
      "bLengthChange": true,
      "lengthMenu": [
        [25, 50, -1],
        [25, 50, "All"]
      ],

      "scrollCollapse": true,
      "scrollY": "250px",
      /* scrollY: '70vh', */
      "paging": true,
      processing: true,
      serverSide: false,
      autoWidth: false,
      ajax: {
        url: dataUrl,
      },
      columns: [{
          data: 'DT_RowIndex',
          'className': 'text-center',
          searchable: false,
          sortable: false
        }, {
          data: 'caseno',
          'className': 'text-center'
        },
        {
          data: 'partno',
          'className': 'text-center'
        },
        {
          data: 'partname',
          'className': 'text-left'
        },
        {
          data: 'qty_plan',
          'className': 'text-right'
        },
        {
          data: 'qty_actual',
          'className': 'text-right'
        },
        {
          data: 'state',
          'className': 'text-center'
        },
      ]
    });
  });


  function play_audio_error() {
    var audio = document.getElementById("audio_error");
    audio.play();
  }

  function play_audio_sukses() {
    var audio = document.getElementById("audio_sukses");
    audio.play();
  }

  function play_audio_sukses1() {
    var audio = document.getElementById("audio_sukses1");
    audio.play();
  }


  $('#scanCaseMarkTmp').keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
      //alert('You pressed a "enter" key in textbox scanLabelMarkTmp');      

      if ($('#scanCaseMarkTmp').val().length > 0) {
        fun_scanCaseMark();
      }

      //$('#scanCaseMarkTmp').val("");
      document.getElementById('scanCaseMarkTmp').focus();
    }
  });


  $('#scanLabelMarkTmp').keypress(function fun_scanLabelMarkTmp(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
      if ($('#scanLabelMarkTmp').val().length > 0) {
        fun_scanLabelMark();
      }
      document.getElementById('scanLabelMarkTmp').focus();
    }
  });


  function fun_cek_status_caseno_partno() {
    //console.log('exec fun_cek_status_caseno_partno');

    var slmCaseType = $('#slmCaseType').val();
    var slmCaseNo = $('#slmCaseNo').val();
    var slmPartNo = $('#slmPartNo').val();
    var slmQty = $('#slmQty').val();

    //if (parseInt($('#actualBox').val()) == parseInt($('#planBox').val())) {
    //set status di transaksi complete scanLabelMark
    //insert data ke tabel TABLE MACHINING_FINISH_CASE (HISTORY FINISH CASE)
    //$('#statusCase').val("Complete Case");
    //$('#statusPart').val("Complete Part");

    //fun_save_finishcasxe(slmCaseType, slmCaseNo, slmPartNo);
    //set table unpacking by current caseNo Complete Case


    if (parseInt($('#planBox').val()) !== parseInt($('#actualBox').val())) {
      //cek partno dan case no di tabel machining_shipping_plan apakah ada ?
      id = slmCaseNo + slmPartNo;
      url = '<?php echo base_url(); ?>index.php/Unpackingpxp/cek_partnocaseno/' + id;
      $.get(url)
        .done((response) => {
          datajson = JSON.parse(response); //convert text into a JavaScript object:
          if (datajson.status == "no_record_found") {

            $('#statusInfo').val("Data Not Found");
            $('#statusInfo').css({
              "background-color": "red",
              "color": "white"
            });
            play_audio_error();
            $('#statusInfo').css({
              "background-color": "red",
              "color": "white"
            });
          } else {

            fun_savedata1(slmCaseNo, slmPartNo, slmQty); //save data

            /* $('#statusCase').val("In Progress");
            $('#statusInfo').val("Data Not Found");
            play_audio_error();
            $('#statusInfo').css({
              "background-color": "red",
              "color": "white"
            }); */

          }
        })
        .fail((errors) => {
          alert('Tidak dapat menampilkan data\n' + url);
          return;
        });
    } else {

      $('#statusInfo').val('Case Not Founds');
      $('#statusInfo').css({
        "background-color": "red",
        "color": "black"
      });
      play_audio_error();
    }

    get_actualboxbycaseno(slmCaseNo);
  }


  function fun_scanCaseMark() {
    var scanCaseMark = $('#scanCaseMarkTmp').val();
    scanCaseMark = scanCaseMark.toUpperCase();

    fun_clear_form();

    if (scanCaseMark.indexOf("TY") > 0 && scanCaseMark.length === 23) {
      scanCaseMark = scanCaseMark.replaceAll(' ', '');
      var scmCaseType = "TY";
      var scmCaseNo = scanCaseMark.substr(scanCaseMark.length - 6, 6);

    } else if (scanCaseMark.length === 22) { //sebelumnya 22
      //alert('TY');
      var scmCaseType = "TY";
      var scmCaseNo = scanCaseMark.substr(10, 6);

    } else if (scanCaseMark.indexOf("TY") > 0) {
      var scmCaseType = "TY";
      var scmCaseNo = scanCaseMark.substr(6);

    } else if (scanCaseMark.length === 12) {
      //alert('not TY');
      var scmCaseType = scanCaseMark.substr(6, 2);
      var scmCaseNo = scanCaseMark.substr(6, 5);

    } else {
      $('#statusInfo').val("Wrong QRCode");
      $('#statusInfo').css({
        "background-color": "red",
        "color": "white"
      });
      play_audio_error();
      $('#scanCaseMarkTmp').val("");
      $('#statusCase').val("");
      $('#scmCaseNo').val("");
      $('#scmCaseType').val("");
      return false;
    }

    scmCaseNo = scmCaseNo.replace(' ', '');

    $('#scmCaseNo').val(scmCaseNo);
    $('#scmCaseType').val(scmCaseType);
    $('#scanCaseMarkTmp').val(""); //kosongkan kolom input field scan

    //jika caseNo tsb tidak ada di TABLE MACHINING_FINISH_CASE
    // maka statusInfo = Unpacking
    //jika ada maka ambil status caseNo tsb dari TABLE MACHINING_FINISH_CASE
    id = scmCaseNo;
    var lanjut = false;
    lanjut = fun_is_caseno_complete(scmCaseNo); //apakah caseNo sudah complete
    console.log("lanjut ? " + lanjut);
    if (lanjut) {
      //alert('lanjut');
      $('#statusCase').val("Ready Unpackings");
      $('#statusInfo').val("Scan HML Label");
      $('#statusInfo').css({
        "background-color": "green",
        "color": "white"
      });
      document.getElementById('scanLabelMarkTmp').focus();
    } else {
      //alert('tidak lanjut');
      return false;
    }
  }


  function fun_is_caseno_complete(scmCaseNo) {
    console.log('fun_is_caseno_complete caseNo=' + scmCaseNo);
    var lanjutkan = false;
    id = scmCaseNo;
    url = '<?php echo base_url(); ?>index.php/Unpackingpxp/fun_is_caseno_complete/' + id;
    console.log(url);
    $.get(url)
      .done((response) => {
        datajson = JSON.parse(response); //convert text into a JavaScript object:

        if (parseInt(datajson.sts) == 1) { //caseNo sudah complete found
          lanjutkan = false;
          //fun_clear_form();
          $('#statusCase').val("Case Complete");
          /* setTimeout(function() {
            $('#statusCase').val("Progress");
          }, 6000); */

          $('#statusInfo').val("CASE COMPLETE");
          $('#statusPart').val("Complete Part");
          document.getElementById('scanCaseMarkTmp').focus();
          play_audio_sukses();
          return false;

        } else if (parseInt(datajson.sts) == 2) { //caseNo yg status nya waiting di shipping plan tidak ada
          lanjutkan = false;
          fun_clear_form();
          $('#statusInfo').val("Case Not Found");
          play_audio_error();
          $('#statusInfo').css({
            "background-color": "red",
            "color": "white"
          });
          document.getElementById('scanCaseMarkTmp').focus();
          return false;

        } else {
          lanjutkan = true;

          //getDtTable(scmCaseNo);
          //get_total_scan(scmCaseNo, '');
          getDtTable(document.getElementById('scmCaseNo').value);
          get_total_scan(document.getElementById('scmCaseNo').value, '');

          //fun_clear_form();
          $('#statusInfo').val("Scan HML Labels");
          $('#statusCase').val("Ready Unpacking");
          $('#statusInfo').css({
            "background-color": "green",
            "color": "white"
          });
          document.getElementById('scanLabelMarkTmp').focus();

          getDtTable(document.getElementById('scmCaseNo').value);
        }

        return lanjutkan;
      })
      .fail((errors) => {
        alert('Tidak dapat menampilkan data\n' + url);
        return;
      });

  }


  function fun_scanLabelMark() {

    var id;
    var scanLabelMark = $('#scanLabelMarkTmp').val();

    //console.log($('#scanLabelMarkTmp').val() + 'STOP');

    $('#scanLabelMark').val(scanLabelMark);
    var scanLabelMark = scanLabelMark.toUpperCase();
    var slmCaseType = scanLabelMark.substr(10, 2);
    var slmCaseNo = scanLabelMark.substr(10, 5);
    var slmPartNo = scanLabelMark.substr(15, 10);
    var slmQty = Math.round(scanLabelMark.substr(25, 7));

    if ($('#scmCaseType').val() == 'TY') {
      //alert('TY');
      if (parseInt(scanLabelMark.length) == 100) {

        slmCaseNo = scanLabelMark.substr(4, 6); //20220825
        slmQty = Math.round(scanLabelMark.substr(26, 6)); //20220825
        slmPartNo = scanLabelMark.substr(15, 10); //20220825

      } else {
        slmCaseNo = scanLabelMark.substr(4, 6); //20220824
        slmQty = Math.round(scanLabelMark.substr(22, 6)); //20220824
        slmPartNo = scanLabelMark.substr(12, 10); //20220824
      }

      /* console.log('qty ' + slmQty);
      console.log('caseno ' + slmCaseNo);
      console.log('partno ' + slmPartNo);
      console.log('return false'); */
      //return false;
    }
    slmCaseNo = slmCaseNo.replace(' ', ''); //20220830

    $('#scanLabelMarkTmp').val("");

    if ($('#scmCaseNo').val().length < 1) {
      play_audio_error();
      $('#statusInfo').val('Scan case mark first');
      $('#statusInfo').css({
        "background-color": "red",
        "color": "white"
      });
      document.getElementById('scanCaseMarkTmp').focus();
      document.querySelector('#scanCaseMarkTmp').focus();

      $('#scanCaseMarkTmp').focus();
      return false;

    } else if (slmCaseNo != $('#scmCaseNo').val().replace(" ", "")) {
      /* console.log(slmCaseNo + "<=>" + $('#scmCaseNo').val()); */

      //alert(slmCaseNo + ' ' + $('#scmCaseNo').val());

      document.getElementById('scanLabelMarkTmp').focus();
      $('#statusInfo').val('Case No Tidak Sama');
      play_audio_error();
      $('#statusInfo').css({
        "background-color": "red",
        "color": "white"
      });
      return false;

    } else if ($('#statusCase').val() == 'Case Complete') {
      play_audio_sukses();

      document.getElementById('scanCaseMarkTmp').focus();
      return false;
    }

    //var planBox = 0;
    //var actualBox = 0;
    var slmPartName = "";

    $('#slmCaseType').val(slmCaseType);
    $('#slmCaseNo').val(slmCaseNo);
    $('#slmPartNo').val(slmPartNo);
    $('#slmQty').val(slmQty);

    $('#scanLabelMarkTmp').val(""); //kosongkan kolom input field scan


    var partNo1 = $('#slmPartNo').val();

    if ($('#slmCaseNo').val() !== $('#scmCaseNo').val()) {
      $('#statusInfo').val("Case No Tidak Sama");
      play_audio_error();
      $('#statusInfo').css({
        "background-color": "white",
        "color": "black"
      });
      $('#scanLabelMarkTmp').focus();
      document.getElementById('scanCaseMarkTmp').focus();
      return false;
    }

    get_actualboxbycaseno(slmCaseNo); //isi $('#planBox') ambil data terkahir
    get_planboxbycaseno(slmCaseNo); //isi $('#actualBox')

    var actualBox = $('#actualBox').val();
    var planBox = $('#planBox').val();

    //jika status part sudah sama dengan plan/ Complete Part
    /* if ($("#statusPart").val() == "Complete Part") {
      play_audio_error();
      $('#statusInfo').val("Complete Part, scan another part !");
      $('#statusInfo').css({
        "background-color": "red",
        "color": "white"
      });
      document.getElementById('scanLabelMark').focus();
      return false;
    } */
    varr = fun_get_qtyplanbox_actualbox_bycasenopartno(slmCaseNo, slmPartNo);
    datajson1 = JSON.parse(varr);
    if (parseInt(datajson1.qty_actual_casenopartno) == parseInt(datajson1.qty_plan_casenopartno)) {

      $('#actualBox').val(datajson1.qty_actual_casenopartno); //20220824
      //getDtTable(scmCaseNo); //20220824

      play_audio_error();
      $('#statusInfo').val("Complete Part, scan another part !");
      $('#statusInfo').css({
        "background-color": "red",
        "color": "white"
      });
      getDtTable(document.getElementById('scmCaseNo').value); //20220913
      document.getElementById('scanLabelMark').focus();
      return false;
    }

    //sebelum save ke data base
    //jika qty actual dari db + qty yang sedang di scan melebihi qty plan
    //maka hentikan proses dan info user    
    if ((parseInt($('#actualBox').val()) + parseInt(slmQty)) > parseInt($('#planBox').val())) {
      $('#statusInfo').val("Qty Actual melebihi Qty Plan");
      document.getElementById('scanLabelMark').focus();
      play_audio_error();
      return false;
    }

    fun_cek_status_caseno_partno(); //cek status case dan save data

  } //eof fun_scanLabelMark

  //per part
  function fun_get_qtyplanbox_actualbox_bycasenopartno(caseno, partno) {
    var nilai;
    var key1 = "nama";
    var key2 = "alamat";
    mydata = '{key1: "' + key1 + '", key2: "' + key2 + '" }';
    id = caseno + partno;
    url = '<?php echo base_url(); ?>index.php/Unpackingpxp/get_qtyplanbox_actualbox_bycasenopartno/' + id;
    $.ajax({
        async: false,
        type: "GET",
        url: url,
        data: mydata,
        contentType: "application/json; charset=utf-8",
        dataType: "json"
      })
      .done(function(response) {
        //nilai = ' funk ' + param1 + ' ' + response.negara;
        nilai = JSON.stringify(response);
        //alert(response + '\n' + datajson);
      })
      .fail(function(errors) {
        alert("error " + url);
      });
    return nilai;
  }

  function fun_get_slm_status_part(caseno, partno) {
    id = caseno + partno;
    url = '<?php echo base_url(); ?>index.php/Unpackingpxp/get_qtyplanbox_actualbox_bycasenopartno/' + id;
    $.get(url)
      .done((response) => {
        //alert(response); //response = text        
        datajson = JSON.parse(response);
        qty_actual_casenopartno = datajson.qty_actual_casenopartno;
        qty_plan_casenopartno = datajson.qty_plan_casenopartno;
        if (qty_actual_casenopartno == qty_plan_casenopartno) {
          $("#statusPart").val("Complete Part");
        } else {
          $("#statusPart").val("Progress");
        }

      })
      .fail((errors) => {
        alert('Tidak dapat menampilkan data\n' + url);
        return;
      });
  }


  function get_qtysafetyendstock(partno) {
    //get data qty safety stock dan qty endStock
    id = partno;
    url = '<?php echo base_url(); ?>index.php/Unpackingpxp/get_qtysafetyendstock/' + id;
    $.get(url)
      .done((response) => {
        datajson = JSON.parse(response); //convert text into a JavaScript object:

        //qtyEndStock = datajson.qty_endstock; //baca table machining stock data
        qtyEndStock = datajson.qty_endstock == null ? 0 : datajson.qty_endstock;

        qtySafetyStock = datajson.qty_safety_stock; //baca table machining master part
        $('#slmPartName').val(datajson.part_name);
        $('#mstRackAddress').val(datajson.part_address_oln);
        $('#mstHamidasi').val(datajson.hamidasi_address);
        $('#qtyEndStock').val(qtyEndStock);

        if (parseInt(qtyEndStock) < parseInt(qtySafetyStock)) { // maka supply ke hamidasi else rack
          $('#supplyRack').css({
            "background-color": "green",
            "color": "white"
          }); //set bg hijau text putih
          $('#supplyHamidasi').css({
            "background-color": "black",
            "color": "grey"
          }); //set bg hitam text gray
        } else {
          $('#supplyHamidasi').css({
            "background-color": "green",
            "color": "white"
          }); //set bg hijau text putih
          $('#supplyRack').css({
            "background-color": "black",
            "color": "grey"
          }); //set bg hitam text gray
        }
      })
      .fail((errors) => {
        alert('Tidak dapat menampilkan data\n' + url);
        return;
      });
  }


  function fun_savedata1(slmCaseNo, slmPartNo, slmQty) {
    // alert('exec fun_savedata1');
    if (slmCaseNo == $('#scmCaseNo').val()) {
      //set tambah stock ke tabel machining stock data
      //status info data saved/ success
      //generate keycode //barcodeLabelOLN = slmPartNo+slmQty+'L'+yymmddxxxxx+slmCaseNo
      //save transaksi
      //cetak label ke printer

      var scanLabelMark = $("#scanLabelMark").val();
      dataString = "caseno=" + slmCaseNo + "&partno=" + slmPartNo + "&qty=" + slmQty + "&scanLabelMark=" + scanLabelMark;
      url = '<?php echo base_url(); ?>index.php/Unpackingpxp/fun_savedata1';
      $.get(url, dataString)
        .done((response) => {
          datajson = JSON.parse(response);

          if (datajson.state == "duplikat") {
            $("#statusInfo").val("Complete Part");
            $('#statusInfo').css({
              "background-color": "green",
              "color": "white"
            });
            $("statusPart").val("Complete Part");
            play_audio_error();
            return false;

          } else if (parseInt(datajson.sts) == 1) { //if true
            keyCode = datajson.keyCode;
            isSpecialPart = datajson.is_special_part;


            $("#statusInfo").val("DATA SAVED");
            $('#statusInfo').css({
              "background-color": "green",
              "color": "white"
            });


            fun_get_slm_status_part(slmCaseNo, slmPartNo);
            play_audio_sukses();

            if (datajson.is_special_part == "yes") {
              $("#slmKeyCode").val("Special Part");
              fun_print_labelSP(isSpecialPart, slmPartNo, slmCaseNo);
            } else {
              $("#slmKeyCode").val(keyCode);
              fun_print_label(keyCode, slmPartNo, slmCaseNo);
            }


            get_total_scan(slmCaseNo, slmPartNo);
            get_qtysafetyendstock(slmPartNo);
            get_actualboxbycaseno(slmCaseNo);

            //jika qty plan dan actual sudah sama maka save ke tabel history
            var vActualBox = document.getElementById("actualBox").value;
            var vPlanBox = document.getElementById("planBox").value;
            var vSlmQty = document.getElementById("slmQty").value;
            var vSlmCaseType = document.getElementById("slmCaseType").value;

            vActualBox = parseInt(vActualBox) + parseInt(vSlmQty);
            //console.log(vActualBox + " <-act plan-> " + vPlanBox);

            if (parseInt(vActualBox) == parseInt(vPlanBox)) {
              console.log('exec fun_save_finishcase');
              fun_save_finishcase(vSlmCaseType, slmCaseNo, slmPartNo);

              //fungsi get_actualboxbycaseno itu ambil yg status nya finish scan
              //jika sudah complete case maka status nya berubah menjadi complete case
              //so hasil dari get_actualboxbycaseno menjadi 0 nol
              //karena status nya complete case maka agar cepat untuk view ke user qty actualBox ambil/ = qty planBox          
              document.getElementById('actualBox').value = $('#planBox').val();
              //alert($('#planBox').val());

              document.getElementById('scanCaseMarkTmp').focus();
            } else {
              document.getElementById('scanLabelMarkTmp').focus();
            }

            getDtTable(slmCaseNo); //reload data table

            setTimeout(function() {
              $("#statusInfo").val("Waiting for Scanner");
              $('#statusInfo').css({
                "background-color": "yellow",
                "color": "black"
              });
            }, 8000);

          } else {
            alert("fun_savedata1 insert data gagal" + "\n" + url);
            return false;
          }
        })
        .fail((errors, xhr, textStatus, response) => {
          alert('Tidak dapat menyimpan data\n' + errors + '\n' + url);
          /* alert(xhr);
          alert(textStatus);
          alert(response); */
          //return;
        });
    }
  } //eof fun_savedata1


  function fun_print_label(keyCode, partno1, caseno) {
    myvar = new Date();
    windowName = myvar.getMinutes() + '' + myvar.getSeconds();

    url = '<?php echo base_url(); ?>index.php/Unpackingpxp/print_label/' + keyCode + '/' + partno1 + '/' + caseno;
    const windowFeatures = "left=900, top=900, width=320, height=240";
    const handle = window.open(url, windowName, "_blank", windowFeatures);
    if (!handle) {
      alert("The window wasn't allowed to open\nThis is likely caused by built-in popup blockers.");
    }
  }

  function fun_print_labelSP(isSpecialPart, partno1, caseno) {
    myvar = new Date();
    windowName = myvar.getMinutes() + '' + myvar.getSeconds();

    url = '<?php echo base_url(); ?>index.php/Unpackingpxp/print_label_spesial_part/' + partno1 + '/' + caseno;
    const windowFeatures = "left=900, top=900, width=320, height=240";
    const handle = window.open(url, windowName, "_blank", windowFeatures);
    if (!handle) {
      alert("The window wasn't allowed to open\nThis is likely caused by built-in popup blockers.");
    }
  }


  function get_total_scan(caseno, partno) {
    caseno = caseno.substring(0, 6); //20220830
    caseno = caseno.replace(' ', '');
    id = caseno; // + partno;
    url = '<?php echo base_url(); ?>index.php/Unpackingpxp/get_total_scan/' + id;
    $.get(url)
      .done((response) => {
        //alert(response); //response = text        
        datajson = JSON.parse(response);
        total_scan = datajson.total_scan;
        //$("#totalScan").val(total_scan);
        document.getElementById("totalScan").value = total_scan;
        //$("#totalScanSpan").text(total_scan);
        document.getElementById("totalScanSpan").innerHTML = total_scan;
      })
      .fail((errors) => {
        alert('Tidak dapat menampilkan data\n' + url);
        return;
      });
  }


  function fun_save_finishcase(slmCaseType, slmCaseNo, slmPartNo) {
    dataString = "caseno=" + slmCaseNo + "&partno=" + slmPartNo + "&caseType=" + slmCaseType;
    url = '<?php echo base_url(); ?>index.php/Unpackingpxp/fun_save_finishcase';
    //console.log("dataString = " + dataString);
    //console.log("url = " + url);
    $.get(url, dataString)
      .done((response) => {
        //document.location.reload();
        datajson = JSON.parse(response);
        if (datajson.sts) { //if true (insert sukses)
          //keyCode = datajson.keyCode;

          $("#statusCase").val("Complete Case");
          $("#statusPart").val("Complete Part");
          $('#statusInfo').val('Scan New Case Mark');
          $('#statusInfo').css({
            "background-color": "green",
            "color": "white"
          });

          //fun_clear_form();          

          //get_total_scan(slmCaseNo, slmPartNo);
          //get_qtysafetyendstock(slmPartNo);
          //fun_print_label(keyCode, slmPartNo, slmCaseNo);

        } else {
          alert("fun_save_finishcase insert data gagal " + url);
        }
      })
      .fail((errors, xhr, textStatus, response) => {
        alert('Tidak dapat menyimpan data\n' + errors + '\n' + url);
        //alert(xhr);
        //alert(textStatus);
        //alert(response);
        return false;
      });
  }


  function fun_clear_form() {
    $('#scanCaseMarkTmp').val('');
    $('#scanLabelMarkTmp').val('');
    $('#scmCaseNo').val('');
    $('#scmCaseType').val('');
    $('#statusInfo').val('Status Information');
    $('#statusInfo').css({
      "background-color": "green",
      "color": "white"
    });
    $('#statusCase').val('');
    $('#statusPart').val('');
    $('#mstRackAddress').val('');
    $('#mstHamidasi').val('');
    $('#totalScan').val(0);
    $('#planBox').val('');
    $('#actualBox').val('');
    $('#slmCaseNo').val('');
    $('#slmCaseType').val('');
    $('#slmPartNo').val('');
    $('#slmPartName').val('');
    $('#slmQty').val('');
    $('#slmKeyCode').val('');
    $('#qtyEndStock').val(0);

    $('#supplyRack').css({
      "background-color": "",
      "color": "black"
    });
    $('#supplyHamidasi').css({
      "background-color": "",
      "color": "black"
    });
    document.getElementById('scanCaseMarkTmp').focus();
  }


  function get_planboxbycaseno(id) {
    var hasil;
    url = '<?php echo base_url(); ?>index.php/Unpackingpxp/get_planboxbycaseno/' + id;
    console.log(url);
    $.get(url)
      .done((response) => {
        $("#planBox").val(response);
        hasil = response;
      })
      .fail((errors) => {
        alert('Tidak dapat menampilkan data\n' + url);
        return false;
      });
    return hasil;
  }


  function get_actualboxbycaseno(id) {
    var hasil;
    url = '<?php echo base_url(); ?>index.php/Unpackingpxp/get_actualboxbycaseno/' + id;
    $.get(url)
      .done((response) => {
        $("#actualBox").val(response);
        hasil = response;
      })
      .fail((errors) => {
        alert('Tidak dapat menampilkan data\n' + url);
        return false;
      });
    return hasil;
  }


  function fun_modalFrmCaseMark() {
    $('#modalFormRowActive').css('display', 'none');

    $('#modalFrmCaseMark').modal('show');
    //$('#scmmCaseNo').focus();
    //document.getElementById('scmmCaseNo').focus();
    $('#modalFrmCaseMark [name=scmmCaseNo]').val('');
    //$('#modalFrmCaseMark [name=scmmCaseNo]').focus();

    $('#modalFrmCaseMark [name=modalFormRowActive]').val('caseMark');

    $('#modalFrmCaseMark .modal-title').text('Case Mark Manual Input');

    //inisialisasi isi varabel palsu biar bisa submit form      
    /* $('#modalFrmCaseMark [name=slmmCaseNo]').prop('required', false);
    $('#modalFrmCaseMark [name=slmmPartNo]').prop('required', false);
    $('#modalFrmCaseMark [name=slmmQty]').prop('required', false); */

    $('#modalFrmCaseMark [name=slmmCaseNo]').val('xyz');
    $('#modalFrmCaseMark [name=slmmPartNo]').val('xyz');
    $('#modalFrmCaseMark [name=slmmQty]').val('0');

    //$('#modalFrmCaseMark [name=scmmCaseNo]').prop('required', true);

    $('#row_modalFrmCaseMark').css('display', '');
    $('#row_modalFrmLabelMark').css('display', 'none');
  }


  function fun_modalFrmCaseMarkSubmit() {
    let modalFormRowActive = $('#modalFrmCaseMark [name=modalFormRowActive]').val();
    var txtQR;
    var txtQty1;

    if (modalFormRowActive == "caseMark") {

      isTY = $('#modalFrmCaseMark [name=scmmCaseNo]').val().substring(1, 2);
      isTY = isTY.toUpperCase();

      if (isTY !== "TY") { //jika bukan TY
        txtQR = $('#modalFrmCaseMark [name=scmmYearMonth]').val() + "" + $('#modalFrmCaseMark [name=scmmCaseNo]').val() + " ";
        $('#scanCaseMarkTmp').val(txtQR);

      } else { //jika TY
        txtQR = "1234567890" + $('#modalFrmCaseMark [name=scmmYearMonth]').val() + "" + $('#modalFrmCaseMark [name=scmmCaseNo]').val() + " ";
        $('#scanCaseMarkTmp').val(txtQR);
      }

      console.log("len CaseMark => " + txtQR.length);
      console.log("CaseMark => " + txtQR);
      $('#modalFrmCaseMark').modal('hide');

      //send key enter to scanCaseMarkTmp
      var input = document.querySelector("#scanCaseMarkTmp");
      var ev = document.createEvent('Event');
      ev.initEvent('keypress');
      ev.which = ev.keyCode = 13;
      input.dispatchEvent(ev);

    } else { //labelMark

      isTY = $('#scmCaseType').val();
      isTY = isTY.toUpperCase();

      if (isTY !== "TY") { //jika bukan TY
        //panjang qty 7 digit include angka nol di depan
        txtQty = parseInt($('#modalFrmCaseMark [name=slmmQty]').val());
        txtQty1 = fun_addLeadingZeros(txtQty, 7);
        txtQR = '807a      ' + $('#modalFrmCaseMark [name=slmmCaseNo]').val() + $('#modalFrmCaseMark [name=slmmPartNo]').val() + txtQty1 + 'm01-01-001kp5495600120220414dc04-03                                 ';
      } else {
        txtQty = parseInt($('#modalFrmCaseMark [name=slmmQty]').val());
        txtQty1 = fun_addLeadingZeros(txtQty, 6);
        txtQR = '807Y' + $('#modalFrmCaseMark [name=slmmCaseNo]').val() + 'TY' + $('#modalFrmCaseMark [name=slmmPartNo]').val() + txtQty1 + '6XXXXXXXXXX        ';
        //console.log('TY BOSSS');
      }
      $('#scanLabelMarkTmp').val(txtQR);

      //console.log("len LabelMark => " + txtQR.length);


      $('#modalFrmCaseMark').modal('hide');

      //send key enter to scanLabelMarkTmp
      var input = document.querySelector("#scanLabelMarkTmp");
      var ev = document.createEvent('Event');
      ev.initEvent('keypress');
      ev.which = ev.keyCode = 13;
      input.dispatchEvent(ev);
    }

  }


  function fun_modalFrmLabelMark() {
    $('#modalFormRowActive').css('display', 'none');

    $('#modalFrmCaseMark').modal('show');

    var scmCaseNox = $('#scmCaseNo').val();
    $('#modalFrmCaseMark [name=slmmCaseNo]').val(scmCaseNox);
    $('#modalFrmCaseMark [name=slmmPartNo]').val('');
    $('#modalFrmCaseMark [name=slmmQty]').val('');

    $('#modalFrmCaseMark [name=modalFormRowActive]').val('LabelMark');

    $('#modalFrmCaseMark .modal-title').text('Label Mark Manual Input');

    //inisialisasi isi varabel palsu biar bisa submit form
    //$('#modalFrmCaseMark [name=scmmCaseNo]').prop('required', false);
    $('#modalFrmCaseMark [name=scmmCaseNo]').val('xyz');

    /* $('#modalFrmCaseMark [name=slmmCaseNo]').prop('required', true);
    $('#modalFrmCaseMark [name=slmmPartNo]').prop('required', true);
    $('#modalFrmCaseMark [name=slmmQty]').prop('required', true); */

    $('#row_modalFrmCaseMark').css('display', 'none');
    $('#row_modalFrmLabelMark').css('display', '');

    //$('#modalFrmLabelMark').modal('show');
    /* $('#modalFrmLabelMark').modal({
      show: true,
      modal: true,
      height: 200
    }); */

    //$('#modal-form .modal-title').text('Add ' + vJudulForm);

    //$('#modal-form form')[0].reset();    
  }


  $('#modalFrmCaseMark').validator().on('submit', function(e) {
    if (!e.preventDefault()) {
      fun_modalFrmCaseMarkSubmit();
    }
  });


  function fun_addLeadingZeros(num, totalLength) {
    return String(num).padStart(totalLength, '0');
  }
</script>