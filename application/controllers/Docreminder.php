<?php

use PhpParser\Node\Stmt\Echo_;

defined('BASEPATH') or exit('No direct script access allowed');

class Docreminder extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->db_oka_ne = $this->load->database('db_oka_ne', TRUE);

        //ini_set('sendmail_path', 'C:\\xampp\\sendmail\\sendmail.exe -t');

        //ini_set('SMTP', 'mail.okalog.co.id');
        //ini_set('smtp_port', 465);
        //ini_set('smtp_ssl', 'auto');
        /* ini_set('sendmail_from', 'it02@okalog.co.id');
        ini_set('auth_username', 'it02@okalog.co.id');
        ini_set('auth_password', 'Olcoln112233');
        ini_set('username', 'it02@okalog.co.id');
        ini_set('password', 'Olcoln112233');
        ini_set('force_sender', 'it02@okalog.co.id'); */


        /*  ini_set('SMTP', 'smtp-relay.gmail.com');
        ini_set('smtp_port', 465);
        ini_set('smtp_ssl', 'auto');
        ini_set('sendmail_from', 'reminder.oln@gmail.com');
        ini_set('auth_username', 'reminder.oln@gmail.com');
        ini_set('auth_password', 'Olcoln112233');
        ini_set('username', 'reminder.oln@gmail.com');
        ini_set('password', 'Olcoln112233');
        ini_set('force_sender', 'reminder.oln@gmail.com'); */

        //ini_set('SMTP', 'smtp-relay.gmail.com');
        //ini_set('smtp_port', 25);
        //ini_set('SMTP', 'smtp.googlemail.com');
        //ini_set('smtp_port', 465);
        //ini_set('smtp_ssl', 'auto');
    }


    public function index()
    {
        echo "<!DOCTYPE html>";
        echo "<html>";
        echo "<head><title>Okamoto Document Reminder</title></head>";
        echo '<meta http-equiv="Refresh" content="120"> ';
        echo "<body>";
        echo "<h1 style='color:red;'>Please don't close this window</h1>";
        echo "<hr><h1>Running Document Reminder Background Job<br><span style='background-color:yellow;'>" . date("Y-m-d H:i:s") . "</span></h1>";
?><img src="<?php echo base_url(); ?>/assets/images/loading-now-loading.gif">
        <script>
            //60000 milliseconds = 60 seconds = 1 minute.
            /* setInterval(function() {
                document.location.reload();
            }, 60000 * 59); */

            //setTimeout("document.location.reload();", 60000 * 59);
        </script><?php

                    //echo date("Gi");

                    //step1 get list document yg status masih open
                    //step2 is reminder date = today
                    //pre step3 apakah tanggal kirim email = tanggal hari ini (untuk cek/ kirim daily email reminder)
                    //step3 apakah doc tsb sudah dikirim email reminder hari ini ? jika sudah tandai sudah dikirim update tanggal kirim email=tanggal hari ini

                    //$sql = "SELECT * FROM vw_document where status='open'";
                    $sql = "SELECT * FROM vw_document where status='open' and enddate is not null and today_reminder_date='" . date("Y-m-d") . "'"; //if tgl jadwal kirim email = tgl hari ini, maka kirim email
                    //echo $sql;
                    $rs = $this->db->query($sql);
                    if ($rs->num_rows() > 0) {
                        $i = 0;
                        foreach ($rs->result_array() as $row) {

                            //$exp_date = strtotime($row['enddate']);                            

                            //update today_reminder_date +1
                            $today_reminder_date = strtotime($row['today_reminder_date']);
                            $next_reminder_date = date("Y-m-d", strtotime("+1 day", $today_reminder_date));

                            //if (date("l") !== "Saturday" || date("l") !== "Sunday") {
                            if (number_format(date("Gi")) > 745) { //kirim email jam 7:45

                                //update dulu reminder date hari berikutnya, agar kalau ada pengiriman email bermasalah, keesokan hari nya dokumen masih muncuk utk di cek
                                $sql = "UPDATE document set today_reminder_date='$next_reminder_date' where id=" . $row['id'];
                                $this->db->query($sql);

                                //function proses kirim email reminder
                                $this->fun_kiriemail($row['id']);
                            }
                            //}
                        }
                    }
                    echo "</body></html>";

                    require_once('Imis_to_pxp.php'); //20240920 Andi
                }


                public function fun_kiriemail($iddoc)
                {

                    ini_set('SMTP', 'smtp.okalog.co.id');
                    ini_set('smtp_port', 465);

                    // Konfigurasi email
                    $config = [
                        'mailtype'  => 'html',
                        'charset'   => 'utf-8',
                        'protocol'  => 'mail',
                        //'smtp_host' => 'smtp.gmail.com',
                        //'smtp_host' => 'smtp-relay.gmail.com',
                        //'smtp_host' => 'smtp.googlemail.com',
                        'smtp_host' => 'smtp.okalog.co.id',
                        //'smtp_host' => 'ssl://smtp.googlemail.com',
                        //'smtp_user' => 'reminder.oln@gmail.com',  // Email gmail
                        //'smtp_pass'   => 'gcrjrujvgzbbrhph',  // Password gmail

                        'smtp_user' => 'it02@okalog.co.id',  // Email gmail
                        'smtp_pass'   => 'Olcoln112233',  // Password gmail

                        'smtp_crypto' => 'ssl',
                        'smtp_port'   => 465,
                        //'smtp_port'   => 25,
                        'crlf'    => "\r\n",
                        'newline' => "\r\n"
                    ];

                    // Load library email dan konfigurasinya
                    //$this->load->library('email');

                    $config1['charset'] = 'iso-8859-1';
                    $config1['mailtype'] = 'html';
                    $config1['crlf'] = "\r\n";
                    $config1['newline'] = "\r\n";

                    $this->email->initialize($config1);
                    $this->email->set_newline("\r\n");

                    $sql = "SELECT * from vw_document where id=" . $iddoc;
                    //$rs = $this->db->query($sql);
                    $row = $this->db->query($sql)->row_array();
                    //$label_id = $row['id'];

                    // Email dan nama pengirim
                    //$this->email->from('reminder.oln@gmail.com', 'OLN, Document Reminder');
                    $this->email->from('reminder@okalog.co.id', 'OLN, Document Reminder');

                    // Email penerima
                    $this->email->to($row['email']); // Ganti dengan email tujuan                    

                    $hod_email = "";
                    $sql1 = "SELECT email from users where iddept='" . $row['iddept'] . "' and ishod='yes'";
                    $rs1 = $this->db->query($sql1);
                    if ($rs1->num_rows() > 0) {
                        $row1 = $this->db->query($sql1)->row_array();
                        //echo json_encode($row);
                        $hod_email = $row1['email'];
                    }

                    $lampiran = "";
                    $sql2 = "SELECT name from document_attachment where docid='$iddoc'";
                    $rs2 = $this->db->query($sql2);
                    if ($rs2->num_rows() > 0) {
                        $row2 = $this->db->query($sql2)->row_array();
                        $lampiran = $row2['name'];

                        $this->email->attach('http://192.168.1.57/dev/document_reminder/uplod/lampiran/' . $row2['name']);
                    } else {
                        $lampiran = "";
                    }

                    //$this->email->cc('someone@gmail.com');
                    $this->email->cc($hod_email);
                    $this->email->bcc('it02@okalog.co.id', 'it01@okalog.co.id', 'fey@okalog.co.id');

                    if ($lampiran !== "") {
                        // Lampiran email, isi dengan url/path file
                        //$this->email->attach('http://intranet.oln/dev/document_reminder/uplod/lampiran/' . $lampiran);
                    }

                    // Subject email
                    $this->email->subject('OLN Document Reminder - ' . $row['documenttype'] . ' ' . $row['docno']);

                    // Isi email                    
                    $str = "<span style='font-family:verdana'>Dear " . $row['namauser'] . ",<br><br>

                        This is a reminder email, please don't reply<br>
                        document with the following detail is about to expired at " . $row['enddate'] . "<br><br>
        
                        Document type :  " . $row['documenttype'] . "<br>
                        Document Number :  " . $row['docno'] . "<br>
                        Description : " . $row['description'] . "<br>
                        Term : " . $row['term'] . "<br>
                        Start Date : " . $row['startdate'] . "<br>
                        Until (<b>Exp Date :  " . $row['enddate'] . "</b>)<br><br>";

                    if ($lampiran !== "") {
                        $str = $str . "Attachment : $lampiran<br><br>";
                    }

                    $str = $str . "Please follow up as soon as possible the document above,<br>
                        thank you.
                        <br>
                        <br>
                        Regards<br>
                        Document Reminder<br>
                        --<br>
                        http://intranet.oln/dev<br>";


                    $this->email->message($str);

                    if ($this->email->send()) {
                        echo '<br>Sukses! email berhasil dikirim.. ' . date("Y-m-d H:i:s") . '<hr>';
                        echo $this->email->print_debugger();
                    } else {
                        //echo 'Error! email tidak dapat dikirim.';
                        show_error($this->email->print_debugger());
                    }

                    $this->email->clear(TRUE); //reset semua variabel email termasuk me remove attachments
                }
            }
