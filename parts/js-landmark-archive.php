<?php global $markers; ?>
<script>
var mapLatLng = getCenerLatLng( 35.681236, 139.767125 );
var map = initMap( 'ArchiveLandmarkMapMain', mapLatLng, 10.0 );
var markerData = <?php echo json_encode($markers); ?>;
markerMapArea = dispMarker2( map, markerData );
function clickViewMap( linkid ) {
  google.maps.event.trigger(markerMapArea['ArchiveLandmarkMapMain_' + linkid], "click");
  document.getElementById('ArchiveLandmarkMapPLink').scrollIntoView({behavior: 'smooth'});
}
</script>