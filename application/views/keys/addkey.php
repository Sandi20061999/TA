<div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-info">
                  <h4 class="card-title ">Form Add Key</h4>
                </div>
                <div class="card-body">
                <?php echo form_open('key/add'); ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Key</label>
                          <input type="text" class="form-control" name="key" value="<?php echo $this->input->post('key'); ?>" />
                          <span class="text-danger"><?php echo form_error('key');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Employee</label>
                          <select name="user_id" class="form-control">
                          <option value="">Choose Employee</option>
                          <?php 
                          foreach($all_tblemployee as $tblemployee)
                          {
                            $selected = ($tblemployee['EmpCode'] == $this->input->post('user_id')) ? ' selected="selected"' : "";
                            echo '<option value="'.$tblemployee['EmpCode'].'" '.$selected.'>'.$tblemployee['EmpName'].'</option>';
                          } 
                          ?>
                        </select>
                        <span class="text-danger"><?php echo form_error('user_id');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Division</label>
                          <input type="text" class="form-control" name="level" value="<?php echo $this->input->post('level'); ?>" />
                          <span class="text-danger"><?php echo form_error('level');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right">Add Key</button>
                      </div>
                    </div> 
                    <?php echo form_close(); ?>
                    <div class="clearfix"></div>
                </div>
              </div>
            </div>
</div>