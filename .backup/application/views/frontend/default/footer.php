<!-- FOOTER -->
<footer id="footer" class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-md-6 col-lg-4">
                    <div class="col">
                        <img src="<?php echo base_url('uploads/logo2.png');?>" width="200"height="110"
                             alt="">
                        &nbsp; <p class="mt-3">Orange Wheels dedicated to delivering exceptional care and improving the quality of life for individuals with hearing loss.Our mission is to empower our patients to reconnect with the world of sound and enjoy the benefits of optimal hearing.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="row">
                    <div class="col">
                        <h4 class="heading heading-xs strong-600 text-uppercase mb-1">
                            <?php echo get_phrase('main_menu');?>
                        </h4>

                        <ul class="footer-links">
                            <li>
                                <a href="<?php echo site_url('home');?>">
                                    <?php echo get_phrase('home');?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('home/doctors');?>">
                                    <?php echo get_phrase('doctors');?>
                                </a>
                            </li>
                         
                            <li>
                                <a href="<?php echo site_url('login');?>"
                                    target="_blank">
                                    <?php echo get_phrase('login');?>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="<?php echo site_url('home/appointment');?>">
                                    <?php echo get_phrase('make_an_appointment');?>
                                </a>
                            </li> -->
                        </ul>
                        </div>
                        <div class="col">
                        <h4 class="heading heading-xs strong-600 text-uppercase mb-1">
                            <?php echo get_phrase('help_and_support');?>
                        </h4>

                        <ul class="footer-links">
                            <li>
                                <a href="<?php echo site_url('home/contact_us');?>">
                                    <?php echo get_phrase('contact_us');?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('home/about_us');?>">
                                    <?php echo get_phrase('about_us');?>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="<?php echo site_url('home/blog');?>">
                                    <?php echo get_phrase('blog');?>
                                </a>
                            </li> -->
                        </ul>
                    </div>

                  
</div><br>
<p>  <i class="fa fa-phone" ></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $this->db->get_where('settings', array('type' => 'phone'))->row()->description; ?></p>
<p>  <i class="fa fa-envelope" ></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $this->db->get_where('settings', array('type' => 'system_email'))->row()->description; ?></p><p>  <i class="fa fa-map-marker" ></i>&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $this->db->get_where('settings', array('type' => 'address'))->row()->description; ?></p>
                </div>
                <div class="col-md-6 col-lg-4">
    <div class="col text-center">
    <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d59874.797266261885!2d85.78699347144773!3d20.293029393065876!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sArchid%20Central%2C%20District%20Center%2C%203rd%20Floor%2C%20%20Plot%20No-315%2C%20Flat%20No-302%2C%20Chandrasekharpur%2C%20%20Bhubaneswar%20-%20751016!5e0!3m2!1sen!2sin!4v1688035682850!5m2!1sen!2sin" width="320" height="270" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>
            </div>
        </div>
    </div>
 
    <div class="footer-bottom">
        <div class="container">
            <div class="row row-cols-xs-spaced flex flex-items-xs-middle">
                <div class="col col-sm-7 col-xs-12">
                    <div class="copyright text-xs-center text-sm-left">
                        <?php echo $this->frontend_model->get_frontend_settings('copyright_text');?>
                    </div>
                </div>

                <?php $social = json_decode($this->frontend_model->get_frontend_settings('social_links'));?>
                <div class="col col-sm-5 col-xs-12">
                    <div class="text-xs-center text-sm-right">
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
                            <?php if ($social[0]->youtube != '') { ?>
                                <li>
                                    <a href="<?php echo $social[0]->youtube;?>"
                                       target="_blank">
                                        <i class="ion ion-social-youtube"></i>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>