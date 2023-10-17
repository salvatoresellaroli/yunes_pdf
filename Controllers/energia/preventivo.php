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
    $obj = json_decode( file_get_contents( 'php://input' ), true );
    $mpdf->SetTitle( 'PDA - Yunes CRM' );
    $mpdf->SetFont( 'Calibri', 'B', 14 );

    ###################################################################################################
    # PAGINA n.1 - Cover
    $mpdf->AddPage();
    $mpdf->Image( 'img/cover_page.jpg', 0, 0, 210, 297, 'jpg', '', true, false );

    $mpdf->SetFont( 'Calibri', 'B', 18 );

    $mpdf->SetTextColor( '#92d14f' );
    # Nome referente
    $mpdf->WriteText( 135, 99, strtoupper( 'NOME REFERENTE' ) );
    $mpdf->SetTextColor( '#000000' );
    # Data preventivo
    $mpdf->WriteText( 145, 118, strtoupper( 'OTT 04,2023' ) );

    # Nome cliente
    $mpdf->SetFont( 'Calibri', 'B', 14 );
    $mpdf->SetTextColor( '#92d14f' );
    $mpdf->WriteText( 20, 222, strtoupper( 'NOME CLIENTE' ) );

    # Indirizzo di fornitura
    $mpdf->WriteText( 20, 253, strtoupper( 'indirIZZO FORNITURA' ) );
    $mpdf->SetTextColor( '#000000' );

    ###################################################################################################
    # PAGINA n.2
    $mpdf->AddPage();
    $mpdf->Image( 'pagine/2.jpg', 0, 0, 210, 297, 'jpg', '', true, false );

    # Potenza P =
    $mpdf->SetFont( 'Calibri', 'R', 22 );
    $mpdf->WriteText( 137.8, 66.4, '16' );

    # SE SCEGLIERE BATTERIA
    $mpdf->WriteText( 43, 77.4, 'BATTERIA D\'ACCUMULO DI 11, 6kW');

    # MODULI FOTOVOLTAICI
    $mpdf->SetY(125);
    $descizionePannello = '<p style ="width: 380px;font-size:18px; margin-left: -25px;font-weight: bold;">F.p.o. di moduli fotovoltaici monocristallino di potenza 430Wp ognuno. ( scheda tecnica allegata )</p>';
    $mpdf->WriteHTML($descizionePannello);    
    $mpdf->SetY(130);
    $marcaPannello = '<p style ="width: 136px;font-size:14px; margin-left: 366px;font-weight: bold;">LONGI modello Hi-Mo6 LR5-54HTH-430M (monocristallino)</p>';
    $mpdf->WriteHTML($marcaPannello);
    $mpdf->SetFont( 'Calibri', 'B', 22 );
    $mpdf->WriteText( 165, 143, '85');

    # INVERTER
    $mpdf->SetY(158);
    $descizioneInverter = '<p style ="width: 380px;font-size:18px; margin-left: -25px;font-weight: bold;">F.p.o. di inverter,6kW completo di garanzia decennale (scheda tecnica allegata)</p>';
    $mpdf->WriteHTML($descizioneInverter);    
    $mpdf->SetY(159);
    $marcaInverter = '<p style ="width: 136px;font-size:14px; margin-left: 366px;font-weight: bold;">SOLAX modello X1-HYBRID-G4-6KTL</p>';
    $mpdf->WriteHTML($marcaInverter);
    $mpdf->SetFont( 'Calibri', 'B', 22 );
    $mpdf->WriteText( 165, 170, '95');

    # BATTERIA
    $mpdf->SetY(184);
    $descizioneBatteria = '<p style ="width: 380px;font-size:18px; margin-left: -25px;font-weight: bold;">F.p.o. di batteria d’accumulo per un totale di 11,6kw.</p>';
    $mpdf->WriteHTML($descizioneBatteria);    
    $mpdf->SetY(185);
    $marcaBatteria = '<p style ="width: 136px;font-size:14px; margin-left: 366px;font-weight: bold;">SOLAX modello T—BAT-SYS-H58 da 5.8kW</p>';
    $mpdf->WriteHTML($marcaBatteria);
    $mpdf->SetFont( 'Calibri', 'B', 22 );
    $mpdf->WriteText( 165, 195, '5');

    # Totale Preventivo
    $mpdf->SetFont( 'Calibri', 'B', 14 );
    $mpdf->WriteText(170, 270, '€ 25.000');

    # Totale detrazione fiscale
    $mpdf->SetTextColor('#fe0300');
    $mpdf->WriteText(130, 291, '€ 5.000'); 
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
    $mpdf->WriteText(10, 72, 'Firma Consulente');
    $mpdf->WriteText(145, 72, 'Firma Cliente');


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
