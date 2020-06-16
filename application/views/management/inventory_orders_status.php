<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/inventory_orders_status_style.css"/>
<?php
if (isset($_SESSION['user'])) {
    
} else {

    redirect('Homepage_controller/access_denied');
}
?>
<main>
    <?php echo form_open('/Management_controller/update_quantity_in_stock_from_inventory_orders_status_page'); ?>


    <p class="title"> סטטוס הזמנות מלאי</p>
    <h4 class="subtitle">בעמוד זה תוכל לצפות בהזמנות מלאי ולעדכן את המלאי בעת הגעתן לחנות.
    </h4><br>
    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <table>
                        <thead>
                            <tr class="table100-head">
                                <th class="column1">מספר הזמנה</th>
                                <th class="column2">תאריך הזמנה</th>
                                <th class="column3">מחיר הזמנה</th>          
                                <th class="column4">סטטוס הגעת הזמנה</th>
                                <th class="column5">אישור הזמנה</th>
                                <th class="column6">פרטי הזמנה</th>
                            </tr>
                        </thead>
                        <?php foreach ($inventory_orders as $order): ?>
                            <tbody id="myTable">  
                                <tr class="inventort_order_status_tr">
                                    <td class = "column1 col1med"><?php echo $order['order_number']; ?></td>

                                    <td class="column2"><?php echo date('תאריך: d-m-y', strtotime($order['order_date'])); ?><?php echo '<br>' . date('שעה:H:i', strtotime($order['order_date'])); ?></td> 
                                    <td class="column3"><?php echo number_format($order['total_price']) . ' &#8362'; ?></td>  
                                    <td class="column4">
                                        <?php
                                        if ($order['order_status'] != NULL) {
                                            echo "<p class='glyphicon glyphicon-ok confirm'></p>";
                                            echo "<p class='confirm_for_mobile_device'>סופק</p>";
                                        } else if ($order['order_status'] == NULL) {
                                            echo "<p class='glyphicon glyphicon-remove not_confirm'></p>";
                                            echo "<p class='not_confirm_for_mobile_device'>טרם סופק</p>";
                                        }
                                        ?>
                                    </td>
                                    <td class="column5">
                                        <input type="text"  name="order_number" class="order_number" value=<?php echo $order['order_number']; ?> />

                                        <button type="submit" class="confirm_button">אשר הגעת הזמנה</button>
                                    </td>   

                                    <td class="column6"><button type="button" id="button_details" class="order_details_button">צפה בפרטי הזמנה</button></td>
                                </tr>
                                <tr class="order_details">

                                    <td colspan="6" class="hiddenRow">

                                        <div> 
                                            <?php
                                            $i = 1;
                                            foreach ($products_details_in_inventory_order as $product_in_order):
                                                if ($order['order_number'] == $product_in_order['order_number_fk']) {
                                                    ?> 
                                                    <br>
                                                    <?php echo '<img class="product_image" src="data:image/jpeg;base64,' . base64_encode($product_in_order['image']) . '"/>'; ?>
                                                    <span id="number_of_product"><?php echo $i . ")" ?></span>
                                                    <p><?php echo '<b>מק"ט:</b>' . $product_in_order['product_code_fk']; ?></p>
                                                    <p><?php echo '<b>שם מוצר:</b>' . $product_in_order['model']; ?></p>
                                                    <p><?php echo '<b>כמות:</b>' . $product_in_order['quantity_in_order']; ?></p>
                                                    <p><?php echo '<b>מחיר ליחידה:</b>' . number_format($product_in_order['price_per_unit']) . ' &#8362'; ?></p>

                                                    <hr>


                                                    <?php
                                                    $i++;
                                                }
                                                ?> 
                                            <?php endforeach; ?>

                                        </div>
                                    </td>

                                </tr>
                                </span>

                            <?php endforeach; ?>


                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <?php
    //print_r($inventory_orders)
    ?>
    <?php echo form_close() ?>
</main>

<script>
    $(document).ready(function () {

        $('.order_details').hide();
        $(".order_details_button").click(function () {

            $(this).parents("tr").next().slideToggle();

        });

        $('.confirm_button').click(function () {

            //var num1 = $(this).siblings(".order_number").val();
            //alert(num1);
            //alert(order_number);

            var order_number = $(this).prev("input").val();
            $('.order_number').val(order_number);

        });
    });

    var i = 0;
<?php
foreach ($inventory_orders as $order):
    if ($order['order_status'] != NULL) {
        ?>
            var button = document.getElementsByClassName("confirm_button")[i];
            i--;

            var confirm_p = document.createElement("p");
            var node = document.createTextNode("ההזמנה עודכנה בהצלחה במלאי");
            confirm_p.appendChild(node);
            button.replaceWith(confirm_p);
            confirm_p.className = "order_confirm_p";

    <?php } ?>

        i++;

    <?php
endforeach;
?>
</script>