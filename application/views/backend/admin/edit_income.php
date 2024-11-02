<?php
$income_head = $this->db->get('income_head')->result_array();
$single_income = $this->db->get_where('income', array('inc_id' => $param2))->result_array();
foreach ($single_income as $row) {
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Edit Income</h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups validate"
                    action="<?php echo site_url('admin/income/update/'.$row['inc_id']); ?>" 
                        method="post" enctype="multipart/form-data">

                        <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Income Head <span style="color:red">*</span></label>

                        <div class="col-sm-7">
                            <select name="income_head_id" class="form-control">
                                <option value="">Select</option>
                                <?php foreach ($income_head as $row1) { ?>
                                    <option value="<?php echo $row1['income_id']; ?>" <?php if ($row['income_head_id'] == $row1['income_id']) echo 'selected'; ?>><?php echo $row1['income_head_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> 

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Name <span style="color:red">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="name" value="<?php echo $row['name']; ?>" class="form-control" id="name" placeholder="" required>
                        </div>
                    </div> 
                    
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Invoice No </label>

                        <div class="col-sm-7">
                            <input type="text" name="invoice_no" value="<?php echo $row['invoice_no']; ?>" class="form-control" id="invoice_no" placeholder="">
                        </div>
                    </div>  

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Date <span style="color:red">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="date" value="<?php echo date('d/m/Y', strtotime($row['date'])); ?>" class="form-control datepicker" id="date" required>
                        </div>
                    </div>  

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Amount(Rs.) <span style="color:red">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="amount" value="<?php echo $row['amount']; ?>" class="form-control" id="amount" placeholder="" required>
                        </div>
                    </div>  

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Attach Document </label>

                        <div class="col-sm-7">
                            <input type="file" name="document" value="<?php echo $row['document']; ?>" class="form-control" accept=".jpg, .jpeg, .png, .doc, .docx, .pdf, .txt">                            
                        </div>                        
                    </div> 

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Description</label>

                        <div class="col-sm-7">
                        <textarea name="description" class="form-control" id="description"
                                rows="5"><?php echo $row['description']; ?></textarea>                            
                        </div>
                    </div>                                
                    
                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> Update
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
<?php } ?>
