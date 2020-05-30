<?php session_start();
?>

<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="css/main.css">

  <style>
    /* element that contains the map */
    #map {
      height: 60%;
      width: 40%;
      margin-left: 30%;
    }

    /*Makes the sample page fill the window */
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
    }

    /*Map controls */
    .controls {
      background-color: #fff;
      border-radius: 2px;
      border: 1px solid transparent;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      box-sizing: border-box;
      font-family: Roboto;
      font-size: 15px;
      font-weight: 300;
      height: 29px;
      margin-left: 17px;
      margin-top: 10px;
      outline: none;
      padding: 0 11px 0 13px;
      text-overflow: ellipsis;
      width: 400px;
    }

    .controls:focus {
      border-color: #4d90fe;
    }

    .title {
      font-weight: bold;
    }

    #infowindow-content {
      display: none;
    }

    #map #infowindow-content {
      display: inline;
    }
  </style>
</head>

<body>

  <!-- MenuBar -->
  <div id="ul">
    <ul>
      <div id="li">
        <li><a href="login.php">Logout</a></li>
        <li><a href="name.php">Account</a></li>
        <li><a href="about.php">About</a></li>
        <li><a class="active" href="main.php">Home</a></li>
      </div>
    </ul>
  </div>
  <h3>Welcome <?php echo $_SESSION["fullName"]; ?></h4>

    <!-- Main map display -->
    <title>Place ID Geocoder</title>
    <div style="display: none">
      <input id="pac-input" class="controls" type="text" placeholder="Enter a location" name="pac-input">
    </div>
    <div id="map"></div>
    <div id="infowindow-content">
      <span id="place-name" class="title"></span><br>
      <span id="place-address"></span>
      <span id="total-people"></span>
    </div>
    <script src="js/maps.js"></script>
</body>
<div id="map"></div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGCul42xH-_z6j0mbdsleK8IzvU5YXwhU&libraries=places&callback=initMap" async defer></script>


</html>