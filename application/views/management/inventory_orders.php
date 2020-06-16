<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/inventory_orders_style.css"/>
<main>
    <p class="title"> הזמן מוצרים למלאי</p>
    <br>
    <h4 class="subtitle">בעמוד זה תוכל להזמין מלאי לפי בחירתך.<br> <b>אנא וודא כי הזמנת המלאי מעודכנת לפני ביצועה.</b>
    </h4><br>
    <?php
    $attributes = array('name' => 'login_data');
    echo form_open_multipart('Management_controller/update_inventory', $attributes);
    ?>

    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <table>
                        <thead>
                            <tr class="table100-head">
                                <th class="column1">מק"ט</th>
                                <th class="column2">שם מוצר</th>
                                <th class="column3">מחיר ליחידה</th>
                                <th class="column4">כמות מוצר במלאי</th>
                                <th class="column5">כמות בהזמנה</th>
                                <th class="column6"><input id="search_input" type="text" placeholder="חפש בטבלה..."></th>
                            </tr>
                        </thead>
                        <?php foreach ($product_details as $product): ?>
                            <tbody id="myTable">
                                <tr class="proudct">
                                    <td class="column1 col1med"><?php echo $product['product_code']; ?></td>
                                    <td class="column2"><?php echo $product['model']; ?></td> 
                                    <td class="column3"><?php echo $product['price_per_unit']; ?></td>
                                    <td class="column4"><?php echo $product['quantity']; ?></td>
                                    <td class="column5"><input type="number" class="quantity_of_product_to_order" name="quantity_of_product_to_order[<?php $product['product_code']; ?>]" min="0" max="1000" value="0"></td>

                                <?php endforeach; ?>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="update_order_button" onclick="update_order()">
                        <span class="glyphicon glyphicon-refresh"></span>  הצג הזמנה לפני שליחה
                    </button>

                    <button type="button" class="restart_order_products_button" onclick="restart_order()">
                        <span class="glyphicon glyphicon-trash"></span>  נקה הזמנה
                    </button>

                    <button type="submit" class="send_order_button" onclick="">
                        <span class="glyphicon glyphicon-check"></span> בצע הזמנה
                    </button>
                    
                 

                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function () {
        $("#search_input").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    function update_order() {
        var x, i = 0;

<?php foreach ($product_details as $product): ?>
            x = document.getElementsByClassName("quantity_of_product_to_order")[i].value;
            if (x == "") {
                document.getElementsByClassName("proudct")[i].style.display = "none";
            }
            else if (x === "0") {
                document.getElementsByClassName("proudct")[i].style.display = "none";
            }

            i++;
<?php endforeach; ?>
    }
    function restart_order() {
        window.location.reload();
    }


</script>

