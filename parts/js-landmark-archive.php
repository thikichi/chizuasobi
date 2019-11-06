<script>
// var markerData = [];
var mapLatLng = getCenerLatLng( 35.681236, 139.767125 );
var map = initMap( 'ArchiveLandmarkMapMain', mapLatLng, 10.0 );
var markerData = <?php echo json_encode($markers); ?>;
markerMapArea = dispMarker2( map, markerData );
var target1 = document.getElementById('sample1');
jQuery(function($) {
  $(function(){
    $('[data-mapid]').on('click', function(event) {
      var map_post_id = $(this).data('mapid');
      google.maps.event.trigger(markerMapArea[map_post_id], "click");
    });
  });
});
</script>