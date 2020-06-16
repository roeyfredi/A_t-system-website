<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/customer_orders_style.css"/>
<?php
if (isset($_SESSION['user'])) {
    
} else {

    redirect('Homepage_controller/access_denied');
}
?>

<main>
    <?php $i = 0; ?>
    
     <p class="title">עסקאות לקוח</p>
    <h4 class="subtitle">בעמוד זה תוכל לצפות בעסקאות של הלקוח.</h4><br>
    
    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">     
                    <table>
                        <thead>
                            <tr class="table100-head">
                                <th class="column1">מספר הזמנה</th>
                                <th class="column2">מספר לקוח</th>
                                <th class="column3">תאריך הזמנה</th>          
                                <th class="column4">אופן אספקה</th>
                                <th class="column5">מחיר הזמנה</th>
                                <th class="column6"></th>
                            </tr>
                        </thead>
                        <?php foreach ($customer_orders as $order): ?>

                            <tbody id="myTable">

                                <tr class="test">

                                    <td class = "column1 col1med"><?php echo $order['order_number_fk']; ?></td>
                                    <td class="column2"><?php echo $order['user_number_fk']; ?></td> 
                                    <td class="column3"><?php echo date('תאריך: d-m-y', strtotime($order['order_date'])); ?><?php echo '<br>' . date('שעה:H:i', strtotime($order['order_date'])); ?></td> 
                                    <td class="column4">

                                        <?php if ($order['supply'] == "delivery") { ?>
                                            משלוח
                                        <?php } if ($order['supply'] == "installation") { ?>
                                            התקנה בחנות
                                        <?php } if ($order['supply'] == "self_pickup") { ?>
                                            איסוף עצמי
                                        <?php } ?>
                                    </td>
                                    <td class="column5"><?php echo $order['total_price'] . ' &#8362'; ?></td>
                                    <td class="column6">


                                        <button type="button" id="view_in_order_details" class="product_order_details">
                                            צפה בפרטי הזמנה
                                        </button>

                                <tr class="order_details">

                                    <td colspan="6" class="hiddenRow">

                                        <div class="products_in_order_mobile"> 
                                            <?php
                                            $i = 1;
                                            foreach ($products_in_order as $product_in_order):
                                                if ($order['order_number_fk'] == $product_in_order['order_number_fk']) {
                                                    ?> 
                                                    <br>
                                                    <?php echo '<img class="product_image" src="data:image/jpeg;base64,' . base64_encode($product_in_order['image']) . '"/>'; ?>
                                                    <span id="number_of_product"><?php echo $i . ")" ?></span>
                                                    <p><?php echo '<b>מק"ט:</b>' . $product_in_order['product_code_fk']; ?></p>
                                                    <p><?php echo '<b>שם מוצר:</b>' . $product_in_order['model']; ?></p>
                                                    <p><?php echo '<b>כמות:</b>' . $product_in_order['quantity']; ?></p>
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



                            <?php endforeach; ?>




                        </tbody>

                    </table>
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

        $('.order_details').hide();
        $(".product_order_details").click(function () {

            $(this).parents("tr").next().slideToggle();
        });

    });


</script>