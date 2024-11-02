<?php 
$edit_data = $this->db->get_where('consultation_charge', array('id' => '1'))->result_array();
?><div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary" >
            <div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo get_phrase('edit_consultation_charge');?></h4>
                </div>
            </div>
            <div class="panel-body">
                <?php
                foreach($edit_data as $row):
                    ?>
                    <?php echo form_open(site_url('admin/manage_consultation/update_consultation_charge'), array('class' => 'form-horizontal form-groups validate','target'=>'_top'));?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('name');?><small style="color:red">*</small></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('qty');?></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="qty" value="<?php echo $row['qty'];?>" required readonly/>
                            </div>
                        </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Price');?><small style="color:red">*</small></label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="price" value="<?php echo $row['price'];?>" required/>
                            </div>
                        </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Discount_type');?></label>
                            <div class="col-sm-5">
                             

<select class="form-control" name="discount_type" >


  <option value="fixed" <?php if($row['discount_type']=="fixed"){ echo"selected"; } ?>>Fixed</option>
  <option value="percentage" <?php if($row['discount_type']=="percentage"){ echo"selected"; } ?>>%</option>


</select>

                            </div>
                        </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo get_phrase('Discount_Value');?>/%</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="discount_price" value="<?php echo $row['discount_price'];?>" />
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-offset-3 col-sm-5">
                              <button type="submit" class="btn btn-success">
                                  <i class="fa fa-check"></i>&nbsp;
                                  <?php echo get_phrase('update_charge');?></button>
                          </div>
                            </div>
                    </form>
                    <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
</div>