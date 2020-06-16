<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/quantity_in_stock_style.css"/>
<?php
if (isset($_SESSION['user'])) {
    
} else {
    
    redirect('Homepage_controller/access_denied');
}
?>
<main>
    <p class="title"> מלאי מוצרים</p>
    <h4 class="subtitle">בעמוד זה תוכל לנהל את מלאי המוצרים של החנות.
    שים לב כי השורות הצבועות באדום משמען כי המוצר עומד לאזול מן המלאי.
    </h4><br>
    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <table>
                        <thead>
                            <tr class="table100-head">
                                <th class="column1">מק"ט</th>
                                <th class="column2">שם מוצר</th>
                                <th class="column3">סוג מוצר</th>          
                                <th class="column4">חברה</th>
                                <th class="column5">ספק</th>
                                <th class="column6">מחיר ליחידה</th>
                                <th class="column7">מחיר קמעונאי</th>
                                <th class="column8">כמות במלאי</th>
                                <th class="column9"></th>
                                <th class="column10"><input id="search_input" type="text" placeholder="חפש בטבלה..."></th>
                            </tr>
                        </thead>
                        <?php foreach ($product_details as $product): ?>
                            <tbody id="myTable">
                                <?php if ($product['quantity'] < 11) { ?>
                                    <tr class="warning_message">
                                    <?php } else { ?>    
                                    <tr>
                                    <?php } ?>
                                    <td class = "column1 col1med"><?php echo $product['product_code']; ?></td>
                                    <td class="column2"><?php echo $product['model']; ?></td> 
                                    <td class="column3"><?php echo $product['product_type']; ?></td>  
                                    <td class="column4"><?php echo $product['company']; ?></td>
                                    <td class="column5"><?php echo $product['supplier']; ?></td>
                                    <td class="column6"><?php echo $product['price_per_unit']; ?></td>
                                    <td class="column7"><?php echo $product['retail_price']; ?></td>
                                    <td class="column8"><?php echo $product['quantity']; ?></td>
                                    <td class="column9"> 
                                        <a  class=column9 href="<?php echo site_url(); ?>/Management_controller/update_product?product_code=<?php echo $product['product_code'] ?>">
                                            <p><button>עדכון מוצר</button></p>
                                        </a>
                                    </td> 
                                    <td class="column10_td"> 
                                        <a  class="column10_td" href="<?php echo site_url(); ?>/Management_controller/remove_product?product_code=<?php echo $product['product_code'] ?>">
                                            <p><button class="column10_td">מחיקת מוצר </button></p>
                                        </a>
                                    </td> 

                                <?php endforeach; ?>


                            </tr>

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
    });


</script>