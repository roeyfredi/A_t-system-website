<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/products_page_style.css"/>
<main>
    <div class="container">
        <h2 class="products_page_title">אביזרים לרכב</h2>
        <div class="row">
            <?php
            foreach ($car_accessories as $product) {
                $befor_discount = (int) ($product['retail_price'] * 0.20 + $product['retail_price']);
                ?>

                <div class="col-md-4 card_to_right">
                    <div class="card">
    <?php echo '<img class="showImg" src="data:image/jpeg;base64,' . base64_encode($product['image']) . '"/>'; ?>
                        <div class="post-s">
                            <h2><?php echo $product['product_type'] ?> </h2>
                        </div>


                        <h3><?php echo $product['model'] ?></h3>
                        <h4><?php echo $befor_discount ?> &#8362 </h4>
                        <h3><?php echo $product['retail_price'] ?> &#8362 </h3>
                        <br>
                        <a href="<?php echo site_url(); ?>/Products_controller/product_page?product_code=<?php echo $product['product_code'] ?>"
                           <p><button>לפרטים נוספים</button></p>
                        </a>
                    </div>
                </div>


<?php } ?>

        </div>
    </div>

</main>
