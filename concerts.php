<?php require_once('config.php'); ?>

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
        <div class="col-md-12">
          <div class="tile CEG-table">
            <h3 class="green">Concert Schedule</h3>
            <div class="row px-1">
              <div class="col-md-2 my-2 py-3 font-weight-bold green">Name</div>
              <div class="col-md-2 my-2 py-3 font-weight-bold green">Date</div>
              <div class="col-md-2 my-2 py-3 font-weight-bold green">Time</div>
              <div class="col-md-2 my-2 py-3 font-weight-bold green">Location</div>
              <div class="col-md-4 my-2 py-3 font-weight-bold green">Tickets Available</div>
            </div>

            <?php
            $query = "SELECT * FROM Concert";
            $response = mysqli_query($link, $query);
            $index = 0;

            if ($response) {
              while ($row = mysqli_fetch_array($response)) {
                /* only apply gray-background class to even elements */ ?>
                <div class="row px-1 <?php if ($index%2 == 0) echo "gray-background" ?>">
                  <div class="col-md-2 my-2 py-3 green"><?php echo $row['Concert_name']; ?></div>
                  <div class="col-md-2 my-2 py-3 green">7/13/2019</div>
                  <div class="col-md-2 my-2 py-3 green">7pm-9pm</div>
                  <div class="col-md-2 my-2 py-3 green">Michigan Theater</div>
                  <div class="col-md-2 my-2 py-3 green">60</div>
                  <div class="col-md-2 my-2"><button>Buy Tickets</button></div>
                </div>
                <?php
                $index++;
              }
            } ?>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
