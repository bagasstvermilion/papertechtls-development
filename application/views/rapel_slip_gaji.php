<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Untitled Document</title>
</head>

<body>
  <?php //$nik = 'IO-5973';
  $sql = "SELECT * FROM rapel1 where kolom01='$nik'";
  $rs = $this->db->query($sql);

  if ($rs->num_rows() > 0) {
    foreach ($rs->result_array() as $row) {
  ?>
      <table width="100%" border="0">
        <tr>
          <td width="20%"><img src="<?= base_url('assets/images/logo_oln.png') ?>" /></td>
          <td align="center"><strong>RINCIAN KENAIKAN GAJI 2025 </strong></td>
          <td width="20%">&nbsp;</td>
        </tr>
      </table>
      <table border="0">
        <tr>
          <td width="">&nbsp;</td>
          <td width="">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td width="30">&nbsp;</td>
          <td width="">&nbsp;</td>
          <td width="">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="8"><strong>I. DATA KARYAWAN</strong> </td>
        </tr>
        <tr>
          <td>NAMA</td>
          <td>:</td>
          <td>&nbsp;</td>
          <td width=""><?php echo $row['kolom02']; ?></td>
          <td>&nbsp;</td>
          <td>GAJI POKOK + MASA KERJA 2024 </td>
          <td>:</td>
          <td><?php echo $row['kolom13']; ?></td>
        </tr>
        <tr>
          <td>NIK</td>
          <td>:</td>
          <td>&nbsp;</td>
          <td><?php echo $row['kolom01']; ?></td>
          <td>&nbsp;</td>
          <td>TANGGAL AWAL KERJA </td>
          <td>:</td>
          <td><?php echo $row['kolom09']; ?></td>
        </tr>
        <tr>
          <td>DEPARTEMEN</td>
          <td>:</td>
          <td>&nbsp;</td>
          <td><?php echo $row['kolom07']; ?></td>
          <td>&nbsp;</td>
          <td>MASA KERJA </td>
          <td>:</td>
          <td><?php echo $row['kolom29']; ?></td>
        </tr>
        <tr>
          <td>POSITION</td>
          <td>:</td>
          <td>&nbsp;</td>
          <td><?php echo $row['kolom08']; ?></td>
          <td>&nbsp;</td>
          <td>LEVEL UPAH </td>
          <td>:</td>
          <td><?php echo $row['kolom12']; ?></td>
        </tr>
        <tr>
          <td>OFFICE</td>
          <td>:</td>
          <td>&nbsp;</td>
          <td><?php echo $row['kolom03']; ?></td>
          <td>&nbsp;</td>
          <td>PERFORMANCE APPRAISAL </td>
          <td>:</td>
          <td><?php echo $row['kolom22']; ?></td>
        </tr>
      </table>
      <table width="0%" border="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>II. RINCIAN PERHITUNGAN KENAIKAN GAJI 2025 </strong></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr>
          <td valign="bottom">SKALA UPAH 2025 
            <table width="100%" border="1" style="border-collapse:collapse;">
              
              <tr>
                <td width="50%">UPAH TERKECIL </td>
                <td>Rp. <?php echo $row['kolom16']; ?></td>
              </tr>
              <tr>
                <td>UPAH TERBESAR </td>
                <td>Rp. <?php echo $row['kolom17']; ?></td>
              </tr>
            </table>
          </td>
          <td>&nbsp;</td>
<td valign="bottom"><table width="100%" border="1"  style="border-collapse:collapse;">
              <tr>
                <td align="center"><strong>PERFORMANCE APPRAISAL </strong></td>
                <td align="center">120%</td>
                <td align="center">110%</td>
                <td align="center">100%</td>
                <td align="center">90%</td>
                <td align="center">80%</td>
              </tr>
              <tr>
                <td align="center">LEVEL</td>
                <td align="center">S</td>
                <td align="center">A</td>
                <td align="center">B</td>
                <td align="center">C</td>
                <td align="center">D</td>
              </tr>
			  <?
			  $sql2 = "SELECT * FROM performance_appraisals where levels='".$row['kolom12']."' and tahun='2025'";
        $rs2 = $this->db->query($sql2);
        if ($rs2->num_rows() > 0) {
            $row2 = $this->db->query($sql2)->row_array();
            $s = $row2['nilai_s'];
			$a = $row2['nilai_a'];
			$b = $row2['nilai_b'];
			$c = $row2['nilai_c'];
			$d = $row2['nilai_d'];
        } else {
            $s = "";
			$a = "";
			$b = "";
			$c = "";
			$d = "";
        } 
			  ?>
              <tr>
                <td align="center"><?php echo $row['kolom12']; ?></td>
                <td align="center"><?php echo $s; ?></td>
                <td align="center"><?php echo $a; ?></td>
                <td align="center"><?php echo $b; ?></td>
                <td align="center"><?php echo $c; ?></td>
                <td align="center"><?php echo $d; ?></td>
              </tr>
            </table>
          </td>
        </tr>
</table>
      <table width="100%" border="0">
        <tr>
          <td><table width="100%" border="1" style="border-collapse:collapse;">
            <tr>
              <td align="center"><strong>DESCRIPTION</strong></td>
              <td align="center"><strong>GAJI 2024 </strong></td>
              <td align="center"><strong>PERHITUNGAN KENAIKAN GAJI </strong></td>
              <td align="center"><strong>GAJI 2025 </strong></td>
            </tr>
            <tr>
              <td>1. UPAH POKOK + MASA KERJA </td>
              <td align="right">Rp. <?php echo $row['kolom13']; ?></td>
              <td>&nbsp;</td>
              <td align="right">Rp. <?php echo $row['kolom13']; ?></td>
            </tr>
            <tr>
              <td>2. MASA KERJA </td>
              <td align="right">&nbsp;</td>
              <td align="right">Rp. <?php echo $row['kolom30']; ?></td>
              <td align="right">Rp. <?php echo $row['kolom30']; ?></td>
            </tr>
            <tr>
              <td>3. IHK 2025 (%) </td>
              <td align="right">&nbsp;</td>
              <td align="right">Rp. <?php echo $row['kolom18']; ?></td>
              <td align="right">Rp. <?php echo $row['kolom18']; ?></td>
            </tr>
            <tr>
              <td>4. PERFORMANCE APPRAISAL </td>
              <td align="right">&nbsp;</td>
              <td align="right">Rp. <?php echo $row['kolom24']; ?></td>
              <td align="right">Rp. <?php echo $row['kolom24']; ?></td>
            </tr>
            <tr>
              <td>5. ADJUST (SESUAI MIN. LEVEL)</td>
              <td align="right">&nbsp;</td>
              <td align="right">Rp. <?php echo $row['kolom25']; ?></td>
              <td align="right">Rp. <?php echo $row['kolom25']; ?></td>
            </tr>
            <tr>
              <td>6. (+&alpha;) = Rp </td>
              <td align="right">&nbsp;</td>
              <td align="right"><?php echo $row['kolom35']; ?></td>
              <td align="right"><?php echo $row['kolom35']; ?></td>
            </tr>
            <tr>
              <td>TOTAL KENAIKAN GAJI 2025 </td>
              <td align="right">Rp. <?php echo $row['kolom13']; ?></td>
              <td align="right">Rp. <?php echo $row['kolom36']; ?></td>
              <td align="right">Rp. <?php echo $row['kolom37']; ?></td>
            </tr>
            <tr>
              <td>PRESENTASE KENAIKAN (%) </td>
              <td colspan="3" align="center"><?php echo $row['kolom38']; ?></td>
            </tr>
          </table></td>
        </tr>
      </table>
  <? }
  } else {
    echo "Tidak ada data.";
  } ?>
</body>

</html>