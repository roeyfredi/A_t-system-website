<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/shopping_cart_style.css"/>
<main style="direction: rtl;">
    <div style="padding-bottom:10px">
        <h1 align="center">הסל שלך</h1>
        <?php if ($this->cart->total_items() == 0) {
            ?>
            <p class="empty_cart">טרם הוספת מוצרים לסל, הסל ריק!</p>
        <?php } ?>
    </div>

    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <table>
                        <?php if ($cart = $this->cart->contents()): ?>
                            <thead>
                                <tr class="table100-head">
                                    <th class="column1">#</th>
                                    <th class="column2">שם מוצר</th>
                                    <th class="column3">מק"ט</th>
                                    <th class="column4">מחיר ליחידה</th>
                                    <th class="column5">כמות</th>
                                    <th class="column6">מחיר כולל</th>
                                    <th class="column6"></th>
                                </tr>
                            </thead>
                            <?php
                            echo form_open('Shopping_cart_controller/update_cart');
                            $grand_total = 0;
                            $i = 1;

                            foreach ($cart as $item):
                                echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
                                echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
                                echo form_hidden('cart[' . $item['id'] . '][name]', $item['name']);
                                echo form_hidden('cart[' . $item['id'] . '][price]', $item['price']);
                                echo form_hidden('cart[' . $item['id'] . '][qty]', $item['qty']);
                                ?>
                                <tbody>
                                    <tr>
                                        <td class="column1 col1med"><p class="test"> <?php echo $i++; ?></p></td>
                                        <td class="column2"><?php echo $item['name']; ?></td>
                                        <td class="column3"><?php echo $item['id']; ?></td>
                                        <td class="column4"><?php echo number_format($item['price'], 2); ?> &#8362</td>
                                        <td class="column5">
                                            <?php echo form_input('cart[' . $item['id'] . '][qty]', $item['qty'], 'maxlength="3" size="3" style="text-align: center;display:block;margin-right: auto;margin-left: auto; "'); ?>
                                        </td>
                                        <?php $grand_total = $grand_total + $item['subtotal']; ?>
                                        <td class="column6"> <?php echo number_format($item['subtotal'], 2) ?> &#8362</td>
                                        <td class="column7"><?php echo anchor('Shopping_cart_controller/remove/' . $item['rowid'], 'מחיקה', 'class="delete_button"'); ?></td>                                        
                                    <?php endforeach; ?>


                                <?php endif; ?>
                            </tr>

                        </tbody>

                    </table>
                    <?php if ($this->cart->total_items() != 0) { ?>
                        <div class="center">
                            <p class="total_payment"><b>סה"כ לתשלום: <?php echo number_format($grand_total, 2); ?> &#8362</b></p>
                            <input type="button" class="button_paymant" value="לתשלום" onclick="window.location = 'billing'">
                            
                            <button type="button" class="clean_cart_button" onclick="clear_cart()">
                                <span class="glyphicon glyphicon-trash"></span> נקה עגלה
                            </button>
<!--                            <input type="submit" class="update_cart" value="עדכן עגלת קניות">-->
                            
                            <button type="submit" class="update_cart_button">
                                <span class="glyphicon glyphicon-refresh"></span> עדכן עגלת קניות
                            </button>
                        </div>
                    <?php } ?>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

</main>

<script>
    function clear_cart() {
        var result = confirm('הנך עומד לרוקן את הסל שלך, הנך בטוח?');

        if (result) {
            window.location = "<?php echo site_url(); ?>/Shopping_cart_controller/remove/all";
        } else {
            return false; // cancel button
        }
    }
</script>