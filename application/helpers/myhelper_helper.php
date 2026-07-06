<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function fwarna_badge($state = null)
{
    switch ($state) {
        case 'reject':
            $bc = 'badge-danger';
            break;
        case 'open':
            $bc = 'badge-warning';
            break;
        case 'progress':
            $bc = 'badge-warning';
            break;
        case 'done':
            $bc = 'badge-success';
            break;
        case 'no reminder':
            $bc = 'badge-success';
            break;
        case 'approved':
            $bc = 'badge-primary';
            break;
        case 'draft':
            $bc = 'badge-secondary';
            break;
        case 'close':
            $bc = 'badge-secondary';
            break;
        case 'progress':
            $bc = 'badge-info';
            break;
        case 'no':
            $bc = 'badge-danger';
            break;
        case 'yes':
            $bc = 'badge-success';
            break;
        case 0:
            $bc = 'badge-danger';
            break;
        case 1:
            $bc = 'badge-success';
            break;
        case 'match-oke':
            $bc = 'badge-success';
            break;
        case 'unmatch':
            $bc = 'badge-danger';
            break;
    }
    return $bc;
}



function getQrCodeImg($qrCodeText, $size = 200, $padding = 10, $errCorrection = 'middle')
{
    $qrCode = new Endroid\QrCode\QrCode();
    $qrCode->setText($qrCodeText)->setSize($size)->setPadding($padding)->setErrorCorrection($errCorrection)->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0));
    $imageUri = $qrCode->getDataUri();
    return '<img src="' . $imageUri . '" />';
}
