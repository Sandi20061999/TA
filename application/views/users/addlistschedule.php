<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header card-header-info">
        <h4 class="card-title ">Form Add Customer</h4>
      </div>
      <div class="card-body">
        <?php echo form_open('listuser/addschedule/' . $emp); ?>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label class="bmd-label-floating">Type Schedule</label>
              <select name="Schedule" class="form-control">
                <option value="">Choose Schedule</option>
                <?php
                foreach ($workschedule as $t) {
                  $selected = ($t['WSCode'] == $this->input->post('WSCode')) ? ' selected="selected"' : "";
                  echo '<option value="' . $t['WSCode'] . '" ' . $selected . '>' . $t['WSName'] . '</option>';
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
                <option value="WFO" selected>WFO</option>
                <option value="WFH">WFH</option>
              </select>
              <span class="text-danger"><?php echo form_error('Type'); ?></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <input type="radio" value="1" onclick="single()" name="choice">Single</input>
              <br>
              <input type="radio" value="2" onclick="range()" name="choice">Range</input>
            </div>
          </div>
        </div>
        <div id="fr"></div>

        <div class="row">
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary pull-right">Add Schedule</button>
          </div>
        </div>
        <?php echo form_close(); ?>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>

<script>


  function single() {
    $('#fr').html('<div class="row"><div class="col-md-12"><div class="form-group"><label class="">Date</label><input type="date" name="Dt" class="form-control" value="<?php echo $this->input->post('Dt'); ?>" /><span class="text-danger"><?php echo form_error('Dt'); ?></span></div></div></div>');
  }

  function range() {
    $('#fr').html('<div class="row"><div class="col-md-6"><div class="form-group"><label class="">Date first</label><input type="date" name="DtFirst" class="form-control" value="<?php echo $this->input->post('DtFirst'); ?>" /><span class="text-danger"><?php echo form_error('Dt'); ?></span></div></div><div class="col-md-6"><div class="form-group"><label class="">Date last</label><input type="date" name="DtLast" class="form-control" value="<?php echo $this->input->post('DtLast'); ?>" /><span class="text-danger"><?php echo form_error('Dt'); ?></span></div></div></div>');
  }
</script>