var leaderMap;

function googleMapJsReady() {
    // Nothing
}
function initLeaderMap(data) {
    // Data is array of...
    // - name (string)
    // - position (lat/lng ready for Google Maps)
    leaderMap = new google.maps.Map(document.getElementById('leaderMap'), {
        center: {lat: 48.00187, lng: -121.27808},
        zoom: 8
    });
    var infoWindow = new google.maps.InfoWindow({
       content: '<p>Dynamic</p>'
    });
    data.forEach((item) => {
        var marker = new google.maps.Marker({
            position: item.position,
            map: leaderMap,
            title: item.name,
            label: item.name[0]
        });
        marker.addListener('click', () => {
            var content = item.htmlPreview;
            infoWindow.setContent(content);
            infoWindow.open(leaderMap, marker); 
        });
    });
}

function escapeHTML(unsafe) {
    // https://stackoverflow.com/a/28458409
    return unsafe.replace(/[&<"']/g, function(m) {
    switch (m) {
      case '&':
        return '&amp;';
      case '<':
        return '&lt;';
      case '"':
        return '&quot;';
      default:
        return '&#039;';
    }
    });
};