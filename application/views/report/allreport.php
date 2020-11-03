<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-info">
        <h4 class="card-title">Presence Report</h4>
      </div>
      <div class="card-body">
        <?php echo form_open('allreport/goto2'); ?>
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
                <a href="<?php echo ($this->uri->segment(3) != null && $this->uri->segment(4) != null) ? base_url('allreport/cetakLaporan/') . $this->uri->segment(3) . '/' . $this->uri->segment(4) : base_url('allreport/cetakLaporan/'); ?>" class="btn btn-outline-light pull-right">Export</a>
                <h4 class="card-title ">Report Table</h4>
                <?php
                if ($this->uri->segment(3) != null && $this->uri->segment(4) != null) {
                ?>
                  <p class="card-category">From : <?php $tahun1 = substr($this->uri->segment(3), 0, 4);
                                                  $bulan1 = substr($this->uri->segment(3), 4, 2);
                                                  $tanggal1 = substr($this->uri->segment(3), 6, 2);
                                                  echo $tanggal1 . "-" . $bulan1 . "-" . $tahun1; ?> --- To : <?php $tahun2 = substr($this->uri->segment(4), 0, 4);
                                                                                                              $bulan2 = substr($this->uri->segment(4), 4, 2);
                                                                                                              $tanggal2 = substr($this->uri->segment(4), 6, 2);
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
                    </thead>
                    <tbody>
                      <?php
                      foreach ($emp as $e) {
                      ?>
                        <tr>
                          <td>
                            <h4><?php echo $e['EmpName']; ?></h4>
                          </td>
                          <?php
                          foreach ($jadwal as $j) {
                            if ($j['emp']['EmpCode'] == $e['EmpCode']) {
                              foreach ($j['empworkschedule'] as $jEMP) {
                                if ($this->uri->segment(3) != null && $this->uri->segment(4) != null) {
                                  if ($jEMP['Dt'] >= $this->uri->segment(3) && $jEMP['Dt'] <= $this->uri->segment(4)) {
                          ?><td>
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
                                    </td>
                                  <?php    }
                                } else { ?>
                                  <td>
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
                                  </td>
                          <?php
                                }
                              }
                            }
                          } ?>
                        </tr>
                        <tr>
                          <td>
                            <center>
                              <h6>Tanggal/KJ/Jenis/Waktu/Selisih</h6>
                            </center>
                          </td>
                          <?php
                          foreach ($jadwal as $j) {
                            if ($j['emp']['EmpCode'] == $e['EmpCode']) {
                              foreach ($j['empworkschedule'] as $jEMP) {
                                if ($this->uri->segment(3) != null && $this->uri->segment(4) != null) {
                                  if ($jEMP['Dt'] >= $this->uri->segment(3) && $jEMP['Dt'] <= $this->uri->segment(4)) {
                          ?><td>
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
                                } else { ?>

                                  <td>
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

                          <?php }
                              }
                            }
                          } ?>
                        </tr>
                        <tr></tr>

                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                  <br>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>