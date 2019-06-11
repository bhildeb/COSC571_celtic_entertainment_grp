<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>
    <?php include 'header.inc.php'; ?>

    <?php if ($isAdmin) { /* page should only be accessible by an admin */
      require_once('config.php');

      $cname = $cdate = $ctime = $cdescription = $cvenue = "";
      $cname_err = $cdate_err = $ctime_err = $cdescription_err = $cvenue_err = "";

      /* get array of venues for Venue select box */
      $venueList = array();
      $query = "SELECT VenueID, Venue_name FROM Venue";
      $response = mysqli_query($link, $query);

      if($response) {
        while ($row = mysqli_fetch_array($response)) {
          $key = $row["VenueID"];
          $venueList[$key] = $row["Venue_name"];
        }
      }
    ?>

    <main>
      <div class="container">
        <div class="row">
          <div class="col-md-8">

            <div class="tile overlay p-5">
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="row">

                  <div class="col-md-12 mb-3">
                    <h3 class="light-green">Add or Update Concert</h3>
                  </div>

                  <div class="col-md-2 mt-2">
                    <label for="cname">Name</label>
                  </div>

                  <div class="col-md-10 mt-2">
                    <input type="text" name="cname" id="cname" value="<?php echo $cname ?>" />
                  </div>

                  <div class="col-md-2 mb-2"></div>
                  <div class="col-md-10 mb-2 error">
                    <?php echo $cname_err; ?>
                  </div>

                  <div class="col-md-2 mt-2">
                    <label for="cdate">Date</label>
                  </div>

                  <div class="col-md-5 mt-2">
                    <input type="date" name="cdate" id="cdate" value="<?php echo $cdate ?>" />
                  </div>

                  <div class="col-md-1 mt-2">
                    <label for="ctime">Time</label>
                  </div>

                  <div class="col-md-4 mt-2">
                    <input type="text" name="ctime" id="ctime" value="<?php echo $ctime ?>" />
                  </div>

                  <div class="col-md-2 mb-2"></div>
                  <div class="col-md-5 mb-2 error">
                    <?php echo $cdate_err; ?>
                  </div>

                  <div class="col-md-1 mb-2"></div>
                  <div class="col-md-4 mb-2 error">
                    <?php echo $ctime_err; ?>
                  </div>

                  <div class="col-md-2 mt-2">
                    <label for="cdescription">Description</label>
                  </div>

                  <div class="col-md-10 mt-2">
                    <textarea name="cdescription"><?php echo $cdescription; ?></textarea>
                  </div>

                  <div class="col-md-2 mb-2"></div>
                  <div class="col-md-10 mb-2 error">
                    <?php echo $cdescription_err; ?>
                  </div>

                  <div class="col-md-2 mt-2">
                    <label for="cvenue">Venue</label>
                  </div>

                  <div class="col-md-10 mt-2">
                    <select>
                      <?php foreach ($venueList as $key => $value) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="col-md-2 mb-2"></div>
                  <div class="col-md-10 mb-2 error">
                    <?php echo $cvenue_err; ?>
                  </div>
                </div>

                <div class="text-right mt-4">
                  <input type="submit" value="Add / Update" />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php } ?>
  </body>
</html>
