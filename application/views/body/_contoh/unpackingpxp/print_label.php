<?php
$tgl = date("d-m-y");
$vcaseno = $caseno;
$vpartno = $partno;
$part_address_oln = "Unknown"; //rack address
$hamidasi_address = "Unknown";
$part_name = "Unknown";

$sql = "SELECT * from machining_master_part WHERE partno1='$partno'";
//$rs = $this->db->query($sql)->row_array();
//print_r($row);
//$data['id'] = $row["id"];
$rs = $this->db->query($sql);
if ($rs->num_rows() > 0) {
    $row = $this->db->query($sql)->row_array();
    //echo json_encode($row);

    $part_address_oln = $row['part_address_oln']; //rack address
    $hamidasi_address = $row['hamidasi_address'];
    $part_name = $row['part_name'];
} else {
    echo "<h1>Data Not Found</h1>";
}


$label_id = "Unknown";
$sql = "SELECT id from machining_unpacking WHERE keycode='$keycode'";
$rs = $this->db->query($sql);
if ($rs->num_rows() > 0) {
    $row = $this->db->query($sql)->row_array();

    $label_id = $row['id'];
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Unpacking PXP</title>
    <style>
        td {
            font-family: 'Arial';
        }

        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>
</head>

<body>
    <table border="0" style="border-collapse: collapse; border:1px solid black; width:9.6cm; height:4.6cm">
        <tr>
            <td valign="top">
                <table border="0" width="100%" style="height:100%; border-collapse: collapse;">
                    <tr style="border-bottom:1px solid black;">
                        <td align="center"><b>MSP Label</b></td>
                    </tr>
                    <tr style="border-bottom:1px solid black;">
                        <td>
                            <div align="center"><b><?php echo $tgl; ?></b></div>
                        </td>
                    </tr>
                    <tr style="border-bottom:1px solid black;">
                        <td>
                            <div align="center"><b><?php echo $vcaseno; ?></b></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div align="center"><img src="<?php echo base_url(); ?>index.php/qrcodecontroller/qrcode/<?php echo $keycode; ?>" height="90" width="90"><br><span style="font-size:10px;"><?php echo strtoupper($this->session->userdata('username')); ?></span></div>
                        </td>
                    </tr>

                </table>
            </td>
            <td style="border-left:1px solid black;" valign="top">
                <table border="0" width="100%" style="border-collapse: collapse;">
                    <tr>
                        <td>
                            <table width="100%">
                                <tr>
                                    <td><small style="font-size: 12px;">PART NO</small></td>
                                    <td align="right"><small style="font-size: 12px;">MACHINING PART</small></td>
                                </tr>
                            </table>
                            <div align="center">
                                <span style="font-size:40px; font-weight:bold;"><?php echo $partno; ?></span>
                                <br><small style="font-size: 12px;"><?php echo $part_name; ?><br></small>
                            </div>

                        </td>
                    </tr>
                    <tr style="border-top:1px solid black;">
                        <td>
                            <div align="center">
                                <div><span style="font-size:48px; font-weight:bold;"><?php echo $part_address_oln; ?></span></div>
                                <!-- <div><?php echo $hamidasi_address; ?></div> -->
                                <div>ID: <?php echo $label_id; ?></div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

<script>
    //if (confirm("Do Print and close window ?")) {

    window.print();

    setTimeout(function() {
        window.close();
    }, 2000); //1000 = 1 detik

    window.parent.focus();
    window.opener.focus();
    win.opener.focus();
    opener.document.focus();
    opener.window.focus();
    window.opener.document.focus();
    window.focus();

    opener.document.getElementById('scanLabelMarkTmp').focus();

    //}
</script>

</html>