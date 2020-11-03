<script src="https://maps.googleapis.com/maps/api/js"></script>

<script>
// variabel global marker
var marker;
  
function taruhMarker(peta, posisiTitik){
    
    if( marker ){
      // pindahkan marker
      marker.setPosition(posisiTitik);
    } else {
      // buat marker baru
      marker = new google.maps.Marker({
        position: posisiTitik,
        map: peta
      });
    }
  
     // isi nilai koordinat ke form
    document.getElementById("lat").value = posisiTitik.lat();
    document.getElementById("lng").value = posisiTitik.lng();
    
}

function initialize() {
    var longcenter = document.getElementById("longcenter").innerHTML;
    var latcenter = document.getElementById("latcenter").innerHTML;
  var propertiPeta = {
    center:new google.maps.LatLng(latcenter,longcenter),
    zoom:21,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  
  var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);
  
  // even listner ketika peta diklik
  google.maps.event.addListener(peta, 'click', function(event) {
    taruhMarker(this, event.latLng);
  });

}


// event jendela di-load  
google.maps.event.addDomListener(window, 'load', initialize);
  

</script>
  <div id="googleMap" style="width:100%;height:380px;"></div>
  
  <?php echo form_open('dashboard/setkananbawah'); ?>
    <input type="text" id="lat" name="lat" value="">
    <span class="text-danger"><?php echo form_error('lat');?></span>

    <input type="text" id="lng" name="lng" value="">
    <span class="text-danger"><?php echo form_error('lng');?></span>

    <button type="submit" class="btn btn-primary pull-right">Set Area</button>
<?php echo form_close(); ?>
<div class="d-none" id="latcenter"><?php echo $d['latcenter']; ?></div>
<div class="d-none" id="longcenter"><?php echo $d['longcenter']; ?></div>

