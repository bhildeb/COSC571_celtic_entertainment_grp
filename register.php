<?php

require_once('config.php');

// define variables & initialize with empty values
$username = $password = $confirm_password = $fname = $lname = "";
$username_err = $password_err = $confirm_password_err = $fname_err = $lname_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // validate $username
  if (empty($_POST["email"])) {
    $username_err = "Please enter a username.";
  } else {
    $query = "SELECT UserID FROM User WHERE Email = ?";

    if ($stmt = mysqli_prepare($link, $query)) {
      $param_username = trim($_POST["email"]);
      mysqli_stmt_bind_param($stmt, "s", $param_username);

      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
          $username_err = "This username is already taken";
        } else {
          $username = trim($_POST["email"]);
        }
      } else {
        echo "Database error";
      }
    }

    mysqli_stmt_close($stmt);
  }

  // validate first name
  if (empty(trim($_POST["fname"]))) {
    $fname_err = "Please enter a first name";
  } else {
    $fname = trim($_POST["fname"]);
  }

  // validate last name
  if (empty(trim($_POST["lname"]))) {
    $lname_err = "Please enter a last name";
  } else {
    $lname = trim($_POST["lname"]);
  }

  // validate password
  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter a password";
  } elseif (strlen(trim($_POST["password"])) < 6) {
    $password_err = "Password must have at least 6 characters.";
  } else {
    $password = trim($_POST["password"]);
  }

  if (empty($fname_err) && empty($lname_err) && empty($username_err) && empty($password_err)) {
    // get size of table
    $query = "SELECT * FROM User";
    $result = mysqli_query($link, $query);
    $table_size = mysqli_num_rows($result);

    $id = $table_size + 1;
    $index = 0;

    // check for available ids created as a result of deletions
    // otherwise use size of table + 1 as idea
    while ($id == ($table_size + 1)) {
      $query = "SELECT * FROM User WHERE UserID = ".intval($index);
      $result = mysqli_query($link, $query);
      $id_already_exists = (mysqli_num_rows($result) > 0);
      if (!$id_already_exists) {
        $id = $index;
      } else {
        $index++;
      }
    }

    $query = "INSERT INTO User (UserID, First_name, Last_name, Email, Password) VALUES (?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($link, $query)) {
      $param_password = password_hash($password, PASSWORD_DEFAULT); // create password hash
      $param_username = $_POST["email"];
      $fname = $_POST["fname"];
      $lname = $_POST["lname"];

      mysqli_stmt_bind_param($stmt, "issss", $id, $fname, $lname, $param_username, $param_password);

      if (mysqli_stmt_execute($stmt)) {
        // redirect to register success page
        header("location:index.php");               // change this
      } else {
        echo "Database error";
      }
    }

    mysqli_stmt_close($stmt);
  }

  mysqli_close($link);
}
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
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="row">
                  <div class="col-md-3 mt-2">
                    <label for="fname">First Name</label>
                  </div>

                  <div class="col-md-9 mt-2">
                    <input type="text" name="fname" id="fname" value="<?php echo $fname ?>" />
                  </div>

                  <div class="col-md-3 mb-2"></div>
                  <div class="col-md-9 mb-2 error">
                    <?php echo $fname_err; ?>
                  </div>

                  <div class="col-md-3 mt-2">
                    <label for="lname">Last Name</label>
                  </div>

                  <div class="col-md-9 mt-2">
                    <input type="text" name="lname" id="lname" value="<?php echo $lname ?>" />
                  </div>

                  <div class="col-md-3 mb-2"></div>
                  <div class="col-md-9 mb-2 error">
                    <?php echo $lname_err; ?>
                  </div>

                  <div class="col-md-3 mt-2">
                    <label for="email">Email</label>
                  </div>

                  <div class="col-md-9 mt-2">
                    <input type="email" name="email" id="email" value="<?php echo $username ?>" />
                  </div>

                  <div class="col-md-3 mb-2"></div>
                  <div class="col-md-9 mb-2 error">
                    <?php echo $username_err; ?>
                  </div>

                  <div class="col-md-3 mt-2">
                    <label for="password">Password</label>
                  </div>

                  <div class="col-md-9 mt-2">
                    <input type="password" name="password" id="password" value="<?php echo $password ?>" />
                  </div>

                  <div class="col-md-3 mb-2"></div>
                  <div class="col-md-9 mb-2 error">
                    <?php echo $password_err; ?>
                  </div>
                </div>

                <div class="text-right mt-4">
                  <input type="submit" value="Register" />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
