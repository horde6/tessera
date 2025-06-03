<?php

require_once 'tcpdf/tcpdf_barcodes_2d.php';

class BarCode {
	public static function QRCode($url, $size = 4, $type = "H") {
		$qrcode = new TCPDF2DBarcode($url, 'QRCODE,' . $type);
		return $qrcode->getBarcodeHTML($size, $size);
	}
}
