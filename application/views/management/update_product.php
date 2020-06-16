<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/update_product_style.css"/>
<?php
if (isset($_SESSION['user'])) {
    
} else {

    redirect('Homepage_controller/access_denied');
}
?>
<main>
    <?php
//    $description = $product[0]['description'];
//    echo($description);
    ?>

    <div class="center">

        <p id="error"></p>
        <?php
        $attributes = array('name' => 'login_data');
        echo form_open_multipart('Management_controller/update_products_notes', $attributes);
        ?>

        <p class="title">עדכן מוצר</p>

        <div><label>קוד מוצר: </label><input id="product_code" class="formInput" type="text" name="product_code" value="<?php echo $product[0]['product_code'] ?>" readonly disabled></div>

        <div><label>דגם: </label><input id="model"  class="formInput" type="text" name="model"  maxlength="25" value="<?php echo $product[0]['model'] ?>"></div>
        <div><label>חברה:</label><input id="company" class="formInput" type="text"  name="company" value="<?php echo $product[0]['company'] ?>"></div>

        <div><label>שם הספק:</label><input id="supplier"  class="formInput" type="text"  name="supplier" value="<?php echo $product[0]['supplier'] ?>"></div>

        <label for="description">תיאור המוצר:</label>        
        <textarea id="description"  name="description" rows="4" cols="50">
<?php echo $product[0]['description'] ?>
        </textarea>

        <div><label>מחיר ליחידה:</label><input id="price_per_unit" class="formInput" type="text"  name="price_per_unit" value="<?php echo $product[0]['price_per_unit'] ?>"></div>
        <div><label>מחיר לצרכן:</label><input id="retail_price" class="formInput" type="text"  name="retail_price" value="<?php echo $product[0]['retail_price'] ?>"></div>  
        <div><input id="productregister" type="button" value="עדכן מוצר" name="submit"></div>        



    </div>
</main>


<script>

    $("#productregister").click(function () {

        var product_code = $("#product_code").val();
        var model = $("#model").val();
        var company = $("#company").val();
        var description = $("#description").val();
        var supplier = $("#supplier").val();
        var price_per_unit = $("#price_per_unit").val();
        var retail_price = $("#retail_price").val();

        var form_data = new FormData();
        form_data.append("product_code", product_code);
        form_data.append("model", model);
        form_data.append("company", company);
        form_data.append("description", description);
        form_data.append("supplier", supplier);
        form_data.append("price_per_unit", price_per_unit);
        form_data.append("retail_price", retail_price);


        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>" + "/Management_controller/update_products_notes",
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            error: function () {
                alert('Something is wrong');
            },
            success: function (data) {
                if (data === "1") {
                    alert("המוצר עודכן בהצלחה!");
                    window.location.href = "<?php echo site_url('Management_controller/products_table'); ?>";
                }
                else {
                    $("#error").html(data);
                    $('html,body').scrollTop(0);

                }

            }

        });


    });
</script>