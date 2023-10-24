<?php
include '../../Core/init.php';
require_once __DIR__ . '/vendor/autoload.php';
try {

    $mpdf = new \Mpdf\Mpdf([
        'default_font' => 'Calibri'
    ]);

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        return 0;
    }

    # Dati

    $log->scrivi("PDF_energia", logType::start, "[Inzio] ");

    $dati = json_decode(file_get_contents('php://input'), true);

    $obj = $dati['DocumentElement']['value'];

    if (empty($dati)) {
        $log->scrivi("PDF_energia", logType::middle, "[Errore] json vuoto ");
        throw new Exception("Dati json vuoto.");
    }


    $log->scrivi("PDF_energia", logType::middle, "[json] :", json_encode($obj, JSON_PRETTY_PRINT));

    $nome_referente = $obj['consulente'];
    $data_preventivo = dataAttualePDF();
    $nome_cliente = $obj['anagrafica'];
    $indirizzo_cliente = $obj['indirizzo'];
    $potenzaP = $obj['dimensioneFV_kWp_ibrio'];
    $batteria_kw =   ($obj['ibrido'] == 'true') ? $obj['batteria'] . ' kW' : '';
    $txt_DescrizionePannello = $obj['nome_pannelli'];
    $txt_MarcaPannello = $obj['brand_pannelli'];
    $numeroPannelli = ($obj['ibrido'] == 'true') ? $obj['numero_pannelli_ibrido'] : $obj['numero_pannelli_senza_batteria'];
    $txt_DescrizioneInverter = $obj['nome_inverter'];
    $txt_MarcaInverter = $obj['brand_inverter'];
    $numeroInverter = $obj['prod_inverter_quantity'];
    $txt_DescrizioneBatteria =  ($obj['ibrido'] == 'true') ? $obj['nome_batterie'] : '';
    $txt_MarcaBatteria = ($obj['ibrido'] == 'true') ? $obj['brand_batterie'] : '';
    $numeroBatterie = ($obj['ibrido'] == 'true') ? $obj['prod_batterie_quantity'] : '';
    $totalePreventivo =   ($obj['ibrido'] == 'true') ? $obj['totale_costo_ibrdo'] : $obj['totale_costo_senza_batteria'];
    $totaleDetrazioniFiscale = intval($totalePreventivo / 2);
    $firmaConsulente = $obj['consulente'];
    $firmaCliente = $obj['anagrafica'];
    $attach_map = $obj['attach_map'];
    $attach_set_result_1 = $obj['attach_set_result_1'];
    $attach_set_result_2 = $obj['attach_set_result_2'];
    $attach_set_result_3 = $obj['attach_set_result_3'];

    $mpdf->SetTitle('PDA - Yunes CRM');
    $mpdf->SetFont('Calibri', 'B', 14);
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
    ###################################################################################################
    # PAGINA n.1 - Cover
    $mpdf->AddPage();
    $mpdf->Image('img/cover_page.jpg', 0, 0, 210, 297, 'jpg', '', true, false);

    $mpdf->SetFont('Calibri', 'B', 18);

    $mpdf->SetTextColor('#92d14f');
    # Nome referente
    $mpdf->WriteText(135, 99, strtoupper($nome_referente));
    $mpdf->SetTextColor('#000000');
    # Data preventivo
    $mpdf->WriteText(145, 118, strtoupper($data_preventivo));

    # Nome cliente
    $mpdf->SetFont('Calibri', 'B', 14);
    $mpdf->SetTextColor('#92d14f');
    $mpdf->WriteText(20, 222, strtoupper($nome_cliente));

    # Indirizzo di fornitura
    $mpdf->SetXY(20, 245);
    $indirizzoInstallazione = "<p style ='width: 300px;margin-left:20px;font-size:18px; color:#92d14f;font-weight: bold;'>$indirizzo_cliente </p>";
    $mpdf->WriteHTML($indirizzoInstallazione);
    $mpdf->SetTextColor('#000000');

    ###################################################################################################
    # PAGINA n.2
    $mpdf->AddPage();
    $mpdf->Image('pagine/2.jpg', 0, 0, 210, 297, 'jpg', '', true, false);

    # Potenza P =
    $mpdf->SetFont('Calibri', 'R', 22);
    $mpdf->WriteText(137.8, 66.4, $potenzaP);

    # SE SCEGLIERE BATTERIA
    $mpdf->WriteText(43, 77.4, 'BATTERIA D\'ACCUMULO DI ' . $batteria_kw);

    # MODULI FOTOVOLTAICI
    $mpdf->SetY(130);
    $descizionePannello = "<p style ='width: 380px;font-size:18px; margin-left: -25px;font-weight: bold;'>$txt_DescrizionePannello </p>";
    $mpdf->WriteHTML($descizionePannello);
    $mpdf->SetY(130);
    $marcaPannello = "<p style ='width: 136px;font-size:14px; margin-left: 366px;font-weight: bold;'>$txt_MarcaPannello</p>";
    $mpdf->WriteHTML($marcaPannello);
    $mpdf->SetFont('Calibri', 'B', 22);
    $mpdf->WriteText(165, 143, $numeroPannelli);

    # INVERTER
    $mpdf->SetY(158);
    $descizioneInverter = "<p style ='width: 380px;font-size:18px; margin-left: -25px;font-weight: bold;'>$txt_DescrizioneInverter</p>";
    $mpdf->WriteHTML($descizioneInverter);
    $mpdf->SetY(159);
    $marcaInverter = "<p style ='width: 136px;font-size:14px; margin-left: 366px;font-weight: bold;'>$txt_MarcaInverter</p>";
    $mpdf->WriteHTML($marcaInverter);
    $mpdf->SetFont('Calibri', 'B', 22);
    $mpdf->WriteText(165, 170, $numeroInverter);

    # BATTERIA
    $mpdf->SetY(184);
    $descrizioneBatteria = "<p style ='width: 380px;font-size:18px; margin-left: -25px;font-weight: bold;'>$txt_DescrizioneBatteria</p>";
    $mpdf->WriteHTML($descrizioneBatteria);
    $mpdf->SetY(185);
    $marcaBatteria = "<p style ='width: 136px;font-size:14px; margin-left: 366px;font-weight: bold;'>$txt_MarcaBatteria</p>";
    $mpdf->WriteHTML($marcaBatteria);
    $mpdf->SetFont('Calibri', 'B', 22);
    $mpdf->WriteText(165, 195, $numeroBatterie);

    # Totale Preventivo
    $mpdf->SetFont('Calibri', 'B', 14);
    $valuta_tot_preventivo = number_format($totalePreventivo, 2, ',', '.');
    $mpdf->WriteText(165, 270,   "€ " . $valuta_tot_preventivo);

    $mpdf->SetTextColor('#fe0300');

    # Totale detrazione fiscale
    $valuta_totaleDetrazioniFiscale =  number_format($totaleDetrazioniFiscale, 2, ',', '.');
    $mpdf->WriteText(130, 291, "€ " . $valuta_totaleDetrazioniFiscale);

    $mpdf->SetTextColor('#000000');


    ###################################################################################################
    # PAGINA n.3
    $mpdf->AddPage();
    $mpdf->Image('pagine/3.jpg', 0, 0, 210, 297, 'jpg', '', true, false);


    ###################################################################################################
    # PAGINA n.4
    $mpdf->AddPage();
    $mpdf->Image('pagine/4.jpg', 0, 0, 210, 297, 'jpg', '', true, false);

    $mpdf->SetFont('Calibri', 'B', 14);
    $mpdf->WriteText(10, 72, strtoupper($firmaConsulente));
    $mpdf->WriteText(145, 72, strtoupper($firmaCliente));

    ###################################################################################################
    # PAGINA n.5
    $mpdf->AddPage('P');
    $mpdf->Image('img/logo_must_energia.jpg', 10, 10, 70, 25, 'jpg', '', true, false);
    $mpdf->Image($attach_map, 30, 50);

    ###################################################################################################
    # PAGINA n.6   
    $mpdf->AddPage('P');
    $mpdf->SetTextColor('#92d14f');

    $mpdf->Image('img/logo_must_energia.jpg', 10, 10, 70, 25, 'jpg', '', true, false);

    $mpdf->WriteText(10, 45, "Set Result 2");
    $mpdf->Image($attach_set_result_2, 10, 50); // Griglia set result 2 (autoconsumi)

    $mpdf->WriteText(10, 90, "Set Result 1");
    $mpdf->Image($attach_set_result_1, 10, 95); // Griglia set result 1

    ###################################################################################################
    # PAGINA n.7 
    $mpdf->AddPage('P');
    $mpdf->Image('img/logo_must_energia.jpg', 10, 10, 70, 25, 'jpg', '', true, false);
    $mpdf->WriteText(10, 55, "Set Result 3");
    $mpdf->Image($attach_set_result_3, 10, 60); // Griglia set result 3 


    ###################################################################################################
    # GESTIONE FILE

    $mpdf->SetAuthor('Yunes.it');

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

    $log->scrivi("PDF_energia", 3, "[Body] :", "FINE GENERAZIONE PDF");

    echo json_encode($risposta);
} catch (Throwable $ex) {
    http_response_code(500);
    $sendMail->emailErrore('Errore nella generazione PDF ENERGIA', $ex->getMessage(), $ex->getFile(), $ex->getLine());
}
