<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/success_style.css"/>

<?php
//print_r($last_order[0]['order_number']);
?>
<main>
    <div class="container">

        <div class="center">

            <h2>לקוח יקר!</h2>
            <h3 class="h_cancel_massege">ההזמנה נקלטה בהצלחה במערכת</h3>
            <h4>מספר הזמנה: <?php echo ($last_order[0]['order_number']); ?> </h4>  
            <h4>הסכום שחויב : <?php echo (number_format($last_order[0]['Total'], 1)); ?> &#8362 </h4>
            <h4>סטטוס הזמנה : מאושר</h4>

            <img class="success_img" style="margin-top:3%;"src= "<?php echo base_url(); ?>assets/images/success.png"/>     

<!--<a href="<?php echo site_url(); ?>/Homepage_controller/Homepage">חזור לדף הבית</a>-->

        </div>

    </div><!-- /.container -->
</main>

