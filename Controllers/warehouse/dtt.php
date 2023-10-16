<?php
include '../../Core/init.php';
require_once __DIR__ . '/vendor/autoload.php';
try {
    $mpdf = new \Mpdf\Mpdf( [
        'default_font' => 'dejavusans'
    ] );

    $mpdf->imageVars[ 'hr' ] = file_get_contents( 'img/hr.jpg' );

    if ( $_SERVER[ 'REQUEST_METHOD' ] === 'OPTIONS' ) {
        return 0;
    }

    $dati = json_decode( file_get_contents( 'php://input' ), true );

    $obj = $dati;

    $indirizzoProv = $obj[ 'zip_prov' ].' '.$obj[ 'city_prov' ].' ('.$obj[ 'distrinct_prov' ].')';
    $indirizzoDest = $obj[ 'zip_dest' ].' '.$obj[ 'city_dest' ].' ('.$obj[ 'distrinct_dest' ].')';
    //* ///////////////////////////////////////////////////////////////////////////
    $mpdf->SetHTMLFooter( '<hr>
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
	</table>' );
    //* ///////////////////////////////////////////////////////////////////////////
    $mpdf->SetTitle( 'Generazione DDT' );
    $mpdf->AddPage();
    # Sfondo
    $mpdf->Image( 'img/cover_page.png', 0, 0, 210, 275, 'png', '', true, false );
    # Titolo
    $mpdf->WriteText( 80, 15, 'DOCUMENTO DI TRASPORTO' );
    # Numero doc
    $mpdf->SetFont( 'Helvetica', 'B', 13 );
    $mpdf->WriteText( 12, 29, $obj[ 'wh_ddt_number' ] );
    # Destinatario
    $mpdf->SetFont( 'Helvetica', 'B', 13 );
    $mpdf->WriteText( 10, 43, strtoupper( $obj[ 'wh_ddt_warehouse_prov' ] ) );
    $mpdf->SetFont( 'Helvetica', 'R', 13 );
    $mpdf->WriteText( 10, 50, ucfirst( $obj[ 'address_prov' ] ) );
    $mpdf->WriteText( 10, 58, $indirizzoProv );
    $mpdf->WriteText( 10, 65, $obj[ 'region_prov' ].' - '. $obj[ 'country_prov' ] );
    # Destinazione
    $mpdf->SetFont( 'Helvetica', 'B', 13 );
    $mpdf->WriteText( 120, 43, strtoupper( $obj[ 'wh_ddt_warehouse_dest' ] ) );
    $mpdf->SetFont( 'Helvetica', 'R', 13 );
    $mpdf->WriteText( 120, 50, ucfirst( $obj[ 'address_dest' ] ) );
    $mpdf->WriteText( 120, 58, $indirizzoDest );
    $mpdf->WriteText( 120, 65, $obj[ 'region_dest' ].' - '. $obj[ 'country_dest' ] );

    # Riga prodotti
    $ya = 75;
    $riga = 10;

    foreach ( $obj[ 'wh_ddt_entries' ] as $entry ) {

        $ya = $ya + $riga;

        $mpdf->WriteText( 10,  $ya, $entry[ 'code' ] );
        $mpdf->WriteText( 65,  $ya, $entry[ 'name' ] );
        $mpdf->WriteText( 190,  $ya, $entry[ 'quantity' ] );

    }

    //! FASE GENERAZIONE FILE
    $cartellaFile = $obj[ 'pathfile' ];
    # Verifico se la cartella del paziente esiste altrimenti la creo
    verificaCartella( DIR_FILE . $cartellaFile );
    # Percorso salvataggio pdf
    $dir = DIR_FILE . $cartellaFile;
    # Nome file
    $nome_file = getToken() . '_' . date( 'd_m_Y_H_i_s' ) . '.pdf';
    # Percorso completo del file
    $file =  $dir . $nome_file;

    if ( $isDEBUG ) {
        $file =  DIR_FILE . $nome_file;
    }

    # Genero pdf
    $mpdf->Output( $file);

	$risposta->codiceErrore = errore::Success;
	$risposta->dati = $cartellaFile . $nome_file;
	$risposta->messaggio = 'Doc' . str_replace("/", "_", $obj['nomefile'] . "_" . date("d_m_Y") . '.pdf' );
    echo json_encode( $risposta );
} catch ( Throwable $ex ) {
    $ex->getMessage();
}
