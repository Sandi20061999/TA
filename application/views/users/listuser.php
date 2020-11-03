<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div id="notifications"><?php echo $this->session->flashdata('msg'); ?></div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-info">
        <h4 class="card-title ">Data User</h4>
      </div>
      <div class="card-body">
        <a href="<?php echo base_url("listuser/add") ?>"><i class="material-icons pull-left">add_circle_outline</i> Add User</a>
        <hr>
        <div class="table-responsive">
          <table id="example" class="table">
            <thead class="text-primary">
              <th>
                No
              </th>
              <th>
                Name
              </th>
              <th>
                Action
              </th>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($listuser as $t) { ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $t['EmpName']; ?></td>
                  <td>
                    <a href="<?php echo base_url('allreport/reportemp/' . $t['EmpCode']); ?>" class="badge badge-info"> Detail .. </a>
                    <a href="<?php echo base_url('listuser/schedule/' . $t['EmpCode']); ?>" class="badge badge-info"> Schedule </a>

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