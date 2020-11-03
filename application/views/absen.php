<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    </head>
    <body id="load_content">
                <div class="container" >
                    <div class="row">
                        <div class="mx-auto">
                            <div class="text-center h1">
                                <a id=jam></a> | <a id=menit></a> | <a id=detik></a>
                            </div>
                            <div class="text-center h1">
                                <a id="y"></a> | <a id="m"></a> | <a id="d"></a>
                            </div>
                            
                            <br/>
                            <div class="d-flex p-2" >
                                <div><img src="<?php echo $url; ?>" /></div>
                            </div>
                        </div>
                  

                    </div>
                </div>


    </body>
</html>
<script>
	window.setTimeout("waktu()", 1000);
    var months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
    var days = ['01','02','03','04','05','06','07','08','09','10','11','12','13','14',
    '15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];
    var hours = ['00','01','02','03','04','05','06','07','08','09','10','11','12','13','14',
    '15','16','17','18','19','20','21','22','23'];
    var minutes = ['00','01','02','03','04','05','06','07','08','09','10','11','12','13','14',
    '15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31',
    '32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50'
    ,'51','52','53','54','55','56','57','58','59'];
	function waktu() {
		var waktu = new Date();
		setTimeout("waktu()", 1000);
		document.getElementById("jam").innerHTML = waktu.getHours();
		document.getElementById("menit").innerHTML = waktu.getMinutes();
        document.getElementById("detik").innerHTML = waktu.getSeconds();
    }
    window.setTimeout("qr()", 1000);
 
	function qr() {
		var qr = new Date();  
		setTimeout("qr()", 1000);

        var yy = qr.getYear();
        var mm = qr.getMonth();
        var dd = qr.getDate()-1;
        var day = days[dd];
        var month = months[mm];
        var year = (yy < 1000) ? yy + 1900 : yy;
        var menit = qr.getMinutes();
        var jam = qr.getHours();
        var menit2 = minutes[menit];
        var jam2 = hours[jam];
        document.getElementById("y").innerHTML = qr.getFullYear();
        document.getElementById("m").innerHTML = month;
        document.getElementById("d").innerHTML = day;
    }
            
</script>
