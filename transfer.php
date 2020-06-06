<?php
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<?php require "template/header.php" ?>

<body>
<?php require "template/navbar.php" ?>
<br><br>
<div class="container">
      <h2 class="display-8" style="color: #3a95d6;">Transfer Asset</h2>
      <br />
      <div class="row">
        <div class="col">
          <div class="row">
            <div class="col">
              <input
                type="number"
                name="id"
                class="form-control"
                placeholder="Id of the asset"
              />
              <br />
              <div id="searchResult"></div>
            </div>
            <div class="col">
              <button onclick="searchAsset()" class="btn btn-primary">
                Search
              </button>
            </div>
          </div>
        </div>
        <div class="col">
          <div id="transferFrom" style="display: none">
            <div class="form-group">
              <h5>Enter the new details below</h5>
            </div>
            <div class="form-group">
              <input
                type="text"
                name="newOwner"
                class="form-control"
                placeholder="New Owner"
              />
            </div>

            <div class="form-group">
              <input
                type="text"
                name="newStatus"
                class="form-control"
                placeholder="New status of the asset"
              />
            </div>

            <div class="form-group">
              <input
                type="text"
                name="newLong"
                class="form-control"
                placeholder="New longitude  of the asset"
              />
            </div>

            <div class="form-group">
              <input
                type="text"
                name="newLat"
                class="form-control"
                placeholder="New latitude  of the asset"
              />
            </div>
            <div class="form-group">
              <button onclick="transferAsset()" class="btn btn-success">
                Transfer
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="./js/transfer.js" type="text/javascript"></script>
</body>

<?php require "template/footer.php" ?>

