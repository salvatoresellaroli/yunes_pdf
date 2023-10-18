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

    $dati = json_decode( file_get_contents( 'php://input' ), true );

    $obj = $dati;

    $indirizzoProv = $obj[ 'zip_prov' ].' - '.$obj[ 'city_prov' ].' ('.$obj[ 'distrinct_prov' ].')';
    $indirizzoDest = $obj[ 'zip_dest' ].' - '.$obj[ 'city_dest' ].' ('.$obj[ 'distrinct_dest' ].')';
    
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
    # Numero doc
    $mpdf->SetFont( 'Calibri', 'B', 13 );
    $mpdf->WriteText( 120, 30, $obj[ 'wh_ddt_number' ] );
    # Data documento
    $mpdf->WriteText( 165, 30, $obj[ 'wh_ddt_created' ] );
    # Destinatario
    $mpdf->SetFont( 'Calibri', 'B', 13 );
    $mpdf->WriteText( 5, 43, strtoupper( $obj[ 'wh_ddt_warehouse_prov' ] ) );
    $mpdf->SetFont( 'Calibri', 'R', 13 );
    $mpdf->WriteText( 5, 50, ucfirst( $obj[ 'address_prov' ] ) );
    $mpdf->WriteText( 5, 58, $indirizzoProv );

    # Destinazione
    $mpdf->SetFont( 'Calibri', 'B', 13 );
    $mpdf->WriteText( 115, 43, strtoupper( $obj[ 'wh_ddt_warehouse_dest' ] ) );
    $mpdf->SetFont( 'Calibri', 'R', 13 );
    $mpdf->WriteText( 115, 50, ucfirst( $obj[ 'address_dest' ] ) );
    $mpdf->WriteText( 115, 58, $indirizzoDest );
    
    # Regione di Provenienza

    if ( $obj[ 'region_prov' ] != '' ) {
        $regioneProv =  $obj[ 'region_prov' ].' - '. $obj[ 'country_prov' ] ;
    } else {
        $regioneProv = '';
    }
   
    
    $mpdf->WriteText( 5, 65, $regioneProv);
    
    
    # Regione di Destinazione
    if ( $obj[ 'region_dest' ] != '' ) {
        $regioneDest = $obj[ 'region_dest' ].' - '. $obj[ 'country_dest' ];
    } else {
        $regioneDest = '';
    }

    $mpdf->WriteText( 115, 65, $regioneDest );

    # Riga prodotti
    $ya = 75;
    $riga = 10;

    $totPezzi = 0;

    foreach ( $obj[ 'wh_ddt_entries' ] as $entry ) {

        $ya = $ya + $riga;

        $mpdf->WriteText( 10,  $ya, $entry[ 'code' ] );
        $mpdf->WriteText( 65,  $ya, $entry[ 'name' ] );
        $mpdf->WriteText( 190,  $ya, $entry[ 'quantity' ] );

        $totPezzi = $totPezzi + $entry[ 'quantity' ];

    }

    # Totale Pezzi
    $mpdf->SetFont( 'Calibri', 'B', 16 );
    $mpdf->WriteText( 20, 250, strval( $totPezzi ) );

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
    $mpdf->Output( $file, 'I' );

    $risposta->codiceErrore = errore::Success;
    $risposta->dati = $cartellaFile . $nome_file;
    $risposta->messaggio = 'Doc' . str_replace( '/', '_', $obj[ 'nomefile' ] . '_' . date( 'd_m_Y' ) . '.pdf' );
    echo json_encode( $risposta );
} catch ( Throwable $ex ) {
    $ex->getMessage();
}
