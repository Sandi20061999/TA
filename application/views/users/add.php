<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title ">Form Add User</h4>
            </div>
            <div class="card-body">
                <?php echo form_open('listuser/add'); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="bmd-label-floating">Employee Code</label>
                            <input type="text" class="form-control" name="EmpCode" value="<?php echo $this->input->post('EmpCode'); ?>" />
                            <span class="text-danger"><?php echo form_error('EmpCode'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="bmd-label-floating">Employee Name</label>
                            <input type="text" name="EmpName" class="form-control" value="<?php echo $this->input->post('EmpName'); ?>" />
                            <span class="text-danger"><?php echo form_error('EmpName'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="bmd-label-floating">Display Name</label>
                            <input type="text" name="DisplayName" class="form-control" value="<?php echo $this->input->post('DisplayName'); ?>" />
                            <span class="text-danger"><?php echo form_error('DisplayName'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="bmd-label-floating">Gender</label>
                            <select name="Gender" class="form-control">
                                <option value="">Select Gender</option>
                                <?php
                                $Gender_values = array(
                                    'L' => 'Laki-Laki',
                                    'P' => 'Perempuan',
                                );

                                foreach ($Gender_values as $value => $display_text) {
                                    $selected = ($value == $this->input->post('Gender')) ? ' selected="selected"' : "";

                                    echo '<option value="' . $value . '" ' . $selected . '>' . $display_text . '</option>';
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?php echo form_error('Gender'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="bmd-label-floating">Religion</label>
                            <select name="Religion" class="form-control">
                                <option value="">Select Religion</option>
                                <?php
                                $Religion_values = array(
                                    'Islam' => 'Islam',
                                    'Kristen' => 'Kristen',
                                    'Katolik' => 'Katolik',
                                    'Hindu' => 'Hindu',
                                    'Budha' => 'Budha',
                                );

                                foreach ($Religion_values as $value => $display_text) {
                                    $selected = ($value == $this->input->post('Religion')) ? ' selected="selected"' : "";

                                    echo '<option value="' . $value . '" ' . $selected . '>' . $display_text . '</option>';
                                }
                                ?>
                            </select>
                            <span class="text-danger"><?php echo form_error('Religion'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="bmd-label-floating">Mobile</label>
                            <input type="text" name="Mobile" class="form-control" value="<?php echo $this->input->post('Mobile'); ?>" />
                            <span class="text-danger"><?php echo form_error('Mobile'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="bmd-label-floating">Email</label>
                            <input type="text" name="Email" class="form-control" value="<?php echo $this->input->post('Email'); ?>" />
                            <span class="text-danger"><?php echo form_error('Email'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="bmd-label-floating">Address</label>
                            <textarea class="form-control" name="Address"><?php echo $this->input->post('Address'); ?></textarea>
                            <span class="text-danger"><?php echo form_error('Address'); ?></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary pull-right">Save</button>

                <?php echo form_close(); ?>