<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>
    <?php include 'header.inc.php'; ?>

    <?php
    require_once('config.php');

    // define variables & initialize with empty values
    $delete_venue_err = "";

    /* only allow admins to delete venues */
    if ($isAdmin && isset($_POST['delete'])) {
      $venueDeleteId = $_GET['delete'];

      /* dissallow deletion of venues that are being used by Schedule */
      $query = "SELECT ScheduleID FROM Schedule WHERE VenueID = ?";

      if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $venueDeleteId);

        if (mysqli_stmt_execute($stmt)) {
          if (mysqli_stmt_num_rows($stmt) == 1) {
            $delete_venue_err = "Cannot delete a venue when it is being used by a Schedule";
          } else {
            mysqli_stmt_close($stmt);
            $query = "DELETE FROM Venue WHERE VenueID = ?";
            $stmt = mysqli_prepare($link, $query);
            mysqli_stmt_bind_param($stmt, 'i', $venueDeleteId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
          }
        }
      }
    }
    ?>

    <main>
      <div class="container">
        <div class="col-md-12">
          <div class="tile shadow CEG-table">
            <div class="row">
              <div class="col-md-2">
                <h3 class="green">Venues</h3>
              </div>
              <div class="col-md-10 mt-2 font-italic error text-right">
                <?php echo $delete_venue_err; ?>
              </div>
            </div>
            <div class="row px-1">
              <div class="col-md-2 my-2 py-3 font-weight-bold green">Name</div>
              <div class="col-md-2 my-2 py-3 font-weight-bold green">Street</div>
              <div class="col-md-2 my-2 py-3 font-weight-bold green">City</div>
              <div class="col-md-1 my-2 py-3 font-weight-bold green">State</div>
              <div class="col-md-1 my-2 py-3 font-weight-bold green">Zip</div>
              <div class="col-md-2 my-2 py-3 font-weight-bold green">Max Occupancy</div>
              <div class="col-md-2"></div>
            </div>

            <?php
            $query = "SELECT * FROM Venue";
            $response = mysqli_query($link, $query);
            $index = 0;

            if ($response) {
              while ($row = mysqli_fetch_array($response)) {
                /* only apply gray-background class to even elements */ ?>
                <div class="row px-1 <?php if ($index%2 == 0) echo "gray-background" ?>">
                  <div class="col-md-2 my-2 py-3 green"><?php echo $row['Venue_name']; ?></div>
                  <div class="col-md-2 my-2 py-3 green"><?php echo $row['Address']; ?></div>
                  <div class="col-md-2 my-2 py-3 green"><?php echo $row['City']; ?></div>
                  <div class="col-md-1 my-2 py-3 green"><?php echo $row['State']; ?></div>
                  <div class="col-md-1 my-2 py-3 green"><?php echo $row['Zip']; ?></div>
                  <div class="col-md-1 my-2 py-3 green text-center"><?php echo $row['Max_attendees']; ?></div>
                  <div class="col-md-3 my-2 text-right">
                    <?php
                      /* build google map link */
                      $address = $row['Address'];
                      $city = $row['City'];
                      $state = $row['State'];
                      $zip = $row['Zip'];
                      str_replace(' ', '+', $address);
                      str_replace(' ', '+', $city);
                      $googleMapLink = "https://www.google.com/maps/place/".$address.",".$city.",".$state."+".$zip;
                    ?>
                    <a href="<?php echo $googleMapLink; ?>" target="_blank">
                      <img class="google-map-icon" src="images/google-map-icon.png" alt="find venue on google maps">
                    </a>

                    <?php if ($isAdmin) {
                      $venueID = $row['VenueID']; ?>

                      <form action="add-venue.php?edit=<?php echo $venueID; ?>" method="post" style="display:inline;">
                        <button class="circle-button mt-2"><img src="images/edit-icon.png" /></button>

                        <button type="submit" name="delete" class="circle-button mt-2 delete-button"
                                formaction="<?php echo "venues.php?delete=".$venueID; ?>" formmethod="post">
                          <img src="images/remove-icon.png" />
                        </button>
                      </form>
                    <?php } ?>
                  </div>
                </div>

                <?php
                $index++;
              }
            }

            if ($isAdmin) { ?>
              <div class="text-right">
                <a class="button mt-3" href="add-venue.php">Add Venue</a>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
