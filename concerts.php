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

    /* only allow admins to delete concerts */
    if ($isAdmin && isset($_POST['delete'])) {
      $concertDeleteId = $_GET['delete'];

      $query = "DELETE FROM Schedule WHERE ConcertID = ?";
      $stmt = mysqli_prepare($link, $query);
      mysqli_stmt_bind_param($stmt, 'i', $concertDeleteId);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);

      $query = "DELETE FROM Concert WHERE ConcertID = ?";
      $stmt = mysqli_prepare($link, $query);
      mysqli_stmt_bind_param($stmt, 'i', $concertDeleteId);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
    ?>

    <main>
      <div class="container">
        <div class="col-md-12">
          <div class="tile shadow CEG-table">
            <div class="row">
              <div class="col-md-9 mb-3">
                <h3 class="green">Concert Schedule</h3>
              </div>

              <div class="col-md-3 mb-3 unpublished">
                <?php if ($isAdmin || $isEmployee) { ?> unpublished concerts in red <?php } ?>
              </div>
            </div>

            <div class="row px-1">
              <div class="col-md-2 my-2 py-3 font-weight-bold green">Name</div>
              <div class="col-md-2 my-2 py-3 font-weight-bold green">Date</div>
              <div class="col-md-2 my-2 py-3 font-weight-bold green">Time</div>
              <div class="col-md-2 my-2 py-3 font-weight-bold green">Location</div>
              <div class="col-md-4 my-2 py-3 font-weight-bold green">Tickets Available</div>
            </div>

            <?php
            /* get concerts */
            $query = "SELECT * FROM Concert";
            $concerts = mysqli_query($link, $query);
            $index = 0;

            if ($concerts) {
              while ($row = mysqli_fetch_array($concerts)) {
                /* only apply gray-background class to even elements */ ?>

                <?php if (($row['Published']) || $isAdmin || $isEmployee) { ?>
                <div class="row px-1
                  <?php
                    if ($index%2 == 0) { echo "gray-background "; }
                    if (!$row['Published']) { echo "unpublished"; } else { echo "green"; } ?>">

                  <div class="col-md-2 my-2 py-3"><?php echo $row['Concert_name']; ?></div>

                  <?php
                    /* get schedule details */
                    $concertID = $row['ConcertID'];
                    $query = "SELECT VenueID, Date, Time FROM Schedule WHERE ConcertID = ".$concertID;
                    $schedule = mysqli_fetch_array(mysqli_query($link, $query));
                    $date = date('n/j/Y', strtotime($schedule['Date']));

                    /* get venue details */
                    $venueID = $schedule['VenueID'];
                    $query = "SELECT Venue_name, City, State, Max_attendees FROM Venue WHERE VenueID = ".$venueID;
                    $venue = mysqli_fetch_array(mysqli_query($link, $query));
                  ?>

                  <div class="col-md-2 my-2 py-3"><?php echo $date; ?></div>
                  <div class="col-md-2 my-2 py-3"><?php echo $schedule['Time']; ?></div>
                  <div class="col-md-2 my-2 py-3">
                    <?php
                      echo $venue['Venue_name']."<br>";
                      echo $venue['City'].", ";
                      echo $venue['State'];
                    ?>
                  </div>
                  <div class="col-md-2 my-2 py-3 text-center"><?php echo $venue['Max_attendees']; ?></div>

                  <?php if ($isAdmin) { ?>
                    <div class="col-md-2 my-2">
                      <form action="add-concert.php?edit=<?php echo $concertID; ?>" method="post">
                        <button class="circle-button mt-2"><img src="images/edit-icon.png" /></button>
                        <button type="submit" name="delete" class="circle-button mt-2 delete-button"
                                formaction="<?php echo "concerts.php?delete=".$concertID; ?>" formmethod="post">
                          <img src="images/remove-icon.png" />
                        </button>
                      </form>
                    </div>
                  <?php } elseif (isset($_SESSION['id'])) { ?>
                    <div class="col-md-2 my-2"><button>Buy Tickets</button></div>
                  <?php } else { ?>
                    <div class="col-md-2 my-2 text-center pt-3">
                      <a class="green font-italic" href="register.php">Register to Buy Tickets</a>
                    </div>
                  <?php } ?>
                </div>
              <?php }
                $index++;
              }
            }

            if ($isAdmin) { ?>
              <div class="text-right">
                <a class="button mt-3" href="add-concert.php">Add Concert</a>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
