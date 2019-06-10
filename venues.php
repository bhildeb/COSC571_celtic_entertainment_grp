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
            <h3 class="green">Venues</h3>
            <div class="row px-1">
              <div class="col-md-3 my-2 py-3 font-weight-bold green">Name</div>
              <div class="col-md-2 my-2 py-3 font-weight-bold green">Street</div>
              <div class="col-md-2 my-2 py-3 font-weight-bold green">City</div>
              <div class="col-md-1 my-2 py-3 font-weight-bold green">State</div>
              <div class="col-md-1 my-2 py-3 font-weight-bold green">Zip</div>
              <div class="col-md-2 my-2 py-3 font-weight-bold green">Max Occupancy</div>
              <div class="col-md-1"></div>
            </div>

            <?php
            $query = "SELECT * FROM Venue";
            $response = mysqli_query($link, $query);
            $index = 0;

            if ($response) {
              while ($row = mysqli_fetch_array($response)) {
                /* only apply gray-background class to even elements */ ?>
                <div class="row px-1 <?php if ($index%2 == 0) echo "gray-background" ?>">
                  <div class="col-md-3 my-2 py-3 green"><?php echo $row['Venue_name']; ?></div>
                  <div class="col-md-2 my-2 py-3 green"><?php echo $row['Address']; ?></div>
                  <div class="col-md-2 my-2 py-3 green">TODO</div>
                  <div class="col-md-1 my-2 py-3 green">TODO</div>
                  <div class="col-md-1 my-2 py-3 green">TODO</div>
                  <div class="col-md-2 my-2 py-3 green text-center"><?php echo $row['Max_attendees']; ?></div>
                  <div class="col-md-1 my-2">
                    <a href="">
                      <img class="google-map-icon" src="images/google-map-icon.png" alt="find venue on google maps">
                    </a>
                  </div>
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
