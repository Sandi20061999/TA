<div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-info">
                  <h4 class="card-title ">Form Add Schedule</h4>
                </div>
                <div class="card-body">
                <?php echo form_open('workschedule/add'); ?>
                <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Work Schedule Code</label>
                          <input type="text" class="form-control" name="WSCode" value="<?php echo $this->input->post('WSCode'); ?>" />
		                      <span class="text-danger"><?php echo form_error('WSCode');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Work Schedule Name</label>
                          <input type="text" class="form-control" name="WSName" value="<?php echo $this->input->post('WSName'); ?>" />
		                      <span class="text-danger"><?php echo form_error('WSName');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">In</label>
                          <input type="text" name="In1" class="form-control" value="<?php echo $this->input->post('In1'); ?>" />
                          <small>Format hh:mm (12:00)</small>
                          <span class="text-danger"><?php echo form_error('In1');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Range In Start</label>
                          <input type="text" name="bIn1" class="form-control" value="<?php echo $this->input->post('bIn1'); ?>" />
                          <small>Format hh:mm (12:00)</small>
                          <span class="text-danger"><?php echo form_error('bIn1');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Range In End</label>
                          <input type="text" name="aIn1" class="form-control" value="<?php echo $this->input->post('aIn1'); ?>" />
                          <small>Format hh:mm (12:00)</small>
		                  <span class="text-danger"><?php echo form_error('aIn1');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Out</label>
                          <input type="text" name="Out1" class="form-control" value="<?php echo $this->input->post('Out1'); ?>" />
                          <small>Format hh:mm (12:00)</small>
		                  <span class="text-danger"><?php echo form_error('Out1');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Range Out Start</label>
                          <input type="text" name="bOut1" class="form-control" value="<?php echo $this->input->post('bOut1'); ?>" />
                          <small>Format hh:mm (12:00)</small>
		                  <span class="text-danger"><?php echo form_error('bOut1');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Range Out End</label>
                          <input type="text" name="aOut1" class="form-control" value="<?php echo $this->input->post('aOut1'); ?>" />
                          <small>Format hh:mm (12:00)</small>
		                  <span class="text-danger"><?php echo form_error('aOut1');?></span>
                        </div>
                      </div>
                    </div>
                    
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