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
                  if (isset($_SESSION['id'])) {
                    echo "<span class='light-green'>".$_SESSION['fname']." ".$_SESSION['lname']."</span>.";
                  }
                ?>

                <?php if ($isAdmin) { ?>
                  As an administrator you have access to add, delete, and modify content on our site.<br><br>
                  Navigate to a page to begin.
                <?php } elseif ($isEmployee) { ?>
                  As an employee of Celtic Entertainment Group you have exclusive access
                  to view unpublished future content and <a href="concerts.php">events</a>.
                <?php } else { ?>
                  You've made your first step towards
                  experiencing the finest folk music the Midwest has to offer.<br><br>
                  Browse our <a href="concerts.php">schedule of events</a>
                  to buy your tickets today!
                <?php } ?>
              </div>
            </div>
          </div>

          <div class="col-md-4"></div>
        </div>
      </div>
    </main>
  </body>
</html>
