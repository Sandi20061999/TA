<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">

<div class="row">
  <div class="col-md-12">
    <div id="notifications"><?php echo $this->session->flashdata('msg'); ?></div>

    <div class="card">
      <div class="card-header card-header-info">
        <h4 class="card-title ">List Work Schedule <?php echo $detailuser['EmpName']; ?></h4>
      </div>
      <div class="card-body">
        <a href="<?php echo base_url("listuser/addschedule/" . $detailuser['EmpCode']) ?>"><i class="material-icons pull-left">add_circle_outline</i> Add Schedule</a>
        <hr>
        <div class="table-responsive">
          <table id="example" class="table">
            <thead class="text-primary">
              <th>
                No
              </th>
              <th>
                Work Schedule
              </th>
              <th>
                Type
              </th>
              <th>
                In
              </th>
              <th>
                Out
              </th>
              <th>
                Date
              </th>
              <th>
                Create Date
              </th>
              <th>
                Action
              </th>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($empworkschedule as $t) { ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $t['WSName']; ?></td>
                  <td><?php echo $t['Type']; ?></td>

                  <td><?php $jam = substr($t['In1'], 0, 2);
                      $menit = substr($t['In1'], 2, 2);
                      if ($t['HolidayInd'] == "Y") {
                        echo "-";
                      } else {
                        echo $jam . ":" . $menit;
                      } ?></td>
                  <td><?php $jam2 = substr($t['Out1'], 0, 2);
                      $menit2 = substr($t['Out1'], 2, 2);
                      if ($t['HolidayInd'] == "Y") {
                        echo "-";
                      } else {
                        echo $jam2 . ":" . $menit2;
                      } ?></td>

                  <td><?php
                      $tahun1 = substr($t['Dt'], 0, 4);
                      $bulan1 = substr($t['Dt'], 4, 2);
                      $tanggal1 = substr($t['Dt'], 6, 2);
                      echo $tanggal1 . " - " . $bulan1 . " - " . $tahun1;
                      ?></td>
                  <td><?php
                      $tahun = substr($t['CreateDt'], 0, 4);
                      $bulan = substr($t['CreateDt'], 4, 2);
                      $tanggal = substr($t['CreateDt'], 6, 2);
                      echo $tanggal . " - " . $bulan . " - " . $tahun;
                      ?></td>

                  <td>
                    <a href="<?php echo base_url("listuser/editschedule/" . $detailuser['EmpCode'] . "/" . $t['Dt']); ?>" class="badge badge-warning"> Edit </a>
                    <a href="<?php echo base_url("listuser/removeschedule/" . $detailuser['EmpCode'] . "/" . $t['Dt']); ?>" class="badge badge-danger"> Delete </a>
                  </td>
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
  });
  $('#notifications').slideDown('slow').delay(3000).slideUp('slow');
</script>