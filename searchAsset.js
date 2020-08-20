web3 = new Web3(window.web3.currentProvider);
AssetTrackerContract = new web3.eth.Contract(abi, address);


$(document).ready(() => {

});

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
                    "<br>" +
                    "<strong>Estimated Arrival time: </strong>" +
                    '<div id="estTime"></div>' +
                    "<br><br>" +
                    '<div id="mapid" style="width:500px; height:300px;"></div>';

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

        var mymap = L.map('mapid').setView([resLat, resLong], 13);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoiZmlyYXNoYWJyaSIsImEiOiJja2Q3dHVrOXYxMWZzMnJsb3hoam54NXlkIn0.yXxLRF8HTPQmb59rK-hQNg'
        }).addTo(mymap);

        marker = new L.marker([resLat, resLong])
            .addTo(mymap);

        mymap.locate({ setView: true, watch: true })
            .on('locationfound', function(e) {
                var marker2 = L.marker([e.latitude, e.longitude]);
                mymap.addLayer(marker2);
                var latlngs = Array();
                latlngs.push(marker.getLatLng());
                latlngs.push(marker2.getLatLng());

                var distance = calcCrow(marker.getLatLng().lat,
                    marker.getLatLng().lng,
                    marker2.getLatLng().lat,
                    marker2.getLatLng().lng
                )

                var polyline = L.polyline(latlngs, { color: 'red' }).addTo(mymap).bindPopup(distance.toString() + " KM");
                mymap.fitBounds(polyline.getBounds());

                var estmTime = distance * 2 / 60;

                var decimalTimeString = estmTime;
                var decimalTime = parseFloat(decimalTimeString);
                decimalTime = decimalTime * 60 * 60;
                var hours = Math.floor((decimalTime / (60 * 60)));
                decimalTime = decimalTime - (hours * 60 * 60);
                var minutes = Math.floor((decimalTime / 60));
                decimalTime = decimalTime - (minutes * 60);
                var seconds = Math.round(decimalTime);
                if (hours < 10) {
                    hours = "0" + hours;
                }
                if (minutes < 10) {
                    minutes = "0" + minutes;
                }
                if (seconds < 10) {
                    seconds = "0" + seconds;
                }
                $("#estTime").text("" + hours + ":" + minutes + ":" + seconds);
            });
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

//alert();


function calcCrow(lat1, lon1, lat2, lon2) {
    var R = 6371; // km
    var dLat = toRad(lat2 - lat1);
    var dLon = toRad(lon2 - lon1);
    var lat1 = toRad(lat1);
    var lat2 = toRad(lat2);

    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.sin(dLon / 2) * Math.sin(dLon / 2) * Math.cos(lat1) * Math.cos(lat2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c;
    return d;
}

// Converts numeric degrees to radians
function toRad(Value) {
    return Value * Math.PI / 180;
}


//console.log(calcCrow(userLat, userLong, 59.3225525, 13.4619422).toFixed(1));