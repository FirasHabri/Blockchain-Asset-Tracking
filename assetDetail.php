<?php
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<?php require "template/header.php" ?>

<body>
<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
   integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
   crossorigin=""></script>
   <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
   <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

<?php require "template/navbar.php" ?>
<br><br>
<div class="container">
      <h1 class="display-4"></h1>
      <div id="loading-div">
        <div class="inner-div">
          <div id="count">
            <h2 class="display-8" style="color: #3a95d6;">Track Asset</h2>
          </div>
        </div>
      </div>
      <!-- form -->
      <div class="row">
        <div class="col">
          <input
            type="number"
            name="id"
            class="form-control"
            placeholder="Id of the asset"
          />
        </div>
        <div class="col">
          <button class="btn btn-primary" type="button" onclick="searchAsset()">
            Track
          </button>
        </div>
      </div>
      <div class="border-top my-3"></div>
      <div class="row">
        <div class="col">
            <div class="lead" id="searchResult"></div>
        </div>
        <div class="col">
            <div id="statusHistory" style="display: none">
                <br>
                <h4>Status History</h4></div>
            </div>
        </div>
    </div>
    </div>
</body>

<?php require "template/footer.php" ?>