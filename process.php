<?php
function responsecode( $code = NULL ) {
  if ( $code !== NULL ) {
    switch ($code) {
        case 100:
            $text = 'Continue';
            break;
        case 101:
            $text = 'Switching Protocols';
            break;
        case 200:
            $text = 'OK';
            break;
        case 201:
            $text = 'Created';
            break;
        case 202:
            $text = 'Accepted';
            break;
        case 203:
            $text = 'Non-Authoritative Information';
            break;
        case 204:
            $text = 'No Content';
            break;
        case 205:
            $text = 'Reset Content';
            break;
        case 206:
            $text = 'Partial Content';
            break;
        case 300:
            $text = 'Multiple Choices';
            break;
        case 301:
            $text = 'Moved Permanently';
            break;
        case 302:
            $text = 'Moved Temporarily';
            break;
        case 303:
            $text = 'See Other';
            break;
        case 304:
            $text = 'Not Modified';
            break;
        case 305:
            $text = 'Use Proxy';
            break;
        case 400:
            $text = 'Bad Request';
            break;
        case 401:
            $text = 'Unauthorized';
            break;
        case 402:
            $text = 'Payment Required';
            break;
        case 403:
            $text = 'Forbidden';
            break;
        case 404:
            $text = 'Not Found';
            break;
        case 405:
            $text = 'Method Not Allowed';
            break;
        case 406:
            $text = 'Not Acceptable';
            break;
        case 407:
            $text = 'Proxy Authentication Required';
            break;
        case 408:
            $text = 'Request Time-out';
            break;
        case 409:
            $text = 'Conflict';
            break;
        case 410:
            $text = 'Gone';
            break;
        case 411:
            $text = 'Length Required';
            break;
        case 412:
            $text = 'Precondition Failed';
            break;
        case 413:
            $text = 'Request Entity Too Large';
            break;
        case 414:
            $text = 'Request-URI Too Large';
            break;
        case 415:
            $text = 'Unsupported Media Type';
            break;
        case 500:
            $text = 'Internal Server Error';
            break;
        case 501:
            $text = 'Not Implemented';
            break;
        case 502:
            $text = 'Bad Gateway';
            break;
        case 503:
            $text = 'Service Unavailable';
            break;
        case 504:
            $text = 'Gateway Time-out';
            break;
        case 505:
            $text = 'HTTP Version not supported';
            break;
        default:
            exit('Unknown http status code "'.htmlentities($code).
                '"');
            break;
    }

    $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

    header($protocol.
        ' '.$code.
        ' '.$text);

    $GLOBALS['http_response_code'] = $code;
}
}

$url = $_POST['url'];
$agent = 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_8; pt-pt) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27';

$ch = curl_init();

$options = array(
    CURLOPT_URL            => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERAGENT      => $agent,
    CURLOPT_NOBODY         => true,
    CURLOPT_HEADER         => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_BINARYTRANSFER => true,
    CURLOPT_POST           => false,
    CURLOPT_VERBOSE        => false,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING       => '',
    CURLOPT_AUTOREFERER    => true,
    CURLOPT_NOSIGNAL       => true,
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_TIMEOUT        => 10,
    CURLOPT_MAXREDIRS      => 2,
    CURLOPT_SSL_VERIFYPEER => false,
);

curl_setopt_array( $ch, $options );
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$statusinfo = curl_getinfo($ch);
$bodyclosingcheck = '/<\/body>(?![\s\S]*<\/body>[\s\S]*$)/i';
$htmlsource = file_get_contents($url);
$checkbody = preg_match($bodyclosingcheck, $htmlsource, $matches);

curl_close($ch);

// TODO:
// - Add honeypot
// - Add security measures
// - Add URL validation

// Check if there's input
if ( $url != '' ) {

  // Check if site is something else than 200 (OK) or 0 (non existing) or less than 300 (not multiple)
  if ( $httpcode != 200 && $httpcode != 0 && $httpcode > 300 ) {

      echo '<h1 class="error">Site is down for everyone!</h1>
      <p>Return code is ' . responsecode($httpcode) . '. Give this to your website host administrator.</p>';
      curl_error($ch);

  // Check if url is timing out
  } elseif( $httpcode == 28 ) {

    echo '<h1 class="error">Timed out.</h1>
    <p>That means site is most probably down for everyone.</p>';

  // Check if url is not existing at all
  } elseif( $httpcode == 0 ) {

    echo '<h1 class="error">Site does not exist.</h1>
    <p>A typo, or tried with non-existent site, huh?</p>';

  // Check if </body> is not found
  } elseif ( $checkbody == 0 ) {

    echo '<h1 class="error">Site is down or broken.</h1>
    <p>&lt;/body&gt; tag not found.</p>';

  // Other cases should indicate everything is up
  } else {
      echo '<h1 class="success">Site is up!</h1>';

      // Fancy load time indicator
      $loadtime_seconds = $statusinfo['total_time'];
      if ( $loadtime_seconds < 1) :

        // If load time is under second, let's calculate milliseconds
        $loadtime = $loadtime_seconds * 100 . 'ms';

        // It's super good speed, so let's have some green
        $speed = 'success';
        $message = 'You have a really fast site! congrats!';

      elseif ( $loadtime_seconds > 1 && $loadtime_seconds < 2) :

        // Slower than one seconds, so let's show time in seconds
        $loadtime = $loadtime_seconds . 's';

        // It's slower than fast sites, so let's show orange
        $speed = 'warning';
        $message = 'Decent load time.';

      else :

        // Otherwise we'll show just seconds
        $loadtime = $loadtime_seconds . 's';

        // It's slooow, so red it is
        $speed = 'error';
        $message = 'A bit slow site... maybe you should optimize.';

      endif;

      echo '<div class="load-time '. $speed .'">
        <h3 class="'. $speed .'">' . $loadtime . '</h3>
        <p class="'. $speed .'">' . $message . '</p>
      </div>

      <p class="close" onclick="this.parentNode.style.display = \'none\';"><svg width="10" height="10" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.954 21.03l-9.184-9.095 9.092-9.174L21.03-.046l-9.09 9.179L2.764.045l-2.81 2.81L9.14 11.96.045 21.144l2.81 2.81 9.112-9.192 9.18 9.1z"/></svg>Close</p>

      <pre class="details">' . htmlspecialchars($response) .'</pre>';
  }

}

// HTML source:
// echo '<pre>' . htmlspecialchars($htmlsource) . '</pre>';

curl_close($ch);
