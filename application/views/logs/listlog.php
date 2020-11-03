
    
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">

<div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-info">
                  <h4 class="card-title ">Data Log</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="example"  class="table">
                      <thead class="text-primary">
                        <th>
                          No
                        </th>
                        <th>
                          Date
                        </th>
                        <th>
                          Time
                        </th>
                        <th>
                          Machine
                        </th>
                        <th>
                          IP Address
                        </th>
                        <th>Latitude, Longitude</th>
                      </thead>
                      <tbody>
                      <?php 
                    $no = 1;
                    foreach($listlog as $t){ ?>
                    <tr>
						<td><?php echo $no++; ?></td>
                        <td><?php  
                            $tahun = substr($t['Dt'],0,4);
                            $bulan = substr($t['Dt'],4,2);
                            $tanggal = substr($t['Dt'],6,2);
                            echo $tanggal." - ".$bulan." - ".$tahun;
                        ?></td>
                        <td><?php  
                            $jam = substr($t['Tm'],0,2);
                            $menit = substr($t['Tm'],2,2);
                            echo $jam.":".$menit;
                        ?></td>
						<td><?php echo $t['Machine'];?></td>
						<td><?php echo $t['IPAddress'];?></td>
						<td><?php echo $t['Latitude']." , ".$t['Longitude'];?></td>
                    </tr>
                    <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>


    
    

<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>