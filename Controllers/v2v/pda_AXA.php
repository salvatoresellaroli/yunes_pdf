<?php
include '../../Core/init.php';
require_once __DIR__ . '/vendor/autoload.php';
try {

	# Versione 1.0.5 del  15/11/2023

	$mpdf = new \Mpdf\Mpdf([
		'default_font' => 'Calibri'
	]);

	if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
		return 0;
	}

	# Dati 
	$obj = json_decode(file_get_contents('php://input'), true);

	$log->scrivi("V2V", logType::start, "[Inzio] ");

	$log->scrivi("V2V", logType::middle, "[json] :", json_encode($obj, JSON_PRETTY_PRINT));

	$tipologia = $obj['prod_categ'];

	if (empty($obj['prod_categ'])) {
		//79 LUCE - 82 GAS
		$tipologia = 79;
	}

	//* ///////////////////////////////////////////////////////////////////////////
	$mpdf->SetHTMLFooter('
	<table style="font-size: 6pt;" width="100%">
	<tbody>
		<tr>
			<td colspan="3" style="text-align: center;">Pag. {PAGENO} di {nbpg}</td>
		</tr>
		<tr>
			<td width="15%"><img src="img/logo_v2v.jpg" width="90" /></td>
			<td width="85%"><strong>Voice2Voice S.r.l.s</strong> &ndash; Sede Legale Roma viale Giorgio Ribotta, 11 P. Iva 0857878121</td>
		</tr>
	</tbody>
	</table>
	');
	//* ///////////////////////////////////////////////////////////////////////////
	$mpdf->SetTitle('PDA - Yunes CRM');
	$mpdf->AddPage();
	$mpdf->Image('img/cover_page.png', 0, 0, 210, 275, 'png', '', true, false);
	$mpdf->SetFont('Calibri', 'B', 11);
	$mpdf->WriteText(16, 46, strtoupper($obj['cognome']));
	$mpdf->WriteText(110, 46, strtoupper($obj['nome']));

	$mpdf->WriteText(16, 60, strtoupper($obj['codicefiscale']));
	$mpdf->WriteText(75, 60, strtoupper($obj['telefono']));
	$mpdf->WriteText(145, 60, strtoupper($obj['cellulare']));

	$mpdf->WriteText(16, 73, $obj['email']);

	$mpdf->WriteText(16, 87, strtoupper($obj['indirizzo']));
	$mpdf->WriteText(145, 87, strtoupper($obj['civico']));

	$mpdf->WriteText(16, 101, strtoupper($obj['citta']));
	$mpdf->WriteText(75, 101, strtoupper($obj['prov']));
	$mpdf->WriteText(145, 101, strtoupper($obj['cap']));


	$mpdf->WriteText(16, 114, strtoupper($obj['immobile']));
	$mpdf->WriteText(110, 114, strtoupper($obj['nucleo_familiare']));
	$mpdf->SetTextColor(255, 0, 0);
	$mpdf->SetFont('Calibri', 'R', 14);

	if ($obj['animali'] == 'SI') {
		$mpdf->WriteText(103.5, 127.5, strtoupper("X")); // SI
	} else {
		$mpdf->WriteText(168, 127.5, strtoupper("X")); // NO
	}

	$mpdf->SetTextColor(0, 0, 0);
	$mpdf->SetFont('Calibri', 'B', 11);
	$mpdf->WriteText(16, 151, strtoupper($obj['indirizzo_servizio']));
	$mpdf->WriteText(145, 151,  strtoupper($obj['civico_servizio']));

	$mpdf->WriteText(16, 165,  strtoupper($obj['citta_servizio']));
	$mpdf->WriteText(75, 165, strtoupper($obj['prov_servizio']));
	$mpdf->WriteText(145, 165, strtoupper($obj['cap_servizio']));

	$mpdf->AddPage();
	$mpdf->Image('pagine/1.png', 0, 0, 210, 275, 'png', '', true, false);
	$mpdf->SetFont('Calibri', 'B', 8);
	$mpdf->WriteText(39, 18.8, strtoupper($obj['prodotto']));

	$iva = $obj['prezzo_netto'] * $obj['iva'] / 100;

	$costo = round($obj['prezzo_netto'] + $iva, 2);
	
	$rata_trimestrale =  round($costo  / 4, 2);
	$costo = str_replace('.',',', $costo);    
	
	$mpdf->SetFont('Calibri', 'R', 7);
	$mpdf->WriteText(30.5, 25, strtoupper($costo));
	
	$hh = "<span style='font-size:10px;'> (In 4 quote di <strong>$rata_trimestrale</strong> euro)</span>";
	$mpdf->SetXY(40,22.5);
	$mpdf->WriteHTML($hh);

	$mpdf->SetFont('Calibri', 'B', 11);
	$mpdf->WriteText(125, 47.5, strtoupper($obj['codcontratto']));
	$mpdf->WriteText(13, 181, strtoupper($obj['dtsign']));

	$mpdf->SetFont('Calibri', 'B', 8);
	$mpdf->WriteText(95, 85, strtoupper($obj['consensi_servizio']));
	$mpdf->WriteText(95, 92, strtoupper($obj['consensi_servizio_2']));
	$mpdf->WriteText(16, 113, strtoupper($obj['consensi_vendita']));
	$mpdf->WriteText(16, 137, strtoupper($obj['consensi_profilazione']));
	$consensi_fornitura_anticipata =  (empty($obj['consensi_fornitura_anticipata'])) ? '': $obj['consensi_fornitura_anticipata'];
	$mpdf->WriteText(36, 172, strtoupper($consensi_fornitura_anticipata));

	$mpdf->SetTextColor(135, 176, 114);
	$mpdf->SetFont('Calibri', 'R', 5.5);
	$mpdf->WriteText(17, 198, strtoupper($obj['tipo_pagamento']));
	$mpdf->SetTextColor(0, 0, 0);
	$mpdf->SetFont('Calibri', 'B', 5);
	$mpdf->WriteText(18, 203.5, strtoupper($obj['label_pagamento'] . ":"));
	$mpdf->SetFont('Calibri', 'B', 11);
	$mpdf->WriteText(19, 208.5, strtoupper($obj['pagamento']));
	$mpdf->WriteText(112, 208.5, strtoupper($obj['intestatario']));
	$mpdf->WriteText(112, 214, strtoupper($obj['ricorrenzaAbb']));

	$mpdf->AddPage();

	if ($tipologia == 82) {
		// Gas

		$html = '
				<p style="text-align:justify"><span style="color:#a7c6f1"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong>#nome_prodotto# </strong></span></span></span></p>
				<p style="text-align:justify">&nbsp;</p>
				<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Il presente Contratto &egrave; stabilito tra Logica Srl &ndash; via G. Boccaccio, 4 &ndash; 20123 Milano P. Iva 12824510965 Pec: <a href="mailto:logica2023@pec.it">logica2023@pec.it&nbsp;</a><br />
				e l&#39;aderente al servizio.&nbsp;<br />
				Entro i limiti ed alle condizioni del presente Contratto, le prestazioni incluse sono valide esclusivamente per l&rsquo;aderente e per l&rsquo;utenza relativa all&rsquo;abitazione indicati nel Modulo di adesione.</span></span></span></p>
				<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">#nome_prodotto# &egrave; una card di servizi - riservata ai clienti di utenze Gas residenziali: gli aderenti a #nome_prodotto# hanno diritto alle seguenti prestazioni:</span></span></span></p>
				<p style="text-align:justify">&nbsp;</p>
				<p style="text-align:justify"><span style="color:#a7c6f1"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:9.0pt">Consulenza Energetica</span></strong></span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">L&rsquo;aderente pu&ograve; usufruire gratuitamente di consulenza professionale specializzata negli ambiti:</span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">&bull; Risparmio energetico e certificazione</span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">&bull; Soluzioni di incremento efficienza energetica</span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">&bull; Metodi di analisi energetica</span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">&bull; Ottimizzazione della climatizzazione</span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">&bull; Indagini energetiche su impianti e strutture</span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">&bull; Analisi di eventuali anomalie dei prelievi</span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">&bull; Proiezione dei ritorni su investimenti nelle strutture, mirati al risparmio energetico</span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">&bull; Proiezione dei ritorni su investimenti negli impianti, mirati al risparmio energetico</span></span></span></p>
				<p style="text-align:justify">&nbsp;</p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Per la richiesta di consulenza energetica &egrave; attiva la casella mail </span><a href="mailto:consulenzaenergetica@logica-consulting.cloud" style="color:#0563c1; text-decoration:underline"><span style="font-size:9.0pt">consulenzaenergetica@logica-consulting.cloud</span></a><span style="font-size:9.0pt"> cui andr&agrave; inoltrata la richiesta.</span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Il servizio di consulenza non comprende i costi di eventuali pratiche realizzative, che rimarranno a carico dell&rsquo;aderente. Tuttavia, se a seguito della consulenza gratuita l&rsquo;aderente decidesse di affidare la pratica ad un professionista consulente di Logica, beneficer&agrave; di uno sconto del 10% sulla prestazione professionale.</span></span></span></p>
				<p style="text-align:justify">&nbsp;</p>
				<p style="text-align:justify"><span style="color:#a7c6f1"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:9.0pt">Attivazione Coperture Assicurative</span></strong></span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Logica ha attivato a proprie spese e a favore dei sottoscrittori di #nome_prodotto# le coperture assicurative riportate in allegato</span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Le coperture assicurative &ndash; completamente gratuite - decorrono dalla data di attivazione della Card, hanno durata un anno e si rinnovano annualmente semprech&eacute; la #nome_prodotto# sia in vigore.</span></span></span></p>
		';
	} else {
		
		// Luce
		$html = '
				<p style="text-align:justify"><span style="color:#a7c6f1"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong>#nome_prodotto# </strong></span></span></span></p>
				<p style="text-align:justify">&nbsp;</p>
				<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Il presente Contratto &egrave; stabilito tra Logica Srl &ndash; via G. Boccaccio, 4 &ndash; 20123 Milano P. Iva 12824510965 Pec: <a href="mailto:logica2023@pec.it">logica2023@pec.it&nbsp;</a><br />
				e l&#39;aderente al servizio.&nbsp;<br />
				Entro i limiti ed alle condizioni del presente Contratto, le prestazioni incluse sono valide esclusivamente per l&rsquo;aderente e per l&rsquo;utenza relativa all&rsquo;abitazione indicati nel Modulo di adesione.</span></span></span></p>
				<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">#nome_prodotto# &egrave; una card di servizi - riservata ai clienti di utenze Luce residenziali: gli aderenti a #nome_prodotto# hanno diritto alle seguenti prestazioni:</span></span></span></p>
				<p style="text-align:justify">&nbsp;</p>
				<p style="text-align:justify"><span style="color:#a7c6f1"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:9.0pt">Consulenza Energetica</span></strong></span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">L&rsquo;aderente pu&ograve; usufruire gratuitamente di consulenza professionale specializzata negli ambiti:</span></span></span></p>
				<ul>
				<li><span style="font-size:7pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Risparmio energetico e certificazione</span></span></span></li>
				<li><span style="font-size:7pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Ottimizzazione distribuzione dei prelievi e dei carichi</span></span></span></li>
				<li><span style="font-size:7pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Strumenti di indagine sui consumi e potenze prelevate</span></span></span></li>
				<li><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Ottimizzazione della climatizzazione</span></span></span></li>
				<li><span style="font-size:7pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Analisi di eventuali anomalie dei prelievi</span></span></span></li>
				<li><span style="font-size:7pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Proiezione dei ritorni su investimenti negli impianti mirati al risparmio energetico</span></span></span></li>
				</ul>
				<p style="text-align:justify">&nbsp;</p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Per la richiesta di consulenza energetica &egrave; attiva la casella mail </span><a href="mailto:consulenzaenergetica@logica-consulting.cloud" style="color:#0563c1; text-decoration:underline"><span style="font-size:9.0pt">consulenzaenergetica@logica-consulting.cloud</span></a><span style="font-size:9.0pt"> cui andr&agrave; inoltrata la richiesta.</span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Il servizio di consulenza non comprende i costi di eventuali pratiche realizzative, che rimarranno a carico dell&rsquo;aderente. Tuttavia, se a seguito della consulenza gratuita l&rsquo;aderente decidesse di affidare la pratica ad un professionista consulente di Logica, beneficer&agrave; di uno sconto del 10% sulla prestazione professionale.</span></span></span></p>
				<p style="text-align:justify">&nbsp;</p>
				<p style="text-align:justify"><span style="color:#a7c6f1"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:9.0pt">Attivazione Coperture Assicurative</span></strong></span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Logica ha attivato a proprie spese e a favore dei sottoscrittori di #nome_prodotto# le coperture assicurative riportate in allegato</span></span></span></p>
				<p style="text-align:justify"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><span style="font-size:9.0pt">Le coperture assicurative &ndash; completamente gratuite - decorrono dalla data di attivazione della Card, hanno durata un anno e si rinnovano annualmente semprech&eacute; la #nome_prodotto# sia in vigore.</span></span></span></p>
				<p>&nbsp;</p>
		';
	}
	
	$html = str_replace('#nome_prodotto#', $obj['prodotto'], $html);
	$mpdf->WriteHTML($html);
	// $mpdf->Image('pagine/2.png', 0, 0, 210, 275, 'png', '', true, false);
	// $mpdf->SetTextColor(22, 71, 116);
	// $mpdf->WriteText(16, 20, strtoupper($obj['prodotto']));
	// $mpdf->SetTextColor(0, 0, 0);
	$mpdf->AddPage();
	$mpdf->Image('pagine/3.png', 0, 0, 210, 275, 'png', '', true, false);
	$mpdf->AddPage();
	$mpdf->Image('pagine/4.png', 0, 0, 210, 275, 'png', '', true, false);
	$mpdf->AddPage();
	$mpdf->Image('pagine/5.png', 0, 0, 210, 275, 'png', '', true, false);
	$mpdf->AddPage();
	$mpdf->Image('pagine/6.png', 0, 0, 210, 275, 'png', '', true, false);
	$mpdf->AddPage();
	$mpdf->Image('pagine/7.png', 0, 0, 210, 275, 'png', '', true, false);
	$mpdf->AddPage();
	$mpdf->Image('pagine/8.png', 0, 0, 210, 275, 'png', '', true, false);
	$mpdf->AddPage();
	$mpdf->Image('pagine/9.png', 0, 0, 210, 275, 'png', '', true, false);
	$mpdf->AddPage();
	$mpdf->Image('pagine/10.png', 0, 0, 210, 275, 'png', '', true, false);
	$mpdf->AddPage();
	$mpdf->Image('pagine/11.png', 0, 0, 210, 275, 'png', '', true, false);

	$mpdf->SetAuthor("Yunes.it");

	$cartellaFile = $obj['pathfile'];

	if (!$isDEBUG) {
		# Verifico se la cartella del paziente esiste altrimenti la creo
		verificaCartella(DIR_FILE . $cartellaFile);
	}

	# Percorso salvataggio pdf
	$dir = DIR_FILE . $cartellaFile;

	# Nome file
	$nome_file = getToken() . '.pdf';

	# Percorso completo del file
	$file =  $dir . $nome_file;

	if ($isDEBUG) {
		$file =  DIR_FILE . $nome_file;
	}

	# Genero pdf
	$mpdf->Output($file);
	$risposta->codiceErrore = errore::Success;
	$risposta->dati = $cartellaFile . $nome_file;
	$risposta->messaggio = $nome_file;

	echo json_encode($risposta);

	$log->scrivi("V2V", logType::middle, "[Risposta] :", json_encode($risposta, JSON_PRETTY_PRINT));
	$log->scrivi("V2V", logType::end, "[Fine] ");

} catch (Throwable $ex) {
	http_response_code(500);
	$sendMail->emailErrore("Errore nella generazione PDF ABBONAMENTO", $ex->getMessage(), $ex->getFile(), $ex->getLine());
}
