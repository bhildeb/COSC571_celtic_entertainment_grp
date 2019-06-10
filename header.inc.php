<?php include 'functions.inc.php'; ?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<header class="overlay">
  <a href="index.php">
    <img src="images/CEG-logo.png" alt="Celtic Entertainment Group">
  </a>

  <ul class="list-unstyled">
    <li><a href="concerts.php" <?php if (isPage('concerts')) { ?> class="active" <?php } ?> >Concerts</a></li>
    <li><a href="venues.php" <?php if (isPage('venues')) { ?> class="active" <?php } ?> >Venues</a></li>
    <li><a href="bands.php" <?php if (isPage('bands')) { ?> class="active" <?php } ?> >Bands</a></li>
    <li>
    <?php
    session_start();

    if (isset($_SESSION['id'])) { ?>
      <a href="logout.php">Log Out</a>
    <?php } else { ?>
      <a href="login.php" <?php if ((isPage('login') || isPage('register'))) { ?> class="active" <?php } ?> >
        Log In/Register
      </a>
    <?php } ?>
    </li>
  </ul>
</header>
