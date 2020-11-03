<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-info">
        <h4 class="card-title ">Form Add Customer</h4>
      </div>
      <div class="card-body">
        <?php echo form_open('listuser/editschedule/' . $emp . '/' . $Dt); ?>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label class="bmd-label-floating">Type Schedule</label>
              <select name="Schedule" class="form-control">
                <option value="">Choose Schedule</option>
                <?php
                foreach ($workschedule as $t) {
                  $selected = ($t['WSCode'] == $get_schedule['WSCode']) ? ' selected="selected"' : "";
                  if ($t['WSCode'] == $get_schedule['WSCode']) {
                    echo '<option value="' . $t['WSCode'] . '" ' . $selected . '>' . $t['WSName'] . '</option>';
                  } else {
                    echo '<option value="' . $t['WSCode'] . '">' . $t['WSName'] . '</option>';
                  }
                }
                ?>
              </select>
              <span class="text-danger"><?php echo form_error('Schedule'); ?></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label class="bmd-label-floating">Type(default : WFO)</label>
              <select name="Type" class="form-control">
                <?php
                // var_dump($type);
                // die;
                if ($type['Type'] == 'WFO') {
                ?>
                  <option value="WFO" selected>WFO</option>
                  <option value="WFH">WFH</option>
                <?php
                } else {
                ?>
                  <option value="WFO">WFO</option>
                  <option value="WFH" selected>WFH</option>
                <?php
                }
                ?>

              </select>
              <span class="text-danger"><?php echo form_error('Type'); ?></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary pull-right">Edit Schedule</button>
          </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>