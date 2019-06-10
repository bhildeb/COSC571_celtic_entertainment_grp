<?php
  session_start();
  session_destroy();
?>

<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>
    <?php include 'header.inc.php'; ?>

    <main>
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <div class="tile overlay p-5">
              <div class="row">
                You have successfully logged out.
              </div>
            </div>
          </div>

          <div class="col-md-4"></div>
        </div>
      </div>
    </main>
  </body>
</html>
