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
        
            <div class="row">
                <div class="col-6">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Create Asset</button>
                </div>
                <div class="col-6">
                  <form class="form-inline float-right">
                      <button class="btn btn-secondary" type="button" onclick="window.location.href='assetDetail.php'">Search Asset</button>
                  </form>
                  <form class="form-inline float-right">
                      <button class="btn btn-secondary mr-2" type="button" onclick="window.location.href='transfer.php'">Transfer Asset</button>
                  </form>
                </div>
            </div>
        
        <div class="border-top my-3"></div>
      <h4 class="display-8"style="color: #3a95d6;">
        <div id="loading-div">
          <div class="inner-div"><div id="count"></div></div>
          <div class="inner-div">
            <img src="./images/loading.gif" alt="loading" id="loading" />
          </div>
        </div>
      </h4>
      <table class="table table-hover">
        <thead class="thead-dark">
          <tr>
            <th style="text-align:center"scope="col">Id</th>
            <th style="text-align:center"scope="col">Batch No.</th>
            <th style="text-align:center"scope="col">Name</th>
            <th style="text-align:center"scope="col">Manufacturer</th>
            <th style="text-align:center"scope="col">Owner</th>
            <th style="text-align:center"scope="col">Status</th>
            <th style="text-align:center"scope="col">Description</th>
            <th style="text-align:center"scope="col">Coordination</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
      <!-- code for modal -->
      <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                Create a new asset
              </h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="container">
                <div class="form-group">
                  <input
                    type="text"
                    name="batchNo"
                    class="form-control"
                    placeholder="Batch Number"
                    required
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="Name"
                    required
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    name="desc"
                    class="form-control"
                    placeholder="Description"
                    required
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    name="manufacturer"
                    class="form-control"
                    placeholder="Manufacturer"
                    required
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    name="owner"
                    class="form-control"
                    placeholder="Owner"
                    required
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    name="status"
                    class="form-control"
                    placeholder="Current Status"
                    required
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    name="Longitude"
                    class="form-control"
                    placeholder="Longitude"
                    required
                  />
                </div>
                <div class="form-group">
                  <input
                    type="text"
                    name="Latitude"
                    class="form-control"
                    placeholder="Latitude"
                    required
                  />
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
              >
                Close
              </button>
              <button
                type="button"
                class="btn btn-primary"
                onclick="createNewAsset()"
              >
                Create
              </button>
            </div>
          </div>
        </div>
      </div>
      <div>
          <div class="border-top my-3"></div>
          <div class="card pr-2 pl-2 pt-2 pb-2">
          <div class="card-header">
          <h4 class="display-8"style="color: #3a95d6;">
            Assets History
          </h4>
          </div>
          <div class="card-body" id="dataLog"></div>
          </div>
      </div>
    </div>

    <script>    
        web3 = new Web3(window.web3.currentProvider);

        window.addEventListener("load", async() => {
            if (window.ethereum) {
                window.web3 = new Web3(window.ethereum);
                var contract;
                $(document).ready(function() {
                  
                    AssetTrackerContract = new web3.eth.Contract(abi, address);
                    AssetTrackerContract.events.AssetCreate({
                        filter: { myIndexedParam: [20, 23], myOtherIndexedParam: '0x123456789...' }, 
                        fromBlock: 0
                    }, function(error, result) {
                        if (error) console.log(error);
                        else {
                            let { returnValues } = result;
                            console.log(returnValues);
                            const newEventData =
                                '<h6><span class="badge badge-primary">Create</span> New asset created with id' +
                                '<strong>'+returnValues[0] +'</strong>'+
                                " by " +
                                '<strong>'+returnValues[1] +'</strong>'+
                                " current status " +
                                '<strong>'+returnValues[2] +'</strong>'+
                                "</h6>";
                            $("#dataLog").append(newEventData);
                        };
                    });

                    AssetTrackerContract.events.AssetDelete({
                        filter: { myIndexedParam: [20, 23], myOtherIndexedParam: '0x123456789...' }, 
                        fromBlock: 0
                    }, function(error, result) {
                        if (error) console.log(error);
                        else {
                            let { returnValues } = result;
                            console.log(returnValues);
                            const newEventData =
                                '<h6><span class="badge badge-danger">Delete</span> Asset with id ' +
                                '<strong>'+returnValues[0] +'</strong> deleted'+
                                " current Batch No. " +
                                '<strong>'+returnValues[1] +'</strong>'+
                                " Asset name " +
                                '<strong>'+returnValues[2] +'</strong>'+
                                "</h6>";
                            $("#dataLog").append(newEventData);
                        };
                    });

                    AssetTrackerContract.events.AssetTransfer({
                        filter: { myIndexedParam: [20, 23], myOtherIndexedParam: '0x123456789...' }, 
                        fromBlock: 0
                    }, function(error, result) {
                        if (error) console.log(error);
                        else {
                            let { returnValues } = result;
                            console.log(returnValues);
                            const newEventData =
                                '<h6><span class="badge badge-info">Transfer</span> Asset with id ' +
                                '<strong>'+returnValues[0] +'</strong> Transfered to'+
                                " new owner " +
                                '<strong>'+returnValues[1] +'</strong>'+
                                "</h6>";
                            $("#dataLog").append(newEventData);
                        };
                    });
                })
                try {
                    await window.ethereum.enable();
                    web3.eth.getAccounts().then(function(accounts) {
                        })
                } catch (error) {
                }
            }
            else if (window.web3) {
                window.web3 = new Web3(web3.currentProvider);
            }
            else {
                console.log("Non-Ethereum browser detected. You should consider trying MetaMask!");
            }
        });
    </script>
    <script src="./js/app.js" type="text/javascript"></script>
</body>

<?php require "template/footer.php" ?>