<script src="https://maps.googleapis.com/maps/api/js"></script>

<script>
  function initialize() {
    var longcenter = document.getElementById("longcenter").innerHTML;
    var latcenter = document.getElementById("latcenter").innerHTML;
    var propertiPeta = {
      center: new google.maps.LatLng(latcenter, longcenter),
      zoom: 21,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);
    var longkiriatas = document.getElementById("longkiriatas").innerHTML;
    var latkiriatas = document.getElementById("latkiriatas").innerHTML;
    // membuat Marker
    var marker = new google.maps.Marker({
      position: new google.maps.LatLng(latkiriatas, longkiriatas),
      map: peta
    });

    var longkananatas = document.getElementById("longkananatas").innerHTML;
    var latkananatas = document.getElementById("latkananatas").innerHTML;
    // membuat Marker
    var marker2 = new google.maps.Marker({
      position: new google.maps.LatLng(latkananatas, longkananatas),
      map: peta
    });

    var longkananbawah = document.getElementById("longkananbawah").innerHTML;
    var latkananbawah = document.getElementById("latkananbawah").innerHTML;
    // membuat Marker
    var marker3 = new google.maps.Marker({
      position: new google.maps.LatLng(latkananbawah, longkananbawah),
      map: peta
    });

    var longkiribawah = document.getElementById("longkiribawah").innerHTML;
    var latkiribawah = document.getElementById("latkiribawah").innerHTML;
    // membuat Marker
    var marker4 = new google.maps.Marker({
      position: new google.maps.LatLng(latkiribawah, longkiribawah),
      map: peta
    });
  }


  google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div class="row">
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
      <div class="card-header card-header-success card-header-icon">
        <div class="card-icon">
          <i class="material-icons">supervisor_account</i>
        </div>
        <p class="card-category">Total User</p>
        <h3 class="card-title"><?php echo $totaluser; ?></h3>
      </div>
      <div class="card-footer">
        <div class="stats">
          <i class="material-icons">perm_identity</i> <a href="<?php echo base_url("listuser") ?>"> Detail ... </a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
      <div class="card-header card-header-danger card-header-icon">
        <div class="card-icon">
          <i class="material-icons">library_books</i>
        </div>
        <p class="card-category">Logs</p>
        <h3 class="card-title"><?php echo $totallog; ?></h3>
      </div>
      <div class="card-footer">
        <div class="stats">
          <i class="material-icons">info_outline</i> <a href="<?php echo base_url("listlog") ?>"> Track Log ...</a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
      <div class="card-header card-header-warning card-header-icon">
        <div class="card-icon">
          <i class="material-icons">vpn_key</i>
        </div>
        <p class="card-category">Keys</p>
        <h3 class="card-title"><?php echo $totalkey; ?></h3>

      </div>
      <div class="card-footer">
        <div class="stats">
          <i class="material-icons">info_outline</i>
          <a href="<?php echo base_url("key") ?>">Detail...</a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">

        <div class="d-none" id="latcenter"><?php echo $d['latcenter']; ?></div>
        <div class="d-none" id="longcenter"><?php echo $d['longcenter']; ?></div>

        <div class="d-none" id="longkiriatas"><?php echo $d['longkiriatas']; ?></div>
        <div class="d-none" id="latkiriatas"><?php echo $d['latkiriatas']; ?></div>

        <div class="d-none" id="longkananatas"><?php echo $d['longkananatas']; ?></div>
        <div class="d-none" id="latkananatas"><?php echo $d['latkananatas']; ?></div>

        <div class="d-none" id="longkananbawah"><?php echo $d['longkananbawah']; ?></div>
        <div class="d-none" id="latkananbawah"><?php echo $d['latkananbawah']; ?></div>

        <div class="d-none" id="longkiribawah"><?php echo $d['longkiribawah']; ?></div>
        <div class="d-none" id="latkiribawah"><?php echo $d['latkiribawah']; ?></div>

        <div class="card-body">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
              <center><a href="<?php echo base_url("dashboard/setcenter") ?>" class="btn btn-primary">Set Center Area</a></center>
            </div>
            <div class="col-md-3"></div>

          </div>
            <div class="row">
              <div class="col-md-3">
                <center><a href="<?php echo base_url("dashboard/setkiriatas") ?>" class="btn btn-primary">Set Area Titik Kiri Atas</a></center>
              </div>
              <div class="col-md-3">
                <center><a href="<?php echo base_url("dashboard/setkananatas") ?>" class="btn btn-primary">Set Area Titik Kanan Atas</a></center>
              </div>
              <div class="col-md-3">
                <center><a href="<?php echo base_url("dashboard/setkananbawah") ?>" class="btn btn-primary">Set Area Titik Kanan Bawah</a></center>
              </div>
              <div class="col-md-3">
                <center><a href="<?php echo base_url("dashboard/setkiribawah") ?>" class="btn btn-primary">Set Area Titik Kiri bawah</a></center>
              </div>
            </div>
            <div class="row">
              <div id="googleMap" style="width:1000px;height:380px;"></div>
            </div>
        </div>

      </div>
    </div>
  </div>
</div>