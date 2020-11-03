<div class="row">
  <div class="col-md-8">
    <div id="notifications"><?php echo $this->session->flashdata('msg'); ?></div>

    <div class="card">
      <div class="card-header card-header-info">
        <h4 class="card-title">Presence Report</h4>
      </div>
      <?php echo form_open('allreport/ke/' . $this->uri->segment(3) . '/'); ?>
      <div class="card-body">
        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <label class="bmd-label-floating pull-right">From</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <input type="date" name="ta" class="form-control">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label class="bmd-label-floating pull-right">To</label>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <input type="date" name="tb" class="form-control">
            </div>
          </div>
          <button type="submit" class="btn btn-primary pull-right">Set</button>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-info">
                <a href="<?php echo ($this->uri->segment(4) != null && $this->uri->segment(5) != null) ? base_url('allreport/cetakLaporanEmp/') . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) : base_url('allreport/cetakLaporanEmp/') . $this->uri->segment(3); ?>" class="btn btn-outline-light pull-right">Export</a>
                <h4 class="card-title ">Report Table</h4>
                <?php
                if ($this->uri->segment(4) != null && $this->uri->segment(5) != null) {
                ?>
                  <p class="card-category">From : <?php $tahun1 = substr($this->uri->segment(4), 0, 4);
                                                  $bulan1 = substr($this->uri->segment(4), 4, 2);
                                                  $tanggal1 = substr($this->uri->segment(4), 6, 2);
                                                  echo $tanggal1 . "-" . $bulan1 . "-" . $tahun1; ?> --- To : <?php $tahun2 = substr($this->uri->segment(5), 0, 4);
                                                                                                              $bulan2 = substr($this->uri->segment(5), 4, 2);
                                                                                                              $tanggal2 = substr($this->uri->segment(5), 6, 2);
                                                                                                              echo $tanggal2 . "-" . $bulan2 . "-" . $tahun2; ?></p>
                <?php
                } else {
                ?>
                  <p class="card-category"> All Date</p>
                <?php
                }
                ?>
              </div>
              <div class="card-body">
                <div class="table-responsive">

                  <table class="table">
                    <thead class=" text-primary">
                      <tr>
                        <th></th>
                        <?php
                        foreach ($jadwal as $j) {
                          foreach ($j['empworkschedule'] as $jEMP) {
                            if ($this->uri->segment(4) != null && $this->uri->segment(5) != null) {
                              if ($jEMP['Dt'] >= $this->uri->segment(4) && $jEMP['Dt'] <= $this->uri->segment(5)) {
                        ?><th>
                                  <h6>
                                    <center>
                                      <?php
                                      $tahun1 = substr($jEMP['Dt'], 0, 4);
                                      $bulan1 = substr($jEMP['Dt'], 4, 2);
                                      $tanggal1 = substr($jEMP['Dt'], 6, 2);
                                      echo $tanggal1 . "-" . $bulan1 . "-" . $tahun1;
                                      ?>
                                    </center>
                                  </h6>
                                </th>
                              <?php    }
                            } else { ?>
                              <th>
                                <h6>
                                  <center>
                                    <?php
                                    $tahun1 = substr($jEMP['Dt'], 0, 4);
                                    $bulan1 = substr($jEMP['Dt'], 4, 2);
                                    $tanggal1 = substr($jEMP['Dt'], 6, 2);
                                    echo $tanggal1 . "-" . $bulan1 . "-" . $tahun1;
                                    ?>
                                  </center>
                                </h6>
                              </th>
                        <?php   }
                          }
                        } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <center>
                            <h6>Tanggal/KJ/Jenis/Waktu/Selisih</h6>
                          </center>
                        </td>
                        <?php
                        foreach ($jadwal as $j) {
                          foreach ($j['empworkschedule'] as $jEMP) {
                            if ($this->uri->segment(4) != null && $this->uri->segment(5) != null) {
                              if ($jEMP['Dt'] >= $this->uri->segment(4) && $jEMP['Dt'] <= $this->uri->segment(5)) { ?><td>
                                  <h6>
                                    <center>
                                      <?php
                                      foreach ($absen as $h) {
                                        if ($jEMP['EmpCode'] == $h['emp']) {
                                          foreach ($h[0] as $hlog) {
                                            if ($hlog['nama'] == 'Holiday' && $hlog['log']['tgl'] == $jEMP['Dt']) {
                                              $tahun1 = substr($hlog['log']['tgl'], 0, 4);
                                              $bulan1 = substr($hlog['log']['tgl'], 4, 2);
                                              $tanggal1 = substr($hlog['log']['tgl'], 6, 2);
                                              echo $tanggal1 . "-" . $bulan1 . "-" . $tahun1 . '/' . $hlog['nama'];
                                            }
                                            if ($hlog['nama'] != 'Holiday' && $hlog['log']['tgl'] == $jEMP['Dt']) {
                                              $tahun1 = substr($hlog['log']['tgl'], 0, 4);
                                              $bulan1 = substr($hlog['log']['tgl'], 4, 2);
                                              $tanggal1 = substr($hlog['log']['tgl'], 6, 2);
                                              echo $tanggal1 . "-" . $bulan1 . "-" . $tahun1 . '/' . $hlog['nama'] . '/';
                                              echo ($hlog['log']['jenis'] == 'Masuk') ? $hlog['log']['jenis'] . '/' . $hlog['log']['tm'] . '/' . $hlog['log']['selisih'] . ' | ' : $hlog['log']['jenis'] . '/' . $hlog['log']['tm'] . '/' . $hlog['log']['selisih'];
                                            }
                                          }
                                        }
                                      }
                                      ?>
                                    </center>
                                  </h6>
                                </td>
                              <?php    }
                            } else { ?><td>
                                <h6>
                                  <center>
                                    <?php
                                    foreach ($absen as $h) {
                                      if ($jEMP['EmpCode'] == $h['emp']) {
                                        foreach ($h[0] as $hlog) {
                                          if ($hlog['nama'] == 'Holiday' && $hlog['log']['tgl'] == $jEMP['Dt']) {
                                            $tahun1 = substr($hlog['log']['tgl'], 0, 4);
                                            $bulan1 = substr($hlog['log']['tgl'], 4, 2);
                                            $tanggal1 = substr($hlog['log']['tgl'], 6, 2);
                                            echo $tanggal1 . "-" . $bulan1 . "-" . $tahun1 . '/' . $hlog['nama'];
                                          }
                                          if ($hlog['nama'] != 'Holiday' && $hlog['log']['tgl'] == $jEMP['Dt']) {
                                            $tahun1 = substr($hlog['log']['tgl'], 0, 4);
                                            $bulan1 = substr($hlog['log']['tgl'], 4, 2);
                                            $tanggal1 = substr($hlog['log']['tgl'], 6, 2);
                                            echo $tanggal1 . "-" . $bulan1 . "-" . $tahun1 . '/' . $hlog['nama'] . '/';
                                            echo ($hlog['log']['jenis'] == 'Masuk') ? $hlog['log']['jenis'] . '/' . $hlog['log']['tm'] . '/' . $hlog['log']['selisih'] . ' | ' : $hlog['log']['jenis'] . '/' . $hlog['log']['tm'] . '/' . $hlog['log']['selisih'];
                                          }
                                        }
                                      }
                                    }
                                    ?>
                                  </center>
                                </h6>
                              </td><?php
                                  }
                                }
                              } ?>
                      </tr>
                    </tbody>
                  </table>
                  <br>

                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="clearfix"></div>
      </div>
      <?php echo form_close(); ?>

    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-profile">
      <div class="card-avatar">
        <a href="javascript:;">
          <img class="img" src="<?php echo base_url("assets/img/faces/marc.jpg") ?>" />
        </a>
      </div>
      <div class="card-body">
        <!-- <h6 class="card-category text-gray">Programmer</h6> -->
        <h4 class="card-title"><?php echo $detailuser['EmpName']; ?></h4>
        <p class="card-description">

        </p>
        <a href="<?php echo site_url('listuser/edit/' . $detailuser['EmpCode']); ?>" class="btn btn-warning btn-round">Edit User</a>
        <a href="<?php echo site_url('listuser/remove/' . $detailuser['EmpCode']); ?>" class="btn btn-danger btn-round">Delete User</a>
      </div>
    </div>
  </div>
</div>

<script>
  $('#notifications').slideDown('slow').delay(3000).slideUp('slow');
</script>