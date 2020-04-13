<!doctype html>
<html lang="he" dir="rtl">
    <head>
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/header_style.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>

    </head>

    <body dir="rtl">
        <header>
            <div class="header">
                <img class="img_logo" src="<?php echo base_url(); ?>assets/images/logo.jpg"/>
                <img class="img_logo_2" src="<?php echo base_url(); ?>assets/images/near_to_logo.jpg"/>
            </div>
            <div class="clear">
            </div>
            <div class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="navbar-header toggle_div">
                                <button class="navbar-toggle" data-target="#mobile_menu" data-toggle="collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                            </div>


                            <ul class="nav navbar-nav navbar info">

                                <li><a class='color_white' href="#" id="my_profile"><span class="glyphicon glyphicon-user"></span>הפרופיל שלי</a></li>
                                <li><a href="#" id="my_cart_shopping"><span class="glyphicon glyphicon-shopping-cart"></span>הסל שלי</a></li>

                                <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" id="signin_signup"><span class="glyphicon glyphicon-log-in"></span> התחברות / הרשמה <span class="caret"></span></a>

                                    <ul class="dropdown-menu">
                                        <li><a id="sign_in" href="<?php echo site_url(); ?>/Login_controller/login"><b>התחברות</b></a></li>
                                        <li> <a id="registration"  href="<?php echo site_url(); ?>/Registration_controller/register"><b>הרשמה</b></a></li>   
                                    </ul>

                                </li>
                            </ul>



                            <div class="navbar-collapse collapse navbar-right" id="mobile_menu">
                                <ul class="nav navbar-nav menu_a column-reverse">  
                                    <li><a id="logout" href="<?php echo site_url(); ?>/Login_controller/logout"><b>התנתקות</b></a></li>

                                        <li><?php if(isset($_SESSION['user'][0]['management'])!=null){ echo '<a id="management" href="#" class="dropdown-toggle" data-toggle="dropdown">ניהול<span class="caret"></span></a>';}?>

                                        <ul class="dropdown-menu right text_to_the_right">
                                            <div class="text_to_the_right">
                                                <li><a class="li_color" href="#">ניהול לקוחות</a></li>
                                                <li><a class="li_color" href="<?php echo site_url(); ?>/Management_controller/products_management">ניהול מלאי</a></li>
                                            </div>
                                        </ul>
                                    </li>
                                    <li><a href="<?php echo site_url(); ?>/Contact_controller/contact">צור קשר</a></li>
                                    <li><a href="#">מי אנחנו</a></li>

                                    <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">מוצרים <span class="caret"></span></a>
                                        <ul class="dropdown-menu right text_to_the_right">
                                            <div class="text_to_the_right">
                                                <li><a class="li_color" href="<?php echo site_url(); ?>/Products_controller/multi_media_systems_page">מערכות מולטימדיה לרכב</a></li>
                                                <li><a class="li_color" href="<?php echo site_url(); ?>/Products_controller/seat_coverings_page">כיסויי מושבים</a></li>
                                                <li><a class="li_color" href="<?php echo site_url(); ?>/Products_controller/batteries_and_electronics_page">מצברים ואלקטרוניקה</a></li>
                                                <li><a class="li_color" href="<?php echo site_url(); ?>/Products_controller/car_accessories_page">אביזרים לרכב</a></li>
                                                <li><a class="li_color" href="<?php echo site_url(); ?>/Products_controller/pelephone_accessories_page">אביזרים לפלאפון</a></li>                                                
                                                <li><a class="li_color" href="<?php echo site_url(); ?>/Products_controller/accessories_for_automobiles_page">אביזרי קמפינג לרכב</a></li>
                                            </div>
                                        </ul>
                                    </li>

                                    <li><a href="<?php echo site_url(); ?>/Homepage_controller/homepage"><b>דף הבית</b></a></li>





                                </ul>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <script>
<?php
$userCheck = isset($_SESSION['user']);
if ($userCheck == null) {
    $val = 0;
} else {
    $val = 1;
}
?>
            var user = "<?= $val ?>";
            user = parseInt(user);

            if (user === 0) {
                document.getElementById('logout').style.display = 'none';
                document.getElementById('signin_signup').style.display = 'inline-block';
                document.getElementById('registration').style.display = 'inline-block';
                document.getElementById('my_profile').style.display = 'none';
                document.getElementById('my_cart_shopping').style.display = 'none';
            }
            else {
                document.getElementById('logout').style.display = 'inline-block';
                document.getElementById('signin_signup').style.display = 'none';
                document.getElementById('sign_in').style.display = 'none';
                document.getElementById('registration').style.display = 'none';
                document.getElementById('my_profile').style.display = 'inline-block';
                document.getElementById('my_cart_shopping').style.display = 'inline-block';
            }
        </script>


