<div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-info">
                  <h4 class="card-title ">Form Edit Key</h4>
                </div>
                <div class="card-body">
                <?php echo form_open('key/edit/'.$key['id']); ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Key</label>
                          <input type="text" name="key" class="form-control" value="<?php echo ($this->input->post('key') ? $this->input->post('key') : $key['key']); ?>" />
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
                            $selected = ($tblemployee['EmpCode'] == $key['user_id']) ? ' selected="selected"' : "";

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
                          <label class="bmd-label-floating">Divisi</label>
                          <input type="text" name="level" class="form-control" value="<?php echo ($this->input->post('level') ? $this->input->post('level') : $key['level']); ?>" />
                          <span class="text-danger"><?php echo form_error('level');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right">Edit Key</button>
                      </div>
                    </div> 
                    <div class="clearfix"></div>
                    <?php echo form_close(); ?>
                </div>
              </div>
            </div>
</div>