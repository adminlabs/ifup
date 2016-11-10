<?php

function checkStatus( $url ) {
    global $httpcode;

    $agent = 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_8; pt-pt) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_exec($ch);

    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ( $httpcode >= 200 && $httpcode < 300 ) :
      return true;
    else :
      return false;
    endif;
}

if ( checkStatus( 'http://www.google.fi' ) ) :
    echo 'Website is up';
else :
    echo 'Website is down (HTTP CODE: ' . $httpcode . ')';
endif;

exit;
