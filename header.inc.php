<?php include 'functions.inc.php'; ?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

$isEmployee = false;
$isAdmin = false;

// get privileges
if ((isset($_SESSION['isEmployee'])) && ($_SESSION['isEmployee']) == true) {
  $isEmployee = true;
}

if ((isset($_SESSION['isAdmin'])) && ($_SESSION['isAdmin']) == true) {
  $isAdmin = true;
}
?>

<header class="overlay">
  <a href="index.php">
    <img src="images/CEG-logo.png" alt="Celtic Entertainment Group">
  </a>

  <ul class="list-unstyled">
    <?php if ($isAdmin) { ?>
      <li><a href="register.php" <?php if (isPage('register')) { ?> class="active" <?php } ?> >Register Employee</a></li>
    <?php } ?>

    <li><a href="concerts.php" <?php if (isPage('concerts')) { ?> class="active" <?php } ?> >Concerts</a></li>
    <li><a href="venues.php" <?php if (isPage('venues')) { ?> class="active" <?php } ?> >Venues</a></li>
    <li><a href="bands.php" <?php if (isPage('bands')) { ?> class="active" <?php } ?> >Bands</a></li>
    <li>

    <?php
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
