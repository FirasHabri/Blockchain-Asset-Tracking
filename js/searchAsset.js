web3 = new Web3(window.web3.currentProvider);
AssetTrackerContract = new web3.eth.Contract(abi, address);


function searchAsset() {
    $("#loading").show();
    let id = parseInt($('input[name="id"]').val());

    // search in the smart contract
    AssetTrackerContract.methods.getAsset(id).call((error, response) => {
        if (error) console.log(error);
        else {
            if (response[1] !== "") {
                // asset is found
                let result =
                    '<br><h4 style="color: #3a95d6;">Asset found</h4>' +
                    '<div class="border-top my-3"></div>' +
                    "<strong>Name: </strong>" +
                    response[1] +
                    "<br>" +
                    "<strong>Batch No: </strong>" +
                    response[0] +
                    "<br>" +
                    "<strong>Manufacturer: </strong>" +
                    response[2] +
                    "<br>" +
                    "<strong>Owner: </strong>" +
                    response[3] +
                    "<br>" +
                    "<strong>Description: </strong>" +
                    response[5] +
                    "<br>" +
                    "<strong>Current Status: </strong>" +
                    response[4] +
                    "<br><br>" +
                    '<div id="mapdiv" style="width:500px; height:300px;"></div>';

                $("#searchResult").html("");
                $("#loading").hide();
                $("#searchResult").append(result);

                // show the status history
                $("#statusHistory").show();
                // asset history
                assetHistory(id);
            } else {
                // asset is not found
                let result = "<h3>Asset Not Found</h3>";
                $("#searchResult").html("");
                $("#loading").hide();
                $("#searchResult").append(result);
            }
        }
    });

    AssetTrackerContract.methods.getLongLat(id).call((error, response) => {
        if (error) console.log(error);
        else {
            resLong = response[0];
            resLat = response[1];
        }
        map = new OpenLayers.Map("mapdiv");
        map.addLayer(new OpenLayers.Layer.OSM());

        console.log(parseFloat(resLong), parseFloat(resLat));

        var lonLat = new OpenLayers.LonLat(parseFloat(resLat), parseFloat(resLong))
            .transform(
                new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
                map.getProjectionObject() // to Spherical Mercator Projection
            );

        var zoom = 15;

        var markers = new OpenLayers.Layer.Markers("Markers");
        map.addLayer(markers);

        markers.addMarker(new OpenLayers.Marker(lonLat));

        map.setCenter(lonLat, zoom);
    });
}

function assetHistory(id) {
    AssetTrackerContract.methods.AssetStore(id).call((error, response) => {
        if (error) console.log(error);
        else {
            let statusCount = parseInt(response[5]);
            for (let i = statusCount; i >= 1; i--) {
                AssetTrackerContract.methods
                    .getStatus(id, i)
                    .call((error, response) => {
                        if (error) console.log(error);
                        else {
                            let date = new Date(parseInt(response[0]) * 1000);
                            let event =
                                date +
                                "<br>" +
                                response[2] +
                                "<br>" +
                                response[1] +
                                "<br>" +
                                "<br>";
                            $("#statusHistory").append(event);
                        }
                    });
            }
        }
    });
}