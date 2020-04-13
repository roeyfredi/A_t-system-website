<main>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/homepage_style.css"/>

    <?php print_r($user); ?>

    <h2 class="heading"><?php echo $title; ?></h2>  
    <div class="gallery-image">
        <div class="row">
            <a href="<?php echo site_url(); ?>/Products_controller/seat_coverings_page">
                <div class="img-box">
                    <img src= "<?php echo base_url(); ?>assets/images/chair.jpeg"/>      
                    <div class="transparent-box">
                        <div class="caption">
                            <p class="img_title">כיסויים לרכב</p>
                        </div>
                    </div> 
                </div>            
            </a>
            <a href="<?php echo site_url(); ?>/Products_controller/accessories_for_automobiles_page">
                <div class="img-box">
                    <img src= "<?php echo base_url(); ?>assets/images/camping.jpeg"/>      
                    <div class="transparent-box">
                        <div class="caption">
                            <p class="img_title">ציוד קמפינג </p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="<?php echo site_url(); ?>/Products_controller/batteries_and_electronics_page">
                <div class="img-box">
                    <img src= "<?php echo base_url(); ?>assets/images/mazber.jpeg"/>      
                    <div class="transparent-box">
                        <div class="caption">
                            <p class="img_title">מצברים ואלקטרוניקה לרכב</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="row">
            <a href="<?php echo site_url(); ?>/Products_controller/multi_media_systems_page">
                <div class="img-box">
                    <img src= "<?php echo base_url(); ?>assets/images/moltimedia.jpeg"/>      
                    <div class="transparent-box">
                        <div class="caption">
                            <p class="img_title">מערכות מולטימדיה לרכב</p>
                        </div>
                    </div> 
                </div>
            </a>
            <a href="<?php echo site_url(); ?>/Products_controller/pelephone_accessories_page">
                <div class="img-box">
                    <img src= "<?php echo base_url(); ?>assets/images/phone.jpeg"/>      
                    <div class="transparent-box">
                        <div class="caption">
                            <p class="img_title">אביזרים לפלאפון</p>
                        </div>
                    </div> 
                </div>
            </a>
            <a href="<?php echo site_url(); ?>/Products_controller/car_accessories_page">
                <div class="img-box">
                    <img src= "<?php echo base_url(); ?>assets/images/item.jpeg"/>      
                    <div class="transparent-box">
                        <div class="caption">
                            <p class="img_title">אביזרים לרכב</p>
                        </div>
                    </div> 
                </div>
            </a>
        </div>
    </div>

</main>







