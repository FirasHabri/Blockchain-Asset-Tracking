var assetCount = 0;

var acc = null;
web3.eth.getAccounts().then(function(accounts) {
    acc = accounts[0];
})

AssetTrackerContract = new web3.eth.Contract(abi, address);

$(document).ready(() => {
    renderPageContent();
});

function renderPageContent() {
    AssetTrackerContract.methods.getAssetCount().call((error, response) => {
        if (error) console.log(error);
        else {
            assetCount = response;
            $("#count").html("Total " + response + " Assets");
            renderTable();
        }
    });

    function renderTable() {
        for (let i = 1; i <= parseInt(assetCount); i++) {
            AssetTrackerContract.methods.getLongLat(i).call((error, response) => {
                if (error) console.log(error);
                else {
                    resLong = response[0];
                    resLat = response[1];
                }
                AssetTrackerContract.methods.getAsset(i).call((error, response) => {
                    if (error) console.log(error);
                    else {
                        let row =
                            '<tr><th scope="row" style="text-align:center">' +
                            i +
                            "</th>" +
                            '<td style="text-align:center">' +
                            response[0] +
                            "</td>" +
                            '<td style="text-align:center">' +
                            response[1] +
                            "</td>" +
                            '<td style="text-align:center">' +
                            response[2] +
                            "</td>" +
                            '<td style="text-align:center">' +
                            response[3] +
                            "</td>" +
                            '<td style="text-align:center">' +
                            response[4] +
                            "</td>" +
                            '<td style="text-align:center">' +
                            response[5] +
                            "</td>" +
                            '<td style="text-align:center">' +
                            resLong + " / " + resLat +
                            "</td>" +
                            '<td style="text-align:center">' +
                            '<form action=\'delete.php?id="' + i + '"&Name="' + response[0] + '"&Batch_No="' + response[1] + '"\' method="post">' +
                            '<input type="submit" class="btn btn-danger btn-sm" name="submit" value="Delete">' +
                            '</form>' +
                            '</td>'
                        "</tr>";

                        $("tbody").append(row);
                    }
                });
            })
        }
        $("#loading").hide();
    }
}

function createNewAsset() {
    let batchNo = $('input[name="batchNo"]').val();
    let name = $('input[name="name"]').val();
    let desc = $('input[name="desc"]').val();
    let manufacturer = $('input[name="manufacturer"]').val();
    let owner = $('input[name="owner"]').val();
    let status = $('input[name="status"]').val();
    let long = $('input[name="Longitude"]').val();
    let lat = $('input[name="Latitude"]').val();

    if (formValidation(batchNo, name, desc, manufacturer, owner, status, long, lat) == 1) {
        alert('All inputs are required!');
    } else {
        AssetTrackerContract.methods
            .createAsset(batchNo, name, desc, manufacturer, owner, status, long, lat)
            .send({ from: acc })
            .then(result => {
                if (result.status === true) {
                    alert("Success");
                    console.log(result);
                    $("#loading").show();
                    $("tbody").html("");

                    renderPageContent();

                    $('input[name="batchNo"]').val("");
                    $('input[name="name"]').val("");
                    $('input[name="desc"]').val("");
                    $('input[name="manufacturer"]').val("");
                    $('input[name="owner"]').val("");
                    $('input[name="status"]').val("");
                    $('input[name="Longitude"]').val("");
                    $('input[name="Latitude"]').val("");
                }
            });
        $("#exampleModal").modal("hide");
    }


}

function formValidation(batchNo, name, desc, manufacturer, owner, status, long, lat) {
    if (batchNo == '' || name == '' || desc == '' || manufacturer == '' || owner == '' || status == '' || long == '' || lat == '')
        return 1;
    return 0;
}

AssetTrackerContract.events.AssetTransfer((error, result) => {
    if (error) console.log(error);
    else {
        $("#count").html("");
        $("tbody").html("");
        renderPageContent();
    }
});