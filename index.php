<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Is website up or is it just me?</title>
    <meta name="description" content="Check if the website is down or up to see if it's available for the world.">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="shortcut icon" href="favicon.png">
</head>
<body>

  <div class="wrapper">

    <div class="loader loader-default is-active"></div>
    <div class="data"><h1 class="error nocontent"></h1>
      <div class="load-time error nocontent">
        <h3 class="error">error</h3>
        <p class="message"></p>
      </div>

        <p class="close nocontent" onclick="this.parentNode.style.display = \'none\';"><svg width="10" height="10" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.954 21.03l-9.184-9.095 9.092-9.174L21.03-.046l-9.09 9.179L2.764.045l-2.81 2.81L9.14 11.96.045 21.144l2.81 2.81 9.112-9.192 9.18 9.1z"/></svg>Close</p>
          <p class="powered-by nocontent">ifup.io is powered by <a href="https://www.adminlabs.com">Admin Labs</a>.</p>
      </div>

      <?php $url = $_GET["url"]; ?>

    <form method="post" action="process.php">
      <input class="url" type="url" name="url" id="url" pattern="^(https?://)?([a-zA-Z0-9]([a-zA-ZäöüÄÖÜ0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$" required name="url" placeholder="http://yoursite.com" <?php if( ! empty( $url ) ) : echo 'value="' . $url . '"'; endif; ?>/>
      <input class="submit" name="submit" type="submit" value="Check if up" />
    </form>

  </div><!-- .wrapper -->

  <script src="assets/js/global.js"></script>
</body>
</html>
