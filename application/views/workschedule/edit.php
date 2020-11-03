<div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-info">
                  <h4 class="card-title ">Form Edit Schedule</h4>
                </div>
                <div class="card-body">
                <?php echo form_open('workschedule/edit/'.$workschedule['WSCode']); ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Work Schedule Name</label>
                          <input type="text" class="form-control" name="WSName" value="<?php echo $this->input->post('WSName')? $this->input->post('WSName') : $workschedule['WSName']; ?>" />
		                      <span class="text-danger"><?php echo form_error('WSName');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">In</label>
                          <input type="text" name="In1" class="form-control" value="<?php echo $this->input->post('In1') ? $this->input->post('In1') : 
                            $jam = substr($workschedule['In1'],0,2).":".substr($workschedule['In1'],2,2); ?>" />
                          <small>Format hh:mm (12:00)</small>
                          <span class="text-danger"><?php echo form_error('In1');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Range In Start</label>
                          <input type="text" name="bIn1" class="form-control" value="<?php echo $this->input->post('bIn1') ? $this->input->post('bIn1') :
                           $jam2 = substr($workschedule['bIn1'],0,2).":".substr($workschedule['bIn1'],2,2); ?>" />
                          <small>Format hh:mm (12:00)</small>
                          <span class="text-danger"><?php echo form_error('bIn1');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Range In End</label>
                          <input type="text" name="aIn1" class="form-control" value="<?php echo $this->input->post('aIn1') ? $this->input->post('aIn1') :
                           $jam3 = substr($workschedule['aIn1'],0,2).":".substr($workschedule['aIn1'],2,2); ?>" />
                          <small>Format hh:mm (12:00)</small>
		                  <span class="text-danger"><?php echo form_error('aIn1');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Out</label>
                          <input type="text" name="Out1" class="form-control" value="<?php echo $this->input->post('Out1')? $this->input->post('Out1') :
                          $jam4 = substr($workschedule['Out1'],0,2).":".substr($workschedule['Out1'],2,2); ?>" />
                          <small>Format hh:mm (12:00)</small>
		                  <span class="text-danger"><?php echo form_error('Out1');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Range Out Start</label>
                          <input type="text" name="bOut1" class="form-control" value="<?php echo $this->input->post('bOut1')? $this->input->post('bOut1') : 
                          $jam5 = substr($workschedule['bOut1'],0,2).":".substr($workschedule['bOut1'],2,2); ?>" />
                          <small>Format hh:mm (12:00)</small>
		                  <span class="text-danger"><?php echo form_error('bOut1');?></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Range Out End</label>
                          <input type="text" name="aOut1" class="form-control" value="<?php echo $this->input->post('aOut1')? $this->input->post('aOut1') : 
                          $jam6 = substr($workschedule['aOut1'],0,2).":".substr($workschedule['aOut1'],2,2); ?>" />
                          <small>Format hh:mm (12:00)</small>
		                  <span class="text-danger"><?php echo form_error('aOut1');?></span>
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


