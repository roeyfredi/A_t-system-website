<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/product_purchase_style.css"/>
<main>
    <?php echo form_open('Shopping_cart_controller/add_to_shopping_cart'); ?>
    <div class='container'>
        <?php $befor_discount = (int) ($product_details[0]['retail_price'] * 0.20 + $product_details[0]['retail_price']); ?>

        <input type="text" style="visibility:hidden;" name="model" id="model" value="<?php echo $product_details[0]['model'] ?>" />
        <input type="text" style="visibility:hidden;" name="product_price" id="product_price" value="<?php echo $product_details[0]['retail_price'] . ' &#8362'; ?>" />
        <input type="text" style="visibility:hidden;" name="product_code" id="product_code" value="<?php echo $product_details[0]['product_code']; ?>" />

        <div class='col-md-6'>
            <?php echo '<img class="image_product" src="data:image/jpeg;base64,' . base64_encode($product_details[0]['image']) . '"/>'; ?>
        </div>
        <div class="col-md-6">
            <p class='product_title'>
                <?php echo $product_details[0]['model'] ?>
            </p> 
            <p class='product_price'>
                <?php echo $product_details[0]['retail_price'] . ' &#8362'; ?>

            </p>
            <p class='product_price_before_discount'>
                <?php echo $befor_discount . ' &#8362'; ?>
            </p>
            <p class='product_code'>
                <?php echo 'מק"ט:' . $product_details[0]['product_code']; ?>
            </p>

            <p class='product_description'>
                <?php echo $product_details[0]['description']; ?>
            </p>

            <p class="qty mt-5 margin_top">
                <span class="minus bg-dark" onclick='javascript: document.getElementById("qty").value--;'>-</span>
                <input type="number" name="qty" id="qty" value="1">
                <span class="plus bg-dark" onclick='javascript: document.getElementById("qty").value++;'>+</span>
            </p>

            <p class='margin_top'>
                <button type="submit" class="btn btn-info btn-lg button_cart" name="add_cart" onclick="return user_log_in()">
                    הוסף לסל <span class="glyphicon glyphicon-shopping-cart"></span>
                </button>
            </p> 
            <?php echo form_close(); ?>

            <p class='product_returns'>
                <b>מדיניות החזרת מוצרים שנרכשו באתר  </b><br>
                לאחר ביצוע עסקת הרכישה באתר, יישלח ללקוח לכתובת הדואר האלקטרוני שמסר בעת ביצוע העסקה, מסמך המפרט את פרטי העסקה כנדרש לפי חוק הגנת הצרכן (להלן: "מסמך פרטי העסקה").

                ביטול עסקה ניתן לבצע בהתאם לתנאים שיפורטו להלן, ובאמצעות יצירת קשר עם החברה באחת מן הדרכים הבאות: <br>

                1)בדואר אלקטרוני לכתובת : atcarsystem@gmail.com <br>
                2) במספר הטלפון של העסק: 03-544-6772  <br>
            </p>

        </div>
    </div>
</form>

</main>



<script>

    function user_log_in() {
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
        if (user == 0) {
            alert("על מנת להוסיף מוצר זה לסל, אנא בצע התחברות!");
            return false;
        }
    }

</script>

