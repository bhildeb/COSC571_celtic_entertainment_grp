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
            <div class="tile overlay">
              <h3 class="mx-3 py-4">Login Successful</h3>

              <div class="mx-3 pt-3 pb-4">
                Welcome
                <?php
                  if(isset($_SESSION['id'])) {
                    echo "<span class='light-green'>".$_SESSION['fname']." ".$_SESSION['lname']."</span>";
                  }
                ?>
                . You've made your first step towards
                experiencing the finest folk music the Midwest has to offer.
              </div>
              <div class="mx-3 pt-3 pb-4">
                Browse our <a href="concerts.php">schedule of events</a>
                to buy your tickets today!
              </div>
            </div>
          </div>

          <div class="col-md-4"></div>
        </div>
      </div>
    </main>
  </body>
</html>
