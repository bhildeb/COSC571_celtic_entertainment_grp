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

      $cname = $cdate = $ctime = $cdescription = $cvenue = $selectedVenue = $cpublished = "";
      $cname_err = $cdate_err = $ctime_err = $cdescription_err = $cvenue_err = "";
      $errors = array();
      $editMode = false;

      /* get array of venues for Venue select box */
      $venueList = array();
      $query = "SELECT VenueID, Venue_name FROM Venue";
      $response = mysqli_query($link, $query);

      if ($response) {
        while ($row = mysqli_fetch_array($response)) {
          $key = $row["VenueID"];
          $venueList[$key] = $row["Venue_name"];
        }
      }

      if (isset($_GET['edit'])) {
        $editMode = true;
        $concertEditId = $_GET['edit'];
        $query = "SELECT Concert_name, Description, Published FROM Concert WHERE ConcertID = ?";

        if ($stmt = mysqli_prepare($link, $query)) {
          mysqli_stmt_bind_param($stmt, "i", $concertEditId);

          if (mysqli_stmt_execute($stmt)) {
            if ($result = mysqli_stmt_get_result($stmt)) {
              $row = mysqli_fetch_array($result);
              $cname = $row['Concert_name'];
              $cdescription = $row['Description'];
              $cpublished = $row['Published'];

              $query = "SELECT VenueID, Date, Time FROM Schedule WHERE ConcertID = ?";

              if ($stmt = mysqli_prepare($link, $query)) {
                mysqli_stmt_bind_param($stmt, "i", $concertEditId);

                if (mysqli_stmt_execute($stmt)) {
                  if ($result = mysqli_stmt_get_result($stmt)) {
                    $row = mysqli_fetch_array($result);
                    $ctime = $row['Time'];
                    $cdate = $row['Date'];
                    $selectedVenue = $row['VenueID'];
                  }
                }
              }
            }
          }
        }
      }

      /* add concert and schedule to database */
      if (isset($_POST['addConcert'])) {
        $concertName = $_POST['cname'];
        $concertDescription = $_POST['cdescription'];
        $venueID = $_POST['cvenue'];
        $concertDate = $_POST['cdate'];
        $concertTime = $_POST['ctime'];

        if (isset($_POST['cpublish'])) {
          $concertPublished = true;
        } else {
          $concertPublished = false;
        }

        /* get size of Concert table */
        $query = "SELECT * FROM Concert";
        $result = mysqli_query($link, $query);
        $table_size = mysqli_num_rows($result);

        $concertID = $table_size + 1;
        $index = 0;

        /* check for available ids created as a result of deletions
           otherwise use size of table + 1 as id */
        while ($concertID == ($table_size + 1)) {
          $query = "SELECT * FROM Concert WHERE ConcertID = ".intval($index);
          $result = mysqli_query($link, $query);

          $id_already_exists = (mysqli_num_rows($result) > 0);

          if (!$id_already_exists) {
            $concertID = $index;
          } else {
            $index++;
          }
        }

        $query = "INSERT INTO Concert (ConcertID, Concert_name, Description, Published) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, 'issi', $concertID, $concertName, $concertDescription, $concertPublished);
        mysqli_stmt_execute($stmt);

        $affected_rows = mysqli_stmt_affected_rows($stmt);

        if ($affected_rows != 1) {
          array_push($errors, "Error in adding concert to database");
        } else {
          mysqli_stmt_close($stmt);

          /* get size of Schedule table */
          $query = "SELECT * FROM Schedule";
          $result = mysqli_query($link, $query);
          $table_size = mysqli_num_rows($result);

          $scheduleID = $table_size + 1;
          $index = 0;

          /* check for available ids created as a result of deletions
             otherwise use size of table + 1 as id */
          while ($scheduleID == ($table_size + 1)) {
            $query = "SELECT * FROM Schedule WHERE ScheduleID = ".intval($index);
            $result = mysqli_query($link, $query);

            $id_already_exists = (mysqli_num_rows($result) > 0);

            if (!$id_already_exists) {
              $scheduleID = $index;
            } else {
              $index++;
            }
          }

          $query = "INSERT INTO Schedule (ScheduleID, ConcertID, VenueID, Date, Time) VALUES (?, ?, ?, ?, ?)";
          $stmt = mysqli_prepare($link, $query);
          mysqli_stmt_bind_param($stmt, 'iiiss', $scheduleID, $concertID, $venueID, $concertDate, $concertTime);
          mysqli_stmt_execute($stmt);

          $affected_rows = mysqli_stmt_affected_rows($stmt);

          if ($affected_rows != 1) {
            array_push($errors, "Error in adding schedule to database");
          } else {
            // redirect to concerts page
            header("location:concerts.php");
          }
        }
      }

      /* update concert and schedule in database */
      if (isset($_POST['updateConcert'])) {
        $concertUpdateId = $_GET['update'];
        $concertName = $_POST['cname'];
        $concertDescription = $_POST['cdescription'];
        $venueID = $_POST['cvenue'];
        $concertDate = $_POST['cdate'];
        $concertTime = $_POST['ctime'];

        if (isset($_POST['cpublish'])) {
          $concertPublished = true;
        } else {
          $concertPublished = false;
        }

        $query = "UPDATE Concert SET Concert_name = ?, Description = ?, Published = ? WHERE ConcertID = ?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, 'ssii', $concertName, $concertDescription, $concertPublished, $concertUpdateId);
        mysqli_stmt_execute($stmt);

        $affected_rows = mysqli_stmt_affected_rows($stmt);

        if ($affected_rows != 1) {
          array_push($errors, "Error in updating concert in database");
        } else {
          $query = "SELECT ScheduleID FROM Schedule WHERE ConcertID = ".intval($concertUpdateId);
          $response = mysqli_query($link, $query);

          if ($response) {
            $row = mysqli_fetch_array($response);
            $updateScheduleId = $row['ScheduleID'];
            $query = "UPDATE Schedule SET VenueID = ?, Date = ?, Time = ? WHERE ScheduleID = ?";
            $stmt = mysqli_prepare($link, $query);
            mysqli_stmt_bind_param($stmt, 'issi', $venueID, $concertDate, $concertTime, $updateScheduleId);
            if (mysqli_stmt_execute($stmt)) {
              // redirect to concerts page
              header("location:concerts.php");
            }
          } else {
            array_push($errors, "Error in updating schedule in database");
          }
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

                  <div class="col-md-9 mb-3">
                    <h3 class="light-green">
                      <?php if ($editMode) { ?>
                        Update or Add New Concert
                      <?php } else { ?>
                        Add Concert
                      <?php } ?>
                    </h3>
                  </div>
                  <div class="col-md-3 mb-3">
                    <?php if ($isAdmin) { ?>
                      <label>
                        <input class="mr-3" type="checkbox" name="cpublish" value="1"
                               <?php if ($cpublished) { echo "checked"; } ?> />
                        Published
                      </label>
                    <?php } ?>
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
                    <select name="cvenue">
                      <?php foreach ($venueList as $key => $value) { ?>
                        <option value="<?php echo $key; ?>" <?php if ($key==$selectedVenue) { echo "selected"; } ?>>
                          <?php echo $value; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="col-md-2 mb-2"></div>
                  <div class="col-md-10 mb-2 error">
                    <?php echo $cvenue_err; ?>
                    <?php
                      foreach($errors as $error) {
                        echo "<p class='error'>".$error."</p>";
                      }
                    ?>
                  </div>
                </div>

                <div class="text-right mt-4">
                  <input type="submit" name="addConcert" value="Add New" />
                  <?php if ($editMode) { ?>
                    <input type="submit" name="updateConcert" value="Update"
                           formaction="add-concert.php?update=<?php echo $concertEditId; ?>" formmethod="post" />
                  <?php } ?>
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
