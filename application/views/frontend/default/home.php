<style>
    :root{ --main-color : #118a0d;; }
.counter{
    color: var(--main-color);
    font-family: 'Alegreya Sans', sans-serif;
    text-align: center;
    padding: 20px 15px 15px;
    position: relative;
    z-index: 1;
}
.counter:before,
.counter:after{
    content: "";
    background: var(--main-color);
    border-radius: 14px;
    position: absolute;
    top: 80px;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;
}
.counter:after{ 
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 10px 10px rgba(0,0,0,0.3);
    top: 85px;
    left: 5px;
    right: 5px;
    bottom: 5px;
}
.counter .counter-icon{
    color: #fff;
    background-color: var(--main-color);
    font-size: 35px;
    text-align: center;
    line-height: 80px;
    width: 80px;
    height: 80px;
    margin: 0 auto 30px;
    border-radius: 10px;
    box-shadow: 0 0 0 5px #fff;
    transform: rotate(45deg);
}
.counter .counter-icon span{
    transform: rotate(-45deg);
    display: block;
}
.counter .counter-value{
    font-size: 38px;
    font-weight: 600;
    line-height: 30px;
    margin: 0 0 15px;
    display: block;
}
.counter h3{
    color: #555;
    font-size: 18px;
    font-weight: 500;
    text-transform: capitalize;
    margin: 0;
}
/* .counter.orange{ --main-color: #fa871c; } */
.counter.red{ --main-color: #DD4655; }
.counter.blue{ --main-color: #1cb1c2; }
@media screen and (max-width:990px){
    .counter{ margin-bottom: 40px; }
}   
</style>
<section class="swiper-js-container background-image-holder" data-holder-type="fullscreen" data-holder-offset=".navbar">
    <div class="swiper-container" data-swiper-effect="fade" data-swiper-autoplay="true" data-swiper-items="1" data-swiper-space-between="0">
        <div class="swiper-wrapper">
            <?php
                $slider = json_decode($sliders);
                for ($i=0; $i < count($slider); $i++) {
            ?>
            <!-- Slide -->
                <div class="swiper-slide" data-swiper-autoplay="5000">
                    <div class="slice holder-item holder-item-light has-bg-cover bg-size-cover" 
                    style="background-image: url(<?php echo base_url('uploads/frontend/slider_images/' . $slider[$i]->image);?>); background-position: bottom bottom;">
                        <span class="mask mask-dark--style-2"></span>
                        <div class="container d-flex align-items-center no-padding">
                            <div class="col">
                                <div class="row row-cols-xs-spaced align-items-center py-5 text-center text-md-left">
                                    <div class="col-md-7 col-lg-6">
                                        <h2 class="heading heading-1 animated" data-animation-in="bounceInDown" data-animation-delay="200">
                                            <?php echo $slider[$i]->title;?>
                                        </h2>

                                        <p class="mt-4 animated" 
                                            data-animation-in="fadeInDown" 
                                                data-animation-delay="1000">
                                            <?php echo $slider[$i]->description;?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            
            <!-- Add Arrows -->
            <div class="swiper-button swiper-button-next"></div>
            <div class="swiper-button swiper-button-prev"></div>

        </div>
    </div>
</section>

<section class="home-top-widgets">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="home-widget widget-1">
                    <i class="fa fa-phone"></i>
                    <h4><?php echo get_phrase('emergency_contact');?></h4>
                    <h3><?php echo $this->frontend_model->get_frontend_settings('emergency_contact');?></h3>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="home-widget widget-2"> <i class="fa fa-clock-o"></i>
                    <h4><?php echo get_phrase('opening_hours');?></h4>
                    <?php $open = json_decode($opening_hours);?>
                    <ul>
                        <li class="clearfix"><?php echo get_phrase('monday');?> - <?php echo get_phrase('friday');?> 
                            <span class="float-right"><?php echo $open[0]->monday_friday;?></span></li>
                        <li class="clearfix"><?php echo get_phrase('saturday');?> 
                            <span class="float-right"><?php echo $open[0]->saturday;?></span></li>
                        <li class="clearfix"><?php echo get_phrase('sunday');?> 
                            <span class="float-right"><?php echo $open[0]->sunday;?></span></li>
                    </ul>
                   
                </div>
            </div>
            <div class="col-lg-4">
                <div class="home-widget widget-3">
                <i class="fa fa-handshake-o"></i>
                    <h4><?php echo get_phrase('get_in_touch');?></h4>
                    <a href="<?php echo site_url('home/contact_us');?>" 
                        class="btn">
                        <?php echo get_phrase('contact_us');?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="slice sct-color-2 pb-0">
<?php $welcome = json_decode($welcome_content);?>
    <div class="container">
        <div class="row align-items-md-center">
            
            <div class="col col-md-6 col-sm-12 col-12">
                <img src="<?php echo base_url('uploads/frontend/' . $welcome[0]->image);?>" 
                    class="img-fluid img-center">
            </div>
            
            <div class="col col-md-6 col-sm-12 col-12">
                <div class="px-3 py-3 text-center text-lg-left">
                    <h3 class="heading heading-3 strong-500">
                        <?php echo $welcome[0]->title;?>
                    </h3>
                    <p class="mt-4">
                        <?php echo $welcome[0]->description;?>
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<?php $service_section_data = json_decode($service_section);?>
<section class="slice slice--arrow bg-base-1">
    <div class="sct-inner container">
        <div class="section-title section-title-inverse section-title--style-1 text-center">
            <h3 class="section-title-inner">
                <span><?php echo $service_section_data[0]->title;?></span>
            </h3>
            <span class="section-title-delimiter clearfix d-none"></span>
        </div>

        <div class="fluid-paragraph fluid-paragraph-sm text-center">
        <?php echo $service_section_data[0]->description;?>
        </div>
    </div>
</section>

<section class="slice-xl sct-color-1 b-xs-bottom">
    <div class="container">
        <div class="row-wrapper">
            <div class="row">
                <?php foreach ($services as $row) { ?>
                <div class="col-lg-6 col-md-12 col-sm-12 col-12"
                    style="margin-top: 10px;">
                    <div class="icon-block icon-block--style-1-v2 block-icon-right block-icon-sm">
                        <div class="block-icon">
                            <img src="<?php echo base_url('uploads/frontend/service_images/' . $row['image']);?>"
                                width="140" height="100">
                        </div>
                        <div class="block-content">
                            <h3 class="heading heading-5 strong-500">
                                <?php echo $row['title'];?>
                            </h3>
                            <p>
                                <?php echo $row['description'];?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>


<section class="slice sct-color-1 relative b-xs-bottom department-section">
    <div class="container">
        <div class="section-title section-title--style-1 text-center mb-4">
            <h3 class="section-title-inner text-normal">
                <span><?php echo get_phrase('departments');?></span>
            </h3>
            <span class="section-title-delimiter clearfix d-none"></span>
        </div>

        <span class="clearfix"></span>

        <span class="space-xs-xl"></span>
        
        <div class="row-wrapper">
            <div class="row">
            <?php foreach ($departments as $row) { ?>
                <div class="col-lg-3">
                    <a href="<?php echo site_url('home/department/' . $row['department_id']);?>">
                        <div class="department-small-view">
                            <div class="block-icon text-center">
                                <img src="<?php echo base_url('uploads/frontend/department_images/' . $row['department_id'] . '.png');?>" alt=""
                                    width="60">
                                <h5><?php echo $row['name'];?></h5>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
            </div>
        </div>
        
    </div>
</section>


<section class="slice sct-color-1 relative">
    <div class="container">
        <div class="section-title section-title--style-1 text-center mb-4">
            <h3 class="section-title-inner text-normal">
                <span><?php echo get_phrase('our_awesome_doctors');?></span>
            </h3>
            <span class="section-title-delimiter clearfix d-none"></span>
        </div>

        <span class="clearfix"></span>

        <span class="space-xs-xl"></span>

        <div class="row-wrapper">
            <div class="row department-doctor-list">
                <?php foreach ($doctors as $row) { ?>
                <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="block block--style-4 list doctor-list">
                        <div class="block-image">
                            <div class="view view-fifth">
                                <img src="<?php echo $this->crud_model->get_image_url('doctor', $row['doctor_id']);?>">
                                <div class="mask">
                                    <div class="view-buttons">
                                        <span class="view-buttons-inner text-center appointment-btn">
                                            <a href="" class="btn btn-styled btn-base-1 btn-outline btn-icon-left btn-st-trigger" 
                                                data-effect="st-effect-1"
                                                    id="<?php echo site_url('home/get_doctor_details/' . $row['doctor_id']);?>">
                                                <?php echo get_phrase('view_details');?>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content w-100">
                            <div class="block-body py-2 px-0">
                                <small>
                                    <?php echo $this->db->get_where('department',array(
                                        'department_id' => $row['department_id']))->row()->name;?>
                                </small>
                                <h3 class="heading heading-5 strong-500">
                                    <a href="" class="btn-st-trigger" data-effect="st-effect-1"
                                    id="<?php echo site_url('home/get_doctor_details/' . $row['doctor_id']);?>">
                                        <?php echo $row['name'];?>
                                    </a>
                                </h3>

                            </div>

                            <?php $social = json_decode($row['social_links']);?>
                            <div class="block-footer block-footer-fixed-bottom b-xs-top">
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="social-media social-media--style-1-v4">
                                            <?php if ($social[0]->facebook != '') { ?>
                                                <li>
                                                    <a href="<?php echo $social[0]->facebook;?>"
                                                     target="_blank">
                                                        <i class="ion ion-social-facebook"></i>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($social[0]->twitter != '') { ?>
                                                <li>
                                                    <a href="<?php echo $social[0]->twitter;?>"
                                                       target="_blank">
                                                        <i class="ion ion-social-twitter"></i>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($social[0]->google_plus != '') { ?>
                                                <li>
                                                    <a href="<?php echo $social[0]->google_plus;?>"
                                                       target="_blank">
                                                        <i class="ion ion-social-googleplus"></i>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php if ($social[0]->linkedin != '') { ?>
                                                <li>
                                                    <a href="<?php echo $social[0]->linkedin;?>"
                                                       target="_blank">
                                                        <i class="ion ion-social-linkedin"></i>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>


<section class="slice sct-color-2 b-xs-top b-xs-bottom">
<div class="container">
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="counter">
                <div class="counter-icon">
                    <span><i class="fa fa-user-md"></i></span>
                </div>
            
                <span class="counter-value">50 +</span>
                                          
                <h3>Audiologist</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="counter orange">
                <div class="counter-icon">
                    <span><i class="fa fa-user"></i></span>
                </div>
                <span class="counter-value">1000 +</span> 
                <h3>Happy clients</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="counter">
                <div class="counter-icon">
                    <span><i class="fa fa-archive"></i></span>
                </div>
                <span class="counter-value">100 +</span> 
                <h3>Products</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="counter orange">
                <div class="counter-icon">
                    <span><i class="fa fa-smile-o"></i></span>
                </div>
                <span class="counter-value">100 %</span>
                <h3>Satisfaction</h3>
            </div>
        </div>
    </div>
</div>
                                            </section>

<section class="slice sct-color-2 b-xs-top b-xs-bottom">
    <div class="container">
        <div class="text-center">
            <div class="section-title section-title--style-1 text-center mb-4">
                <h3 class="section-title-inner text-normal">
                    <span><?php echo get_phrase('get_in_touch_with_us');?></span>
                </h3>
                <span class="section-title-delimiter clearfix d-none"></span>
            </div>

            <span class="clearfix"></span>

            <div class="mt-5">
                <a href="<?php echo site_url('home/contact_us');?>" 
                    class="btn btn-styled btn-lg btn-base-1">
                    <?php echo get_phrase('contact_us');?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script> -->
 <script>
$(document).ready(function(){
    $('.counter-value').each(function(){
        var str = $(this).text();
        var strings = str.split(" ");
        var [string1, string2] = strings;
        $(this).prop('Counter',0).animate({
            Counter: string1
        },{
            duration: 3500,
            easing: 'swing',
            step: function (now){
                $(this).text(Math.ceil(now) + string2);
            }
        });
     });
});
</script>