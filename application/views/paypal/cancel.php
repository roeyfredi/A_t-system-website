<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/cancel_style.css"/>

<div class="container">

    <div class="center">
        <h2>לקוח יקר!</h2>
        <h3 class="h_cancel_massege">ההזמנה לא בוצעה, אנא נסה שנית!</h3>
        
        <img class="cancel_img" src= "<?php echo base_url(); ?>assets/images/cancelled.jpg"/>     

        <button class="pay_submit" type="button" onclick="goBack()" >
            שלם באמצעות 
            <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png" alt="PayPal" />
        </button>
    </div>

</div><!-- /.container -->

<script>
function goBack() {
  window.history.back();
}
</script>