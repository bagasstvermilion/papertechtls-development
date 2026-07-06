<?php
defined('BASEPATH') or exit('No direct script access allowed');
// panggil autoload dompdf nya
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Dompdfmy
{
    public function generate($html, $filename = '', $paper = '', $orientation = '', $stream = TRUE)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename . ".pdf", array("Attachment" => 0)); //langsung preview pdf di browser
        } else {
            $dompdf->stream($filename . ".pdf", array("Attachment" => 1)); //tanpa preview file pdf langsung terdownload
            //return $dompdf->output();
        }
    }

    function createPDF($html, $filename = '', $paper = '', $orientation = '', $stream = TRUE, $is_setpwd = 'no', $pwd = '123')
    {
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if ($is_setpwd == 'yes') {
            $dompdf->getCanvas()->get_cpdf()->setEncryption($pwd, $pwd, ['print', 'modify', 'copy', 'add']); //set password di file pdf
        }
        //$dompdf->setPaper($paper, $orientation);
        if ($stream) {
            //$dompdf->stream($filename.".pdf"); - This works just ok
            file_put_contents($filename . ".pdf", $dompdf->output());
        } else {
            return $dompdf->output();
        }
    }
}
