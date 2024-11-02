<?php $income_head = $this->db->get('income_head')->result_array(); ?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <h3>Add Income</h3>
                </div>
            </div>

            <div class="panel-body">

                <form role="form" class="form-horizontal form-groups validate"
                    action="<?php echo site_url('admin/income/create'); ?>" 
                        method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Income Head <span style="color:red">*</span></label>

                        <div class="col-sm-7">
                            <select name="income_head_id" class="form-control">
                                <option value="">Select</option>
                                <?php foreach ($income_head as $row) { ?>
                                    <option value="<?php echo $row['income_id']; ?>"><?php echo $row['income_head_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> 

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Name <span style="color:red">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="name" class="form-control" id="name" placeholder="" required>
                        </div>
                    </div> 
                    
                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Invoice No </label>

                        <div class="col-sm-7">
                            <input type="text" name="invoice_no" class="form-control" id="invoice_no" placeholder="">
                        </div>
                    </div>  

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Date <span style="color:red">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="date" class="form-control datepicker" id="date" value="<?php echo date("m/d/Y");?>"required>
                        </div>
                    </div>  

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Amount(Rs.) <span style="color:red">*</span></label>

                        <div class="col-sm-7">
                            <input type="text" name="amount" class="form-control" id="amount" placeholder="" required>
                        </div>
                    </div>  

                    <div class="form-group">
                        <label for="field-1" class="col-sm-3 control-label">Attach Document </label>  
                        
                        <div class="col-sm-7">
                            <input type="file" name="document" class="form-control" accept=".jpg, .jpeg, .png, .doc, .docx, .pdf, .txt">
                        </div>                        
                    </div> 

                    <div class="form-group">
                        <label for="field-ta" class="col-sm-3 control-label">Description</label>

                        <div class="col-sm-7">
                        <textarea name="description" class="form-control" id="description"
                                rows="5"></textarea>                            
                        </div>
                    </div>                    
                    
                    <div class="col-sm-3 control-label col-sm-offset-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
