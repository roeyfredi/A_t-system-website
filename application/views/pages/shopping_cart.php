<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/shopping_cart_style.css"/>

<?php
if (isset($_SESSION['user'])) {
    
} else {

    redirect('Homepage_controller/access_denied');
}
?>

<?php //print_r($user); ?>

<main style="direction: rtl;">
    <div style="padding-bottom:10px">
        <h1 align="center">הסל שלך</h1>
        <?php if ($this->cart->total_items() == 0) {
            ?>
            <p class="empty_cart">טרם הוספת מוצרים לסל, הסל ריק!</p>
            <img class="empty_shopping_cart_img" style="margin-top:3%;"src= "<?php echo base_url(); ?>assets/images/empty_shopping_cart.jpg"/>   
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
                                            <?php echo form_input('cart[' . $item['id'] . '][qty]', $item['qty'], 'maxlength="3" size="3" class="quantity_input" style="text-align: center;display:block;margin-right: auto;margin-left: auto; "'); ?>
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

                            <button type="button" class="clean_cart_button" onclick="clear_cart()">
                                <span class="glyphicon glyphicon-trash"></span> נקה עגלה
                            </button>
    <!--                    <input type="submit" class="update_cart" value="עדכן עגלת קניות">-->

                            <button type="submit" class="update_cart_button">
                                <span class="glyphicon glyphicon-refresh"></span> עדכן עגלת קניות
                            </button>

                            <input type="button" class="button_paymant" value="לתשלום">
                        </div>
                    <?php } ?>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>

    <?php if ($cart = $this->cart->contents()): ?>

        <div class="payment_div">
            <?php echo form_open('Paypal_controller/create_payment_with_paypal'); ?>
            <fieldset class="center_payment_div">
                <h2 class="title_of_purchase">רכישה</h2>

                <label class="lab"> מספר לקוח</label>
                <input type="text" name="costumer_number" class="inputs_payment" value="<?php echo $user['user'][0]['user_number'] ?>" readonly><br>
                <label class="lab">שם לקוח</label>
                <input type="text" name="costumer_name" class="inputs_payment"  value="<?php echo $user['user'][0]['first_name'] . ' ' . $user['user'][0]['last_name'] ?>" readonly><br>
                <label class="lab">מחיר לתשלום</label>
                <input type="text" name="price" class="inputs_payment" id="total_price" value='<?php echo number_format($grand_total, 2); ?> ש"ח'  readonly><br>
                <input type="text" name="price" class="inputs_payment" id="total_price_hidden" style="visibility: hidden;" value="<?php echo $grand_total; ?>" readonly>


                <div class="radio_right"> 
                    <p class="supply_buttons_title">בחר אופציית אספקה:</p>
                    <input type="radio" id="self_pickup" name="supply" value="self_pickup" checked>
                    <label  for="self_pickup" class="mobile_view_label">איסוף עצמי-בלי תוספת תשלום</label><br>
                    <input type="radio" id="delivery" name="supply" value="delivery">
                    <label for="other" class="mobile_view_label">משלוח- בתוספת של 50 ש"ח</label><br>
                    <input type="radio" id="installation" name="supply" value="installation">
                    <label for="female" class="mobile_view_label">התקנה בחנות-תוספת של 100 ש"ח</label>
                </div>

                <div class="contact-form">

                    <p class="notice error"><?= $this->session->flashdata('error_msg') ?></p><br/>
                    <p class="notice error"><?= $this->session->flashdata('success_msg') ?></p><br/>

                    <?php echo form_open('Paypal_controller/create_payment_with_paypal'); ?>
                    <fieldset>
                        <input title="custom" name="custom" type="hidden" value="<?php echo $user['user'][0]['user_number'] ?>">
                        <input title="item_number" name="item_number" type="hidden" value="12345">
                        <input title="item_description" name="item_description" type="hidden" value="confirm">
                        <input title="order_tax" name="order_tax" type="hidden" value="0">
                        <input title="item_price" name="item_price" type="hidden" value="0">
                        <input title="details_tax" name="details_tax" type="hidden" value="0">
                        <input title="details_subtotal" name="details_subtotal" id="total_price_to_send" type="hidden" value="<?php echo ((int) (($grand_total))); ?>">


                        <button class="pay_submit" type="submit" name="submit" >
                            שלם באמצעות 
                            <img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png" alt="PayPal" />
                        </button>

                    </fieldset>

                </div>
            <?php endif; ?>





        </fieldset>
    </div>

</main>

<script>
    $(document).ready(function () {
        $('.payment_div').hide();
        $(".button_paymant").click(function () {
            //$('.button_paymant').load(<?php echo site_url(); ?>/Shopping_cart_controller/update_cart>);

            $(".payment_div").slideToggle();
        });

        $("input[type=radio]").click(function () {
            
<?php if ($cart = $this->cart->contents()): ?>
                $price = parseInt($('#total_price_hidden').val());
                $update_price = parseInt(0);
                $result = parseInt(0);
                if ($('#self_pickup').is(':checked')) {
                    $update_price = 0;
                }
                if ($('#delivery').is(':checked')) {
                    $update_price = 50;
                }
                if ($('#installation').is(':checked')) {
                    $update_price = 100;
                }
                $update_price = parseInt($update_price);
                $result = $update_price + $price;
                $result = $result.toLocaleString();

                $('#total_price').val($result + ' ש"ח').trigger('change');
                $('#total_price_to_send').val($result).trigger('change');
<?php endif ?>
        });
    });
    function clear_cart() {
        var result = confirm('הנך עומד לרוקן את הסל שלך, הנך בטוח?');
        if (result) {
            window.location = "<?php echo site_url(); ?>/Shopping_cart_controller/remove/all";
        } else {
            return false; // cancel button
        }
    }


</script>

