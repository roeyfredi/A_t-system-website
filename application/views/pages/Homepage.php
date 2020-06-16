<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/homepage_style.css"/>
<main>


    <?php // print_r($user); ?>

    <h2 class="heading">ברוכים הבאים לאתר A.t system אביזרים ומערכות לרכב</h2> 
    <h3 class="subtitle"> באתר זה תוכלו למצוא את האביזרים האיכותיים ביותר במחיר הזול ביותר! </h3> 
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

    <h2 class="heading">העבודות שלנו</h2><br>

    <div class="w3-content w3-display-container gallery_slide">

        <div class="w3-display-container mySlides">
            <img class="slide_gallery_image" src="<?php echo base_url(); ?>assets/images/slide_1.jpg">
            <div class="w3-display-bottomright w3-large w3-container w3-padding-16 w3-black">
                התקנת מערכת מולטימדיה Android 11
            </div>
        </div>

        <div class="w3-display-container mySlides">
            <img class="slide_gallery_image" src="<?php echo base_url(); ?>assets/images/slide_2.jpg">
            <div class="w3-display-bottomright w3-large w3-container w3-padding-16 w3-black">
                התקנת מערכת מולטימדיה  Android 9
            </div>
        </div>

        <div class="w3-display-container mySlides">
            <img class="slide_gallery_image" src="<?php echo base_url(); ?>assets/images/slide_3.jpg">
            <div class="w3-display-bottomright w3-large w3-container w3-padding-16 w3-black">
                התקנת מסכים אחוריים לילדים
            </div>
        </div>

        <div class="w3-display-container mySlides">
            <img class="slide_gallery_image" src="<?php echo base_url(); ?>assets/images/slide_4.jpg">
            <div class="w3-display-bottomright w3-large w3-container w3-padding-16 w3-black">
                התקנת מערכת מולטימדיה Sony G9
            </div>
        </div>

        <div class="w3-display-container mySlides">
            <img class="slide_gallery_image" src="<?php echo base_url(); ?>assets/images/slide_5.jpg">
            <div class="w3-display-bottomright w3-large w3-container w3-padding-16 w3-black">
                התקנת  ריפודי דמוי עור
            </div>
        </div>

        <div class="w3-display-container mySlides">
            <img class="slide_gallery_image" src="<?php echo base_url(); ?>assets/images/slide_7.jpg">
            <div class="w3-display-bottomright w3-large w3-container w3-padding-16 w3-black">
                התקנת מצלמת רוורס
            </div>
        </div>

        <button class="w3-button w3-display-right w3-black" onclick="plusDivs(1)">&#10094;</button>
        <button class="w3-button w3-display-left w3-black" onclick="plusDivs(-1)">&#10095;</button>

    </div>



</main>

<script>
    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
        showDivs(slideIndex += n);
    }

    function showDivs(n) {
        var i;
        var x = document.getElementsByClassName("mySlides");
        if (n > x.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = x.length
        }
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        x[slideIndex - 1].style.display = "block";
    }

    // Instantiate the Bootstrap carousel
    $(".multi-item-carousel").carousel({
        interval: false
    });


</script>







