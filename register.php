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

                  <div class="col-md-3 mt-2">
                    <label for="lname">Last Name</label>
                  </div>

                  <div class="col-md-9 mt-2">
                    <input type="text" name="lname" id="lname" value="<?php echo $lname ?>" />
                  </div>

                  <div class="col-md-3 mt-2">
                    <label for="email">Email</label>
                  </div>

                  <div class="col-md-9 mt-2">
                    <input type="email" name="email" id="email" value="<?php echo $username ?>" />
                  </div>

                  <div class="col-md-3 mt-2">
                    <label for="password">Password</label>
                  </div>

                  <div class="col-md-9 mt-2">
                    <input type="password" name="password" id="password" value="<?php echo $password ?>" />
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
