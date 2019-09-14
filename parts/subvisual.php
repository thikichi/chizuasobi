<div id="SubVisual" class="subvisual">
  <div id="demoMap" class="subvisual-inner" style="height:100%"></div>
</div>
<?php
if( is_singular('landmark') ) {
    $field_map = get_post_meta( $post->ID, 'acf_landmark_gmap', true );
    // $jps_lat = convert_to_jgs( $map_location['lat'] );
    $lat = $field_map['lat'];
    $lng = $field_map['lng'];
} else {
    $lat = 139.76;
    $lng = 35.68;
}
?>




<script type="text/javascript" src="http://www.openlayers.org/api/OpenLayers.js"></script>
<script>
// 
// Static Marker sample
// http://openstreetmap.piyolab.net/markeronmap.php を参考
//
function static_marker_sample() {
     
    var options = {
        controls:[
            // new OpenLayers.Control.Navigation(),
            // new OpenLayers.Control.NavToolbar(),
            // new OpenLayers.Control.PanZoomBar(),
            new OpenLayers.Control.ScaleLine(),
//          new OpenLayers.Control.ZoomPanel(),
            new OpenLayers.Control.Attribution()
            ],
    };
     
    var map = new OpenLayers.Map("demoMap", options);
    map.addLayer(new OpenLayers.Layer.OSM());
     
    console.log(map.getProjectionObject().getCode());
     
    map.setCenter(new OpenLayers.LonLat( <?php echo $lng; ?>, <?php echo $lat; ?> )
        .transform(
                new OpenLayers.Projection("EPSG:4326"),  // WGS84
                new OpenLayers.Projection("EPSG:3857")   // Google Map / OSM / etc の球面メルカトル図法
        ), 8
    );
     
    // マーカー
    var markers = new OpenLayers.Layer.Markers("Markers");
    map.addLayer(markers);
    var marker = new OpenLayers.Marker(
        new OpenLayers.LonLat( <?php echo $lng; ?>, <?php echo $lat; ?> )
            .transform(
                new OpenLayers.Projection("EPSG:4326"),
                new OpenLayers.Projection("EPSG:900913")
            )
    );
    markers.addMarker(marker);  
 
    // var marker2 = new OpenLayers.Marker(
    //         new OpenLayers.LonLat(140.76, 35.68)
    //             .transform(
    //                 new OpenLayers.Projection("EPSG:4326"),
    //                 new OpenLayers.Projection("EPSG:900913")
    //             )
    //     );
    // markers.addMarker(marker2);
}
static_marker_sample();
// https://blog.mori-soft.com/entry/%3Fp%3D535
</script>