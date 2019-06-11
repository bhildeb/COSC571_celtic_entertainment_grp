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

      $vname = $voccupancy = $vdescription = $vaddress = $vcity = $vstate = $vzip = "";
      $vname_err = $voccupancy_err = $vdescription_err = $vaddress_err =  $vcity_err = $vstate_err = $vzip_err = "";
      $errors = array();
      $editMode = false;

      if (isset($_GET['edit'])) {
        $editMode = true;
        $venueEditId = $_GET['edit'];
        $query = "SELECT Venue_name, Address, City, State, Zip, Description, Max_attendees FROM Venue WHERE VenueID = ?";

        if ($stmt = mysqli_prepare($link, $query)) {
          mysqli_stmt_bind_param($stmt, "i", $venueEditId);

          if (mysqli_stmt_execute($stmt)) {
            if ($result = mysqli_stmt_get_result($stmt)) {
              $row = mysqli_fetch_array($result);
              $vname = $row['Venue_name'];
              $vaddress = $row['Address'];
              $vcity = $row['City'];
              $vstate = $row['State'];
              $vzip = $row['Zip'];
              $vdescription = $row['Description'];
              $voccupancy = $row['Max_attendees'];
            }
          }
        }
      }

      /* add venue to database */
      if (isset($_POST['addVenue'])) {
        $venueName = $_POST['vname'];
        $venueAddress = $_POST['vaddress'];
        $venueCity = $_POST['vcity'];
        $venueState = $_POST['vstate'];
        $venueZip = $_POST['vzip'];
        $venueDescription = $_POST['vdescription'];
        $venueOccupancy = $_POST['voccupancy'];

        /* get size of Venue table */
        $query = "SELECT * FROM Venue";
        $result = mysqli_query($link, $query);
        $table_size = mysqli_num_rows($result);

        $venueID = $table_size + 1;
        $index = 0;

        /* check for available ids created as a result of deletions
           otherwise use size of table + 1 as id */
        while ($venueID == ($table_size + 1)) {
          $query = "SELECT * FROM Venue WHERE VenueID = ".intval($index);
          $result = mysqli_query($link, $query);

          $id_already_exists = (mysqli_num_rows($result) > 0);

          if (!$id_already_exists) {
            $venueID = $index;
          } else {
            $index++;
          }
        }

        $query = "INSERT INTO Venue (VenueID, Venue_name, Address, City, State, Zip, Description, Max_attendees) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, 'issssisi', $venueID, $venueName, $venueAddress, $venueCity, $venueState, $venueZip, $venueDescription, $venueOccupancy);
        mysqli_stmt_execute($stmt);

        $affected_rows = mysqli_stmt_affected_rows($stmt);

        if ($affected_rows != 1) {
          array_push($errors, "Error in adding venue to database");
        } else {
          // redirect to concerts page
          header("location:venues.php");
        }
      }

      /* update concert and schedule in database */
      if (isset($_POST['updateVenue'])) {
        $venueUpdateId = $_GET['update'];
        $venueName = $_POST['vname'];
        $venueAddress = $_POST['vaddress'];
        $venueCity = $_POST['vcity'];
        $venueState = $_POST['vstate'];
        $venueZip = $_POST['vzip'];
        $venueDescription = $_POST['vdescription'];
        $venueOccupancy = $_POST['voccupancy'];

        $query = "UPDATE Venue SET Venue_name = ?, Address = ?, City = ?, State = ?, Zip = ?, Description = ? WHERE VenueID = ?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, 'ssssisi', $venueName, $venueAddress, $venueCity, $venueState, $venueZip, $venueDescription, $venueUpdateId);
        mysqli_stmt_execute($stmt);

        $affected_rows = mysqli_stmt_affected_rows($stmt);

        if ($affected_rows != 1) {
          array_push($errors, "Error in updating venue in database");
        } else {
          // redirect to venues page
          header("location:venues.php");
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
                    <h3 class="light-green">
                      <?php if ($editMode) { ?>
                        Update or Add New Venue
                      <?php } else { ?>
                        Add Venue
                      <?php } ?>
                    </h3>
                  </div>

                  <div class="col-md-2 mt-2">
                    <label for="vname">Name</label>
                  </div>

                  <div class="col-md-5 mt-2">
                    <input type="text" name="vname" id="vname" value="<?php echo $vname ?>" />
                  </div>

                  <div class="col-md-3 mt-2">
                    <label for="voccupancy">Max Occupancy</label>
                  </div>

                  <div class="col-md-2 mt-2">
                    <input type="text" name="voccupancy" id="voccupancy" value="<?php echo $voccupancy ?>" />
                  </div>

                  <div class="col-md-2 mb-2"></div>
                  <div class="col-md-10 mb-2 error">
                    <?php echo $vname_err; ?>
                    <?php echo $voccupancy_err; ?>
                  </div>

                  <div class="col-md-2 mt-2">
                    <label for="vdescription">Description</label>
                  </div>

                  <div class="col-md-10 mt-2">
                    <textarea name="vdescription"><?php echo $vdescription; ?></textarea>
                  </div>

                  <div class="col-md-2 mb-2"></div>
                  <div class="col-md-10 mb-2 error">
                    <?php echo $vdescription_err; ?>
                  </div>

                  <div class="col-md-2 mt-2">
                    <label for="vaddress">Address</label>
                  </div>

                  <div class="col-md-10 mt-2">
                    <input type="text" name="vaddress" id="vaddress" value="<?php echo $vaddress ?>" />
                  </div>

                  <div class="col-md-2 mb-2"></div>
                  <div class="col-md-10 mb-2 error">
                    <?php echo $vaddress_err; ?>
                  </div>

                  <div class="col-md-2 mt-2">
                    <label for="vcity">City</label>
                  </div>

                  <div class="col-md-4 mt-2">
                    <input type="text" name="vcity" id="vcity" value="<?php echo $vcity ?>" />
                  </div>

                  <div class="col-md-1 mt-2">
                    <label for="vstate">State</label>
                  </div>

                  <div class="col-md-2 mt-2">
                    <input type="text" name="vstate" id="vstate" value="<?php echo $vstate ?>" />
                  </div>

                  <div class="col-md-1 mt-2">
                    <label for="vzip">Zip</label>
                  </div>

                  <div class="col-md-2 mt-2">
                    <input type="text" name="vzip" id="vzip" value="<?php echo $vzip ?>" />
                  </div>

                  <div class="col-md-2 mb-2"></div>
                  <div class="col-md-10 mb-2 error">
                    <?php echo $vcity_err; ?>
                    <?php echo $vstate_err; ?>
                    <?php echo $vzip_err; ?>
                    <?php
                      foreach($errors as $error) {
                        echo "<p class='error'>".$error."</p>";
                      }
                    ?>
                  </div>
                </div>

                <div class="text-right mt-4">
                  <input type="submit" name="addVenue" value="Add New" />

                  <?php if ($editMode) { ?>
                    <input type="submit" name="updateVenue" value="Update"
                           formaction="add-venue.php?update=<?php echo $venueEditId; ?>" formmethod="post" />
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
