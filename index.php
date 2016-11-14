<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Is website up or is it just me?</title>
    <meta name="description" content="Check if the website is down or up to see if it's available for the world.">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/layout.css">
    <link rel="shortcut icon" href="images/favicon.png">
</head>
<body>

  <div class="wrapper">

    <div class="data"></div>

    <form method="post" action="process.php">
      <input class="url" type="text" name="url" placeholder="Enter domain name (without http) or IP address ..." />
      <input class="submit" name="submit" type="submit" value="Search" />
    </form>

  </div><!-- .wrapper -->

  <script src="assets/js/global.js"></script>
</body>
</html>
