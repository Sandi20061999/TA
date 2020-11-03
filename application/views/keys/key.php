<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">

<div class="row">
  <div class="col-md-12">
    <div id="notifications"><?php echo $this->session->flashdata('msg'); ?></div>
    <div class="card">
      <div class="card-header card-header-info">
        <h4 class="card-title ">Data Key</h4>
      </div>
      <div class="card-body">
        <a href="<?php echo base_url("key/add") ?>"><i class="material-icons pull-left">add_circle_outline</i> Add Key</a>
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
                EmpCode
              </th>
              <th>
                Key
              </th>
              <th>
                Level
              </th>
              <th>
                Action
              </th>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($key as $t) { ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $t['EmpName']; ?></td>
                  <td><?php echo $t['EmpCode']; ?></td>
                  <td><?php echo $t['key']; ?></td>
                  <td><?php echo $t['level']; ?></td>


                  <td>
                    <!-- <a href="<?php //echo base_url("key/edit/".$t['id']); 
                                  ?>" class="badge badge-warning"> Edit </a>     -->
                    <a href="<?php echo base_url("key/remove/" . $t['key']); ?>" class="badge badge-danger"> Delete </a>
                    <a href="<?php echo base_url("key/reset_login/" . $t['key']); ?>" class="badge badge-danger"> Reset Token </a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
            </tableid="dtBasicExample">
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