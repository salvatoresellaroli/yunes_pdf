<?php
include '../../Core/init.php';
require_once __DIR__ . '/vendor/autoload.php';
try {

    $mpdf = new \Mpdf\Mpdf( [
        'default_font' => 'Calibri'
    ] );

    if ( $_SERVER[ 'REQUEST_METHOD' ] === 'OPTIONS' ) {
        return 0;
    }

    # Dati
    $dati = json_decode( file_get_contents( 'php://input' ), true );
    
    $obj = $dati['DocumentElement']['value'];

    $nome_referente = 'NOME REFERENTE';
    $data_preventivo = 'OTT 04,2023';
    $nome_cliente = 'NOME CLIENTE';
    $indirizzo_cliente = $obj['indirizzo'];
    $potenzaP = $obj['dimensioneFV_kWp_ibrio'];
    $batteria_kw = $obj['batteria']. ' kW';
    $txt_DescrizionePannello = 'F.p.o. di moduli fotovoltaici monocristallino di potenza 430Wp ognuno. ( scheda tecnica allegata )';
    $txt_MarcaPannello = 'LONGI modello Hi-Mo6 LR5-54HTH-430M (monocristallino)';
    $numeroPannelli = '85';
    $txt_DescrizioneInverter = 'F.p.o. di inverter,6kW completo di garanzia decennale (scheda tecnica allegata)';
    $txt_MarcaInverter = 'SOLAX modello X1-HYBRID-G4-6KTL'; 
    $numeroInverter = '2';
    $txt_DescrizioneBatteria = 'F.p.o. di batteria d’accumulo per un totale di 11,6kw.';
    $txt_MarcaBatteria = 'SOLAX modello T—BAT-SYS-H58 da 5.8kW';
    $numeroBatterie = '8';
    $totalePreventivo = '€ 25.000';
    $totaleDetrazioniFiscale = '€ 12.500';
    $firmaConsulente = 'Firma Consulente';
    $firmaCliente = 'Firma Cliente';
    $attach_map = $obj['attach_map'];
    $attach_set_result_1 = $obj['attach_set_result_1'];
    $attach_set_result_2 = $obj['attach_set_result_2'];
    $attach_set_result_3 = $obj['attach_set_result_3'];

    $mpdf->SetTitle( 'PDA - Yunes CRM' );
    $mpdf->SetFont( 'Calibri', 'B', 14 );
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
    $mpdf->Image( 'img/cover_page.jpg', 0, 0, 210, 297, 'jpg', '', true, false );

    $mpdf->SetFont( 'Calibri', 'B', 18 );

    $mpdf->SetTextColor( '#92d14f' );
    # Nome referente
    $mpdf->WriteText( 135, 99, strtoupper( $nome_referente  ) );
    $mpdf->SetTextColor( '#000000' );
    # Data preventivo
    $mpdf->WriteText( 145, 118, strtoupper( $data_preventivo ) );

    # Nome cliente
    $mpdf->SetFont( 'Calibri', 'B', 14 );
    $mpdf->SetTextColor( '#92d14f' );
    $mpdf->WriteText( 20, 222, strtoupper( $nome_cliente ) );

    # Indirizzo di fornitura
    $mpdf->WriteText( 20, 253, strtoupper( $indirizzo_cliente ) );
    $mpdf->SetTextColor( '#000000' );

    ###################################################################################################
    # PAGINA n.2
    $mpdf->AddPage();
    $mpdf->Image( 'pagine/2.jpg', 0, 0, 210, 297, 'jpg', '', true, false );

    # Potenza P =
    $mpdf->SetFont( 'Calibri', 'R', 22 );
    $mpdf->WriteText( 137.8, 66.4, $potenzaP );

    # SE SCEGLIERE BATTERIA
    $mpdf->WriteText( 43, 77.4, 'BATTERIA D\'ACCUMULO DI ' . $batteria_kw);

    # MODULI FOTOVOLTAICI
    $mpdf->SetY(125);
    $descizionePannello = '<p style ="width: 380px;font-size:18px; margin-left: -25px;font-weight: bold;"> '. $txt_DescrizionePannello .'</p>';
    $mpdf->WriteHTML($descizionePannello);    
    $mpdf->SetY(130);
    $marcaPannello = '<p style ="width: 136px;font-size:14px; margin-left: 366px;font-weight: bold;">'.$txt_MarcaPannello.'</p>';
    $mpdf->WriteHTML($marcaPannello);
    $mpdf->SetFont( 'Calibri', 'B', 22 );
    $mpdf->WriteText( 165, 143, $numeroPannelli);

    # INVERTER
    $mpdf->SetY(158);
    $descizioneInverter = '<p style ="width: 380px;font-size:18px; margin-left: -25px;font-weight: bold;">'.$txt_DescrizioneInverter.'</p>';
    $mpdf->WriteHTML($descizioneInverter);    
    $mpdf->SetY(159);
    $marcaInverter = '<p style ="width: 136px;font-size:14px; margin-left: 366px;font-weight: bold;">'.$txt_MarcaInverter .'</p>';
    $mpdf->WriteHTML($marcaInverter);
    $mpdf->SetFont( 'Calibri', 'B', 22 );
    $mpdf->WriteText( 165, 170, $numeroInverter);

    # BATTERIA
    $mpdf->SetY(184);
    $descrizioneBatteria = '<p style ="width: 380px;font-size:18px; margin-left: -25px;font-weight: bold;">'.$txt_DescrizioneBatteria.'</p>';
    $mpdf->WriteHTML($descrizioneBatteria);    
    $mpdf->SetY(185);
    $marcaBatteria = '<p style ="width: 136px;font-size:14px; margin-left: 366px;font-weight: bold;">'.$txt_MarcaBatteria.'</p>';
    $mpdf->WriteHTML($marcaBatteria);
    $mpdf->SetFont( 'Calibri', 'B', 22 );
    $mpdf->WriteText( 165, 195, $numeroBatterie);

    # Totale Preventivo
    $mpdf->SetFont( 'Calibri', 'B', 14 );
    $mpdf->WriteText(170, 270, $totalePreventivo);

    # Totale detrazione fiscale
    $mpdf->SetTextColor('#fe0300');
    $mpdf->WriteText(130, 291, $totaleDetrazioniFiscale); 
    $mpdf->SetTextColor('#000000');
    
    
    ###################################################################################################
    # PAGINA n.3
    $mpdf->AddPage();
    $mpdf->Image( 'pagine/3.jpg', 0, 0, 210, 297, 'jpg', '', true, false );


    ###################################################################################################
    # PAGINA n.4
    $mpdf->AddPage();
    $mpdf->Image( 'pagine/4.jpg', 0, 0, 210, 297, 'jpg', '', true, false );

    $mpdf->SetFont( 'Calibri', 'B', 14 );
    $mpdf->WriteText(10, 72, $firmaConsulente);
    $mpdf->WriteText(145, 72, $firmaCliente);

    ###################################################################################################
    # PAGINA n.5
    $mpdf->AddPage('P');
    $mpdf->Image( 'img/logo_must_energia.jpg', 10, 10, 70, 25, 'jpg', '', true, false );
    $mpdf->Image($attach_map,30,50);
    $mpdf->AddPage('P');
    $mpdf->Image( 'img/logo_must_energia.jpg', 10, 10, 70, 25, 'jpg', '', true, false );
    $mpdf->Image($attach_set_result_1,10,50);
    $mpdf->Image($attach_set_result_2,10,100);
    $mpdf->AddPage('P');
    $mpdf->Image( 'img/logo_must_energia.jpg', 10, 10, 70, 25, 'jpg', '', true, false );
    $mpdf->Image($attach_set_result_3,10,60);
    ###################################################################################################
    # GESTIONE FILE

    $mpdf->SetAuthor( 'Yunes.it' );

    $cartellaFile = $obj[ 'pathfile' ];

    if ( !$isDEBUG ) {
        # Verifico se la cartella del paziente esiste altrimenti la creo
        verificaCartella( DIR_FILE . $cartellaFile );
    }

    # Percorso salvataggio pdf
    $dir = DIR_FILE . $cartellaFile;

    # Nome file
    $nome_file = getToken() . '.pdf';

    # Percorso completo del file
    $file =  $dir . $nome_file;

    if ( $isDEBUG ) {
        $file =  DIR_FILE . $nome_file;
    }

    # Genero pdf
    $mpdf->Output( $file);
    $risposta->codiceErrore = errore::Success;
    $risposta->dati = $cartellaFile . $nome_file;
    $risposta->messaggio = $nome_file;

    echo json_encode( $risposta );

} catch ( Throwable $ex ) {
    http_response_code( 500 );
    $sendMail->emailErrore( 'Errore nella generazione PDF ABBONAMENTO', $ex->getMessage(), $ex->getFile(), $ex->getLine() );
}
