<?php
include '../../Core/init.php';
require_once __DIR__ . '/vendor/autoload.php';
try {
	$mpdf = new \Mpdf\Mpdf([
		'default_font' => 'dejavusans'
	]);

	$mpdf->imageVars['hr'] = file_get_contents('img/hr.jpg');
	
	if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
		return 0;
	}

	$dati = json_decode(file_get_contents('php://input'), true);

	$obj = $dati;
	# Dati _GET
	$inviaEmail = (bool) $obj['invia_pdf_mail'];
	//* ///////////////////////////////////////////////////////////////////////////
	$mpdf->SetHTMLFooter('<hr>
		<table style="font-size: 9pt;" width="100%">
		<tbody>
		<tr>
		<td width="33%">
		<a href="https://yunes.it/" target="_blank">
		<img src="img/logo-yunes.jpg" width="200"/></a>
		</td>
		<td align="center" width="33%">{PAGENO}/{nbpg}</td>
		<td style="text-align: right;" width="33%">{DATE j/m/Y H:i}</td>
		</tr>
		</tbody>
	</table>');
	//* ///////////////////////////////////////////////////////////////////////////
	$mpdf->SetTitle('Quotazione di SiRent');
	$mpdf->AddPage();
	$mpdf->Image('img/cover_page.png', 0, 0, 210, 275, 'png', '', true, false);
	$mpdf->SetFont('Helvetica', 'B', 14);
	$mpdf->WriteText(25, 58, $obj['numprev']);
	$mpdf->WriteText(90, 58, $obj['datacreazione']);
	$mpdf->WriteText(155, 58, $obj['datascadenza']);
	$mpdf->WriteText(40, 106, $obj['cliente']);
	$mpdf->WriteText(35, 116, $obj['email']);
	$mpdf->SetFont('Helvetica', 'B', 10);
	$mpdf->WriteText(60, 124, $obj['tipocontratto']);
	//$mpdf->SetTextColor(74, 120, 166); // colore testo
	//$mpdf->WriteText(15, 134, $obj['veicolo_extend']);
	$mpdf->SetXY(15,136);
	$mpdf->WriteHTML('<div style="width: 100mm; background-color: red; height: 15mm; color:#4a78a6; font-weight: bold;">'.$obj['veicolo_extend'].'</div>');


	$mpdf->SetTextColor(0, 0, 0);
	$mpdf->WriteText(75, 132.3, $obj['promoapp']);
	$mpdf->SetFont('Helvetica', 'B', 14);
	$mpdf->WriteText(165, 107, "€ " . number_format($obj['canone'], 2, ",", "."));
	$mpdf->WriteText(165, 121,  "€ " . number_format($obj['anticipo'], 2, ",", "."));
	$mpdf->WriteText(170, 133, $obj['duratarata']);
	$mpdf->WriteText(165, 146, number_format($obj['km'], 0, ",", "."));
	$mpdf->SetFont('Helvetica', '', 10);

	$width = 100;
	$text = $obj['veicolo_extend'];
	if(strlen($text) > $width) {
	  $text = substr($text, 0, $width-3) . '...';
	}

	$mpdf->WriteText(25, 180, $text);
   
	$mpdf->WriteText(35, 187, $obj['alimentazione']);

	if (!empty($obj['dataimmatricolazione'])) {
		$mpdf->WriteText(7, 187, "Data Immatricolazione:  " . $obj['dataimmatricolazione']);
	}

	if (!empty($obj['kmusato'])) {
		$mpdf->WriteText(7, 191, "Km usato:  " . number_format($obj['kmusato'], 0, ",", "."));
	}

	// $mpdf->WriteText(36, 211, $obj['pneumatico_estivo']);
	// $mpdf->WriteText(36, 216, $obj['pneumatico_invernale']);
	$mpdf->WriteText(36, 212, "€ " . number_format($obj['totalelistino'], 2, ",", "."));
	// $mpdf->WriteText(67, 254, $obj['sostveicolo']);
	// $mpdf->WriteText(67, 259, $obj['fuelcard']);
	// Pagina 2
	$mpdf->AddPage();
	$mpdf->Image('img/hr.jpg', 0, 0, 210, 40, 'png', '', true, false);
	$mpdf->WriteHTML($obj['condizioni']);
	//! FASE GENERAZIONE FILE
	$cartellaFile = $obj['pathfile'];
	# Verifico se la cartella del paziente esiste altrimenti la creo
	verificaCartella(DIR_FILE . $cartellaFile);
	# Percorso salvataggio pdf
	$dir = DIR_FILE . $cartellaFile;
	# Nome file
	$nome_file = getToken() . '_' . date("d_m_Y_H_i_s") . '.pdf';
	# Percorso completo del file
	$file =  $dir . $nome_file;

	if ($isDEBUG) {
		$file =  DIR_FILE . $nome_file;
	}

	# Genero pdf
	$mpdf->Output($file);
	# Se scelta l'opzione invio il pdf come allegato email
	// if ($inviaEmail) {
	// 	$sendMail->inviaPreventivo($obj['email'], $obj['cliente'], $file, "Preventivo n." . $obj['numprev'] . " del " . $obj['datacreazione']);
	// }

	$risposta->codiceErrore = errore::Success;
	$risposta->dati = $cartellaFile . $nome_file;
	$risposta->messaggio = 'Preventivo_' . str_replace("/", "_", $obj['nomefile'] . "_" . date("d_m_Y") . '.pdf');
	echo json_encode($risposta);
} catch (Throwable $ex) {
	$ex->getMessage();
}
