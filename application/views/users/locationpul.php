<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>
function initialize() {
  var propertiPeta = {
    center:new google.maps.LatLng(-7.7810386,110.3659139),
    zoom:24,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  
  var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);
  var longdat=document.getElementById("longdat").innerHTML;
  var latdat=document.getElementById("latdat").innerHTML;
  // membuat Marker
  var marker=new google.maps.Marker({
      position: new google.maps.LatLng(latdat,longdat),
      map: peta
  });
}

 
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-info">
                  <h4 class="card-title">Lokasi Absen Pulang</h4>
                  <div class="card-category" id="longdat"><?php echo $pul['Longitude']; ?></div>
                  <div class="card-category" id="latdat"><?php echo $pul['Latitude'];?></div>
                </div>
                <div class="card-body">
                    <div class="row">
                      <div id="googleMap" style="width:100%;height:380px;"></div>
                    </div> 
                </div>
              </div>
            </div>
          </div>