var assetCount = 0;

var acc = null;
web3.eth.getAccounts().then(function(accounts) {
    acc = accounts[0];
})

function searchAsset() {
    // clear previous search result
    $("#searchResult").html("");

    //   now search the asset
    assetId = parseInt($('input[name="id"]').val());
    AssetTrackerContract.methods.getAsset(assetId).call((error, response) => {
        if (error) console.log(error);
        else {
            // if found
            if (response[1] !== "") {
                let content =
                    '<h4 style="color: #3a95d6;">Asset Found</h4><strong>Name: </strong>' +
                    response[1] +
                    "<br>" +
                    "<strong>Owner: </strong>" +
                    response[3] +
                    "<br>" +
                    "<strong>Current Status: </strong>" +
                    response[4];
                $("#searchResult").append(content);
                $("#transferFrom").show();
            } else {
                //   if not found
                let content = "<h4>Asset Not Found</h4>";
                $("#searchResult").append(content);
                $("#transferFrom").hide();
            }
        }
    });
}

function transferAsset() {
    let assetId = parseInt($('input[name="id"]').val());
    let newOwner = $('input[name="newOwner"]').val();
    let newStatus = $('input[name="newStatus"]').val();
    let newLong = $('input[name="newLong"]').val();
    let newLat = $('input[name="newLat"]').val();

    // transfer the asset
    AssetTrackerContract.methods
        .transferAsset(assetId, newOwner, newLong, newLat, newStatus)
        .send({ from: acc })
        .then(result => {
            if (result.status === true) {
                alert("Success");
                window.location.href = './index.php';
            }
        });
}