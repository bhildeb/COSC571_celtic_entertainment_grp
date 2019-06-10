<?php

require_once('config.php');

// define variables and initialize with empty values
$username = $password = $id = "";
$username_err = $password_err = "";
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // verify user is in database
  $query = "SELECT UserID FROM User WHERE Email = ?";

  if (empty($_POST["email"])) {
    array_push($errors, "Please enter registered email");
  } else {
    if ($stmt = mysqli_prepare($link, $query)) {
      $param_username = trim($_POST["email"]);
      mysqli_stmt_bind_param($stmt, "s", $param_username);

      if (mysqli_stmt_execute($stmt)) {
        if ($result = mysqli_stmt_get_result($stmt)) {
          $row = mysqli_fetch_row($result);
          $id = $row[0];
          mysqli_stmt_close($stmt);

          // validate Password
          if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter a password";
          } elseif(strlen(trim($_POST["password"])) < 6) {
            $password_err = "Password must have at least 6 characters.";
          } else {
            $password = trim($_POST["password"]);
          }

          if (!$password_err) {
            $query = "SELECT Password FROM User WHERE UserID = ?";

            if ($stmt = mysqli_prepare($link, $query)) {
              mysqli_stmt_bind_param($stmt, "i", $id);

              if (mysqli_stmt_execute($stmt)) {
                if ($result = mysqli_stmt_get_result($stmt)) {
                  $row = mysqli_fetch_row($result);
                  $password_from_db = $row[0];
                  mysqli_stmt_close($stmt);

                  // verify user entered correct password
                  $password_matches = password_verify($password, $password_from_db);

                } else {
                  aray_push($errors, "Database error");
                  mysqli_stmt_close($stmt);
                }
              } else {
                array_push($errors, "Database error");
              }
            } else {
              array_push($errors, "Database error");
            }
          } else {
            array_push($errors, $password_err);
          }
        } else {
          array_push($errors, "User not registered");
          mysqli_stmt_close($stmt);
        }
      }
    } else {
      array_push($errors, "Unable to connect to database");
    }
  }

  if ($password_matches) {
    $query = "SELECT UserID, First_name, Last_name, Email FROM User WHERE UserID = ?";

    if ($stmt = mysqli_prepare($link, $query)) {
      mysqli_stmt_bind_param($stmt, "i", $id);

      if (mysqli_stmt_execute($stmt)) {
        if ($result = mysqli_stmt_get_result($stmt)) {
          // get user info & store in Yaf_Session
          $row = mysqli_fetch_row($result);
          session_start();

          $_SESSION['id'] = $row[0];
          $_SESSION['fname'] = $row[1];
          $_SESSION['lname'] = $row[2];
          $_SESSION['email'] = $row[3];

          // redirect to login success page
          header("location:login-success.php");
        } else {
          array_push($errors, "Database error");
          mysqli_stmt_close($stmt);
        }
      } else {
        array_push($errors, "Database error");
      }
    } else {
      array_push($errors, "Databse error");
    }
  } else {
    array_push($errors, "Invalid password");
  }
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
                  <div class="col-md-3 my-2">
                    <label for="email">Email</label>
                  </div>

                  <div class="col-md-9 my-2">
                    <input type="email" name="email" id="email" />
                  </div>

                  <div class="col-md-3 my-2">
                    <label for="password">Password</label>
                  </div>

                  <div class="col-md-9 my-2">
                    <input type="password" name="password" id="password" />
                  </div>

                  <div class="col-md-3 my-2"></div>
                  <div class="col-md-9 my-2">
                    <?php
                      foreach($errors as $error) {
                        echo "<p class='error'>".$error."</p>";
                      }
                    ?>
                  </div>
                </div>

                <div class="text-right my-4">
                  <input type="submit" name="submit" value="Login" />
                </div>

                <div>
                  Don't have an account? <a href="register.php">Register today</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
