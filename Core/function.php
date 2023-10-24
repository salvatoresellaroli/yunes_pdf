<?php

function isEmpty( $var ) {
    if ( $var == '' || $var == null ) {
        return true;
    }
    return false;
}

function pulisci( $value, $type, $db = '' ) {
    try {

        switch ( $type ) {

            case 'string':

            $res = filter_var( $value, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            break;

            case 'email':

            $res = filter_var( $value, FILTER_SANITIZE_EMAIL );
            break;

            case 'number':

            if ( isset( $value ) ) {
                $res = filter_var( $value, FILTER_SANITIZE_NUMBER_INT );
            } else {

                $res = 'NULL';
            }

            break;
            case 'bool':

            $res = filter_var( $value, FILTER_VALIDATE_BOOLEAN );

            switch ( $res ) {
                case '':
                case false:
                $res = 0;
                break;

                default:
                $res = 1;
                break;
            }

            break;
        }

        // if ( !isEmpty( $db ) ) {

        //     $res = $db->real_escape_string( trim( strip_tags( $res ) ) );
        // }

        return $res;
    } catch ( Exception $ex ) {
        throw new Exception( $ex->getMessage() );
    }
}
/**
* Method dataAttuale
*
* @param $tipo $tipo [ explicite description ]
*
* @return void
*/

function dataAttuale( $tipo ) {
    switch ( $tipo ) {
        case 'IT':
        $d = date( 'd-m-Y' );
        //25-05-2020
        break;
        case 'IT-TIME':
        $d = date( 'd/m/Y H:i' );
        //25-05-2020 11:41
        break;
        case 'US':
        $d = date( 'Y-m-d' );
        //2020-05-25
        break;
        case 'US-TIME':
        $d = date( 'Y-m-d H:i:s' );
        //2020-05-25 11:41
        break;
    }
    return $d;
}

function dataUsToIta( $value ) {
    try {
        // 2022-04-20 16:04:00 to 20/04/2022 16:04:00

        $split = explode( ' ', $value );

        $data = explode( '-', $split[ 0 ] );

        return $data[ 2 ] . '/' . $data[ 1 ] . '/' . $data[ 0 ] . ' ' . substr( $split[ 1 ], 0, 5 );
    } catch ( Exception $ex ) {
        throw new Exception( $ex->getMessage() );
    }
}

function apic( $var ) {
    $varClear = str_replace( "'", "''", $var );
    return "'$var'";
}

function generateToken( $length ) {
    $token = '';
    $possibleChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $i = 0;
    while ( $i < $length ) {
        $char = substr( $possibleChars, mt_rand( 0, strlen( $possibleChars ) - 1 ), 1 );
        if ( !strstr( $token, $char ) ) {
            $token .= $char;
            $i++;
        }
    }
    return $token;
}

function generateOTP( $length ) {
    $token = '';
    $possibleChars = '0123456789';
    $i = 0;
    while ( $i < $length ) {
        $char = substr( $possibleChars, mt_rand( 0, strlen( $possibleChars ) - 1 ), 1 );
        if ( !strstr( $token, $char ) ) {
            $token .= $char;
            $i++;
        }
    }
    return $token;
}

function erroreTrovato( $valore, $risposta ) {
    $risposta->dati = '';
    $risposta->messaggio = $valore->getMessage();
    return $risposta;
}

function getToken() {

    $token = bin2hex( random_bytes( 16 ) );

    return $token;
}

function getHeader( $type ) {
    try {
        foreach ( getallheaders() as $name => $value ) {

            if ( strtolower( $name ) == strtolower( $type ) ) {

                return filter_var( $value, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            }
        }
        return '';
    } catch ( Exception $ex ) {
        throw new Exception( $ex->getMessage() );
    }
}

// function somma_time() {
//     try {
//         // Somma time es. 01:00 + 00:30 = 01:30
//         $i = 0;
//         foreach ( func_get_args() as $time ) {
//             sscanf( $time, '%d:%d', $hour, $min );
//             $i += $hour * 60 + $min;
//         }

//         if ( $h = floor( $i / 60 ) ) {
//             $i % = 60;
//         }

//         return sprintf( '%02d:%02d', $h, $i );
//     } catch ( Exception $ex ) {
//         throw new Exception( $ex->getMessage() );
//     }
// }

function oreINmin( $value ) {
    // Conversione di ore in minuti es.  04:00:00 diventa 240 minuti
    try {
        if ( !isEmpty( $value ) ) {

            $split = explode( ':', $value );

            $res = $split[ 0 ] * 60 + $split[ 1 ];

            return $res;
        } else {
            return 0;
        }
    } catch ( Exception $ex ) {
        throw new Exception( $ex->getMessage() );
    }
}

function check_ext( $tipo ) {

    switch ( $tipo ) {
        case 'application/msword':
        return true;
        break;
        case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
        return true;
        break;
        case 'application/pdf':
        return true;
        break;
        case 'image/png':
        return true;
        break;
        case 'image/jpg':
        return true;
        break;
        case 'image/jpeg':
        return true;
        break;
        case 'image/gif':
        return true;
        break;

        default:
        return false;
        break;
    }
}
// La funzione get_ext formatta l’estensione dell’immagine, infatti normalmente la variabile $_FILE
// memorizza l’estensione come image/estensione, la funzione restituisce un risultato come .png.

function get_ext( $tipo ) {
    switch ( $tipo ) {
        case 'application/msword':
        return 'doc';
        break;
        case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
        return '.docx';
        break;
        case 'application/pdf':
        return '.pdf';
        break;
        case 'image/png':
        return '.png';
        break;
        case 'image/jpg':
        return '.jpg';
        break;
        case 'image/jpeg':
        return '.jpg';
        break;
        case 'image/gif':
        return '.gif';
        break;

        default:
        return false;
        break;
    }
}

function verificaCartella( $path ) {

    if ( !file_exists( $path ) ) {
        mkdir( $path, 0777 );
    }
}

function svuotaCartella( $dirpath ) {
    $date = date( 'Y-m-d', strtotime( '-3 days' ) );
    try {
        $handle = opendir( $dirpath );

        while ( ( $file = readdir( $handle ) ) !== false ) {

            if ( $file != '.' && $file != '..' && $file < $date ) {

                $files = glob( $dirpath . $file . '/*' );
                //get all file names
                foreach ( $files as $filea ) {
                    if ( is_file( $filea ) )
                    unlink( $filea );
                    //delete file
                }

                rmdir( $dirpath . $file );
            }
        }

        closedir( $handle );
    } catch ( Throwable $ex ) {
        echo $ex->getMessage();
    }
}

function dataAttualePDF() {

    date_default_timezone_set( 'Europe/Rome' );

    // Ottieni la data corrente formattata
    $formattedDate = date( 'M d, Y' );
    // Ad esempio, 'Oct 23, 2023'

    // Effettua la conversione del mese in italiano
    $italianMonths = [
        'Jan' => 'GEN',
        'Feb' => 'FEB',
        'Mar' => 'MAR',
        'Apr' => 'APR',
        'May' => 'MAG',
        'Jun' => 'GIU',
        'Jul' => 'LUG',
        'Aug' => 'AGO',
        'Sep' => 'SET',
        'Oct' => 'OTT',
        'Nov' => 'NOV',
        'Dec' => 'DIC'
    ];

    $formattedDate = strtr( $formattedDate, $italianMonths );


    return $formattedDate;


}