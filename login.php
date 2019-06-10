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
