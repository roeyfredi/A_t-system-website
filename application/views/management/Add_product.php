<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/add_product_style.css"/>
<main>
    <div class="center">

        <p id="error"></p>
        <?php
        $attributes = array('name' => 'login_data');
        echo form_open_multipart('Management_controller/add_products_notes', $attributes);
        ?>

        <p class="title">הוסף מוצר</p>
        <div><label>קוד מוצר: </label><input id="product_code" class="formInput" type="text" name="product_code"></div>
        <div><label>סוג מוצר: </label><input id="product_type" class="formInput" type="text"  name="product_type"></div>
        <div><label>דגם: </label><input id="model"  class="formInput" type="text" name="model"  maxlength="25"></div>
        <div><label>חברה:</label><input id="company" class="formInput" type="text"  name="company"></div>
        <label for="description">תיאור המוצר:</label>        
        <textarea id="description"  name="description" rows="4" cols="50">
        </textarea>
        <div><lable>הוסף תמונת מוצר</lable><input type="file" name="image_file" id="image_file" accept="images/*" enctype="multipart/form-data" required></div>
        <div><label>שם הספק:</label><input id="supplier"  class="formInput" type="text"  name="supplier"></div>
        <div><label>מחיר ליחידה:</label><input id="price_per_unit" class="formInput" type="text"  name="price_per_unit"></div>
        <div><label>מחיר לצרכן:</label><input id="retail_price" class="formInput" type="text"  name="retail_price"></div>
        <div><input id="productregister" type="button" value="הוסף מוצר למלאי" name="submit"></div>        



    </div>
</main>


<script>

    $("#productregister").click(function () {

        var file_data = $('#image_file')[0].files[0];

        var product_code = $("#product_code").val();
        var product_type = $("#product_type").val();
        var model = $("#model").val();
        var company = $("#company").val();
        var description = $("#description").val();
        var supplier = $("#supplier").val();
        var price_per_unit = $("#price_per_unit").val();
        var retail_price = $("#retail_price").val();

        var form_data = new FormData();
        form_data.append("product_code", product_code);
        form_data.append("product_type", product_type);
        form_data.append("model", model);
        form_data.append("company", company);
        form_data.append("description", description);
        form_data.append("supplier", supplier);
        form_data.append("price_per_unit", price_per_unit);
        form_data.append("retail_price", retail_price);
        form_data.append('image_file', file_data);


        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>" + "/Management_controller/add_products_notes",
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            error: function () {
                alert('Something is wrong');
            },
            success: function (data) {
                if (data === "1") {
                    alert("הוספת מוצר למוצרי החנות התווספה בהצלחה!");
                    window.location.href = "<?php echo site_url('Management_controller/products_management'); ?>";
                }
                else {
                    $("#error").html(data);
                    $('html,body').scrollTop(0);

                }

            }

        });


    });
</script>