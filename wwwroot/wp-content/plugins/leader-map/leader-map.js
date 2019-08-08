var leaderMap;

function googleMapJsReady() {
    // Nothing
}
function initLeaderMap() {
    leaderMap = new google.maps.Map(document.getElementById('leaderMap'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 8
    });
}