<?php //echo md5('oln'); 
?>

<section class="content">

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><span id="vJudulForm1"><b>UNPACKING PxP HML MACHINING</b></span></h3>
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
          <form name="frm1" id="frm1" method="" action="">
            <audio style="display:none;" id="audio_error" src="<?php echo base_url(); ?>assets/audio/good-6081.mp3" controls="" controlslist="nodownload"></audio>
            <audio style="display:none;" id="audio_sukses" src="<?php echo base_url(); ?>assets/audio/dad-says-ok-1-113120.mp3" controls="" controlslist="nodownload"></audio>

            <div class="row">
              <div class="col-lg-8">
                <div class="row" style="">
                  <div class="col-lg-4">
                    <label class="col-form-label">Scan Case Mark</label>
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
                        <label class="col-form-label">Scan Label Mark</label>
                        <div class="input-group">
                          <input id="scanLabelMarkTmp" name="scanLabelMarkTmp" placeholder="Scan Label HML" type="text" class="form-control form-control-lg" autocomplete="off">
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
                          <input id="statusCase" name="statusCase" placeholder="" type="text" class="form-control form-control-lg" readonly style="margin-bottom: 4px; font-weight:bold;">
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
                          <input id="statusPart" name="statusPart" placeholder="" type="text" class="form-control form-control-lg" readonly style="margin-bottom: 4px;">
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
                          <input title="Get from Table Master" id="mstRackAddress" name="mstRackAddress" placeholder="" type="text" class="form-control form-control-lg" readonly style="margin-bottom: 4px;">
                        </div>
                      </div>
                    </div>
                    <div class="row">
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
                          <input id="supplyRack" name="supplyRack" placeholder="Rack" type="text" class="form-control form-control-lg" readonly title="IF safetyStock < endStock">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="input-group">
                          <input id="supplyHamidasi" name="supplyHamidasi" placeholder="Hamidasi" type="text" class="form-control form-control-lg" readonly title="IF safetyStock > endStock">
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
                      <input id="statusInfo" name="statusInfo" placeholder="Status Information" type="text" class="form-control form-control-lg" readonly style="background-color: yellow; color:black; text-align:center; font-size: 70px; height:80px;">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12">
                    <label class="col-form-label">Total Scan</label>
                    <div class="input-group">
                      <input id="totalScan" name="totalScan" placeholder="" type="text" class="form-control form-control-lg" readonly style="font-weight: bold; font-size: 70px; height:80px; text-align:center;" value="0">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div align="center"><label class="col-form-label">Plan (Pcs)</label></div>
                    <div class="input-group">
                      <input id="planBox" name="planBox" placeholder="" type="text" class="form-control form-control-lg" style="font-weight: bold; font-size: 60px; height:70px; text-align:center;" readonly>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div align="center"><label class="col-form-label">Actual (Pcs)</label></div>

                    <input id="actualBox" name="actualBox" placeholder="" type="text" class="form-control form-control-lg" style="font-weight: bold; font-size: 60px; height:70px; text-align:center;" readonly>

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
                  <input id="slmCaseNo" name="slmCaseNo" placeholder="" type="text" class="form-control form-control-lg" readonly>
                </div>
              </div>
              <div class="col-lg-1">
                <div align="center"><label class="col-form-label">Case Type</label></div>
                <div class="input-group">
                  <input id="slmCaseType" name="slmCaseType" placeholder="" type="text" class="form-control form-control-lg" readonly>
                </div>
              </div>
              <div class="col-lg-2">
                <div align="center"><label class="col-form-label">Part No</label></div>
                <div class="input-group">
                  <input id="slmPartNo" name="slmPartNo" placeholder="" type="text" class="form-control form-control-lg" readonly>
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
                  <input id="slmQty" name="slmQty" placeholder="" type="text" class="form-control form-control-lg" readonly>
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
                <?php if ($this->session->userdata('isgenba') <> 'y') { ?>
                  <a href="<?php echo base_url(); ?>index.php/unpackingpxp/uploadshipmentplan" class="btn btn-primary btn-lg"><i class="fa fa-upload"></i> Upload Shipment Plan</a>&nbsp;
                <?php } ?>
                <a href="<?php echo base_url(); ?>index.php/unpackingpxp/view_finishcase" class="btn btn-primary btn-lg">View Finish Case MCH</a>&nbsp;

                <a href="<?php echo base_url(); ?>index.php/unpackingpxp/view_stockmch" class="btn btn-primary btn-lg">View Stock MCH</a>&nbsp;

                <a href="<?php echo base_url(); ?>index.php/unpackingpxp/view_proggress_unpacking" class="btn btn-primary btn-lg">View Progress Unpacking</a>&nbsp;

                <a href="<?php echo base_url(); ?>index.php/unpackingpxp/view_finish_unpacking" class="btn btn-primary btn-lg">View Finish Unpacking</a>&nbsp;
              </div>
            </div>
          </form>
        </div> <!-- eof main body -->
      </div>

    </div>
  </div>
</section>

<script>
  var url;

  function play_audio_error() {
    var audio = document.getElementById("audio_error");
    audio.play();
  }

  function play_audio_sukses() {
    var audio = document.getElementById("audio_sukses");
    audio.play();
  }

  $('#scanCaseMarkTmp').keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
      //alert('You pressed a "enter" key in textbox scanLabelMarkTmp');      

      if ($('#scanCaseMarkTmp').val().length > 0) {
        fun_scanCaseMark();
      } else {

      }

      //$('#scanCaseMarkTmp').val("");
      document.getElementById('scanCaseMarkTmp').focus();
    }
  });


  $('#scanLabelMarkTmp').keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
      if ($('#scanLabelMarkTmp').val().length > 0) {        
        fun_scanLabelMark();                        
      }      
      document.getElementById('scanLabelMarkTmp').focus();
    }
  });
  
  
function fun_cek_status_caseno_partno() {
    console.log('exec fun_cek_status_caseno_partno');
        
    var slmCaseType = $('#slmCaseType').val();
    var slmCaseNo = $('#slmCaseNo').val();
    var slmPartNo = $('#slmPartNo').val();
    var slmQty = $('#slmQty').val();
    
    //if (parseInt($('#actualBox').val()) == parseInt($('#planBox').val())) {
      //set status di transaksi complete scanLabelMark
      //insert data ke tabel TABLE MACHINING_FINISH_CASE (HISTORY FINISH CASE)
      $('#statusCase').val("Completed Case");
      $('#statusPart').val("Completed Part");
      
      //fun_save_finishcase(slmCaseType, slmCaseNo, slmPartNo);
      //set table unpacking by current caseNo Complete Case
      fun_clear_form();

    if (parseInt($('#planBox').val()) < parseInt($('#actualBox').val())) {
      //cek partno dan case no di tabel machining_shipping_plan apakah ada ?
      id = slmCaseNo + slmPartNo;
      url = '<?php echo base_url(); ?>index.php/Unpackingpxp/cek_partnocaseno/' + id;
      $.get(url)
        .done((response) => {
          datajson = JSON.parse(response); //convert text into a JavaScript object:
          if (datajson.status == "no_record_found") {
            
            $('#statusInfo').val("Data Not Found");
          } else {           
            
            fun_savedata1(slmCaseNo, slmPartNo, slmQty); //save data
            
            $('#statusCase').val("In Progress");
            $('#statusInfo').val("Data Not Found");
            
            get_actualboxbycaseno(slmCaseNo);    
            get_planboxbycaseno(slmCaseNo);
            
            //jika qty plan dan actual sudah sama maka save ke tabel history
            if (parseInt($('#actualBox').val()) == parseInt($('#planBox').val())) {
              fun_save_finishcase(slmCaseType, slmCaseNo, slmPartNo)
            }
            
            fun_get_slm_status_part(slmCaseNo, slmPartNo);
            //$('#statusInfo').val("Finish Scan");
          }
        })
        .fail((errors) => {
          alert('Tidak dapat menampilkan data\n' + url);
          return;
        });
    } else {
      $('#statusInfo').val('Case Not Found');
    }
}

  function fun_scanCaseMark() {
    var scanCaseMark = $('#scanCaseMarkTmp').val();
    scanCaseMark = scanCaseMark.toUpperCase();

    fun_clear_form();

    if (scanCaseMark.length === 12) {
      //alert('not TY');
      var scmCaseType = scanCaseMark.substr(6, 2);
      var scmCaseNo = scanCaseMark.substr(6, 5);

    } else if (scanCaseMark.length === 22) {
      //alert('TY');
      var scmCaseType = scanCaseMark.substr(10, 2);
      var scmCaseNo = scanCaseMark.substr(10, 6);

    } else {
      $('#statusInfo').val("Wrong QRCode");
      $('#scanCaseMarkTmp').val("");
      $('#statusCase').val("");
      $('#scmCaseNo').val("");
      $('#scmCaseType').val("");
      return false;
    }

    $('#scmCaseNo').val(scmCaseNo);
    $('#scmCaseType').val(scmCaseType);

    $('#scanCaseMarkTmp').val(""); //kosongkan kolom input field scan

    //jika caseNo tsb tidak ada di TABLE MACHINING_FINISH_CASE
    // maka statusInfo = Unpacking
    //jika ada maka ambil status caseNo tsb dari TABLE MACHINING_FINISH_CASE
    id = scmCaseNo;
    url = '<?php echo base_url(); ?>index.php/Unpackingpxp/cek_caseno/' + id;
    $.get(url)
      .done((response) => {
        datajson = JSON.parse(response); //convert text into a JavaScript object:
        if (datajson.status == "no_record_found") {
          $('#statusCase').val("Ready Unpacking");
          $('#statusInfo').val("Scan HML Label");
          document.getElementById('scanLabelMarkTmp').focus();
        } else {
          $('#statusCase').val(datajson.status);
          $('#statusInfo').val("Case Complete");
        }
      })
      .fail((errors) => {
        alert('Tidak dapat menampilkan data\n' + url);
        return;
      });

  }


  function fun_scanLabelMark() {
    
    if ($('#scmCaseNo').val().length < 1) {
      play_audio_error();
      $('#statusInfo').val('Scan case mark first');
      document.getElementById('scanCaseMarkTmp').focus();
      $('#scanLabelMarkTmp').val("");
      return false;
    }

    var id;
    var scanLabelMark = $('#scanLabelMarkTmp').val();
    var scanLabelMark = scanLabelMark.toUpperCase();
    var slmCaseType = scanLabelMark.substr(10, 2);
    var slmCaseNo = scanLabelMark.substr(10, 5);
    var slmPartNo = scanLabelMark.substr(15, 10);
    var slmQty = Math.round(scanLabelMark.substr(25, 7));
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
      play_audio_error();
      $('#statusInfo').val("Case No Tidak Sama");
      $('#scanLabelMarkTmp').focus();
      document.getElementById('scanCaseMarkTmp').focus();
      return false;
    }


    //get data qty plan dari table machining shipping plan (upload shipping plan)
    //dan data qty actual dari tabel machining unpacking/ transaksi
    //by caseNo
    //id = slmCaseNo; // + slmPartNo;
    /* url = '<?php echo base_url(); ?>index.php/Unpackingpxp/get_qtyplanbox_actualbox_bycaseno/' + id;
    $.get(url)
      .done((response) => {
        console.log("response11: " + response);
        datajson = JSON.parse(response);
        planBox = datajson.qty_actual;
        actualBox = datajson.qty_actual;
        $('#planBox').val(planBox);
        $('#actualBox').val(actualBox);
      })
      .fail((errors) => {
        alert('Tidak dapat menampilkan data\n' + url);
        return false;
      }); */

    //get data qty plan dari table machining shipping plan (upload shipping plan)
    //dan data qty actual dari tabel machining unpacking/ transaksi
    //by caseNo dan partNo
    //id = slmCaseNo + slmPartNo;
    /* url = '<?php echo base_url(); ?>index.php/Unpackingpxp/get_qtyplanbox_actualbox_bycasenopartno/' + id;
    $.get(url)
      .done((response) => {
        console.log("response act12: " + response);       
        datajson = JSON.parse(response);
        planBox = datajson.qty_actualcp;
        actualBox = datajson.qty_actualcp;
        
      })
      .fail((errors) => {
        alert('Tidak dapat menampilkan data\n' + url);
        return false;
      }); */
    
    //isi $('#planBox')
    get_actualboxbycaseno(slmCaseNo);
    //isi $('#actualBox')
    get_planboxbycaseno(slmCaseNo);
    
    var actualBox = $('#actualBox').val();
    var planBox = $('#planBox').val();
    
    //$('#actualBox').val(actualBox);
    //$('#planBox').val(planBox);
    
    console.log("actualBox xx = " + actualBox);
    console.log("planBox xx = " + planBox);
    //return false;
    
    //sebelum save ke data base
    //jika qty actual dari db + qty yang sedang di scan melebihi qty plan
    //maka hentikan proses dan info user    
    if ((parseInt($('#actualBox').val())+parseInt(slmQty)) > parseInt($('#planBox').val())) {
      $('#statusInfo').val("Qty Actual melebihi Qty Plan");
      return false;
    }
    
    
        fun_cek_status_caseno_partno(); //cek status case dan save data
        

  } //eof fun_scanLabelMark


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
          $("#statusPart").val("Completed");  
        }else{
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
        $('#mstRackAddress').val(datajson.hamidasi_address);
        $('#mstHamidasi').val(datajson.part_address_oln);
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
    //alert('exec fun_savedata1');
    if (slmCaseNo == $('#scmCaseNo').val()) {
      //set tambah stock ke tabel machining stock data
      //status info data saved/ success
      //generate keycode //barcodeLabelOLN = slmPartNo+slmQty+'L'+yymmddxxxxx+slmCaseNo
      //save transaksi
      //cetak label ke printer

      dataString = "caseno=" + slmCaseNo + "&partno=" + slmPartNo + "&qty=" + slmQty;
      url = '<?php echo base_url(); ?>index.php/Unpackingpxp/fun_savedata1';
      $.get(url, dataString)
        .done((response) => {
          datajson = JSON.parse(response);
          //prompt("funk ", datajson.sts); alertprompt
          if (datajson.sts) { //if true
            keyCode = datajson.keyCode;
            $("#slmKeyCode").val(keyCode);
            $("#statusInfo").val("Data Saved");
            //alert("boom");
            get_total_scan(slmCaseNo, slmPartNo);
            get_qtysafetyendstock(slmPartNo);
            get_actualboxbycaseno(slmCaseNo);
            
            play_audio_sukses();
            
            fun_print_label(keyCode, slmPartNo, slmCaseNo);

            $('#statusInfo').val("Finish Scan");
            document.getElementById('scanLabelMarkTmp').focus();

          } else {
            alert("fun_savedata1xxxx insert data gagal" + "\n" + url);            
          }
        })
        .fail((errors, xhr, textStatus, response) => {
          alert('Tidak dapat menyimpan data\n' + errors + '\n' + url);
          //alert(xhr);
          //alert(textStatus);
          //alert(response);
          //return;
        });
    }
  } //eof fun_savedata1

  function fun_print_label(keyCode, partno1, caseno) {
    myvar = new Date();
    windowName = myvar.getMinutes()+''+myvar.getSeconds();

    url = '<?php echo base_url(); ?>index.php/Unpackingpxp/print_label/' + keyCode + '/' + partno1 + '/' + caseno;
    const windowFeatures = "left=900, top=900, width=320, height=240";
    const handle = window.open(url, windowName, "_blank", windowFeatures);
    if (!handle) {
      alert("The window wasn't allowed to open\nThis is likely caused by built-in popup blockers.");
    }
  }


  function get_total_scan(caseno, partno) {
    id = caseno; // + partno;
    url = '<?php echo base_url(); ?>index.php/Unpackingpxp/get_total_scan/' + id;
    $.get(url)
      .done((response) => {
        //alert(response); //response = text        
        datajson = JSON.parse(response);
        total_scan = datajson.total_scan;
        $("#totalScan").val(total_scan);
      })
      .fail((errors) => {
        alert('Tidak dapat menampilkan data\n' + url);
        return;
      });
  }

  function fun_save_finishcase(slmCaseType, slmCaseNo, slmPartNo) {
    dataString = "caseno=" + slmCaseNo + "&partno=" + slmPartNo + "&caseType=" + slmCaseType;
    url = '<?php echo base_url(); ?>index.php/Unpackingpxp/fun_save_finishcase';
    console.log("dataString = " + dataString);
    console.log("url = " + url);
    $.get(url, dataString)
      .done((response) => {
        //document.location.reload();
        datajson = JSON.parse(response);
        if (datajson.sts == "insert_sukses") {
          //keyCode = datajson.keyCode;

          $("#statusInfo").val("Case Completed");

            //get_total_scan(slmCaseNo, slmPartNo);
            //get_qtysafetyendstock(slmPartNo);
            //fun_print_label(keyCode, slmPartNo, slmCaseNo);
            
        } else {
          alert("fun_save_finishcase insert data gagal "+url);
          
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
    $('#statusInfo').val('Scan New Case Mark');
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
</script>