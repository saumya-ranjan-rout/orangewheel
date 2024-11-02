<section class="slice--offset parallax-section parallax-section-xl b-xs-bottom custom-page-head"
    style="background-image: url('<?php echo base_url('assets/frontend/' . $theme . '/images/img-15.jpg');?>');">
    <div class="container">
        <div class="row py-3">
            <div class="col-lg-12">
                <h1 class="heading text-uppercase c-white">
                    <?php echo $page_title; ?>                   
                </h1>

                <span class="clearfix"></span>

                <div class="">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo site_url('home');?>">
                            <?php echo get_phrase('home');?>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                        <?php echo $page_title;?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>


    <?php foreach ($item_category as $row) { ?>        
   
    <section class="slice sct-color-1">
    <div class="container">
        <div class="text-center">
            <h2 class="heading heading-2 strong-400" style="color: #00A54F;text-decoration: underline;">
               <?php echo $row['item_category']?>
            </h2>            
        </div>
    </div>
    <br><br>
    <div class="container">  
        <div class="row masonry">                
            <?php $item_subcategory = $this->db->get_where('item_subcategory', array('item_category' => $row['id']))->result_array();?>
            <?php foreach ($item_subcategory as $row2) { ?>                           
            <div class="masonry-item col-sm-6 col-md-6">
            <h6 style="font-weight: bold;color:#ED7B0B"><?php echo $row2['item_subcategory']?></h6>
                <div class="block block--style-3" style="height: 250px;overflow-y: auto;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">
            <?php $item = $this->db->get_where('item', array('item_category_id' => $row['id'],'item_sub_category_id' => $row2['item_id']))->result_array();?>
                    <table class="table table-striped ">
                    <thead style="position: sticky; top: 0; background-color: #00A54F; color: white;">
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">Channel</th>
                                <th scope="col">Fitting Range</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($item as $row3) 
                        {                       
                        ?>  
                        <tr>
                            <th scope="row"><?php echo $row3['model']?></th>
                            <td><?php echo $row3['type']?></td>
                            <td><?php echo $row3['channel']?></td>
                            <td><?php echo $row3['fitting_range']?></td>
                        </tr>
                        <?php }                         
                        ?>
                        </tbody>
                    </table>                    
                </div>
            </div>
            <?php } ?>
        
            
        </div>
        
    </div>
  
</section>
<?php } ?>