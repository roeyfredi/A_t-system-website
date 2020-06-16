<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/contact_style.css"/>
<main class="direction">

    <div class="backgroundImg">
        <div class="center"> 
            <div class="row">

                <?php
                $attributes = array('name' => 'contact_form');
                echo form_open('Customer_controller/contactNotes', $attributes);
                ?>

                <div class="col-md-12 direction" id="form_container">
                    <p id="error"></p>
                    <h2 class="contact_title">צור קשר</h2>
                    <p class="contact_title">
                        השאר הודעה, ואנו ניצור איתך קשר ב-24 שעות הקרובות!
                    </p>
                    <br>
                    <p><b>נושא ההודעה: </b></p>
                    <select id="contact_subject" name="contact_subject" class="dropdown_product_type" style="width:100%;border-radius: 5px;">
                        <option value="רכישה">רכישה</option>
                        <option value="ייעוץ">ייעוץ</option>
                        <option value="תיקון">תיקון</option>
                        <option value="אחר">אחר</option>
                    </select>


                    <div class="row">
                        <div class="col-sm-12 form-group"><br>
                            <label for="message">
                                הודעה:</label>
                            <textarea class="form-control" id="contact_message" name="contact_message" maxlength="6000" rows="7" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <?php if (isset($_SESSION['user'][0]['first_name'])) {
                            ?>
                            <input type="text" class="form-control" style="visibility: hidden;" id="contact_email" name="contact_email" value="<?php echo $user['user'][0]['email'] ?>" readonly>

                            <div class="col-sm-6 form-group">
                                <label for="email">
                                    מספר פלאפון:</label>
                                <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="<?php echo $user['user'][0]['phone'] ?>" readonly>

                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="name">
                                    השם שלך:</label>
                                <input type="text" class="form-control" id="contact_name" name="contact_name" value="<?php echo $user['user'][0]['first_name'] . ' ' . $user['user'][0]['last_name'] ?>" readonly>
                            </div>
                        <?php } else {
                            ?>
                            <div class="col-sm-6 form-group">
                                <label for="phone">
                                    מספר פלאפון:</label>
                                <input type="text" class="form-control" id="contact_phone" name="contact_phone" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="name">
                                    השם שלך:</label>
                                <input type="text" class="form-control" id="contact_name" name="contact_name" required>
                            </div>                           


                        <?php } ?>

                    </div>




                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <button type="button" id="contact_submit_button" class="btn btn-lg btn-default pull-right contact_button">שלח</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>

            </div>
        </div>
    </div>

</main>

<script>

    $("#contact_submit_button").click(function () {
        var contact_subject = $("#contact_subject").val();
        var contact_message = $("#contact_message").val();
        var contact_phone = $("#contact_phone").val();
        var contact_name = $("#contact_name").val();
        var contact_email=$("#contact_email").val();


        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>" + "/Customer_controller/contactNotes",
            data: {contact_subject: contact_subject, contact_message: contact_message, contact_phone: contact_phone, contact_name: contact_name,contact_email:contact_email},
            success: function (data) {
                var x = data;
                x = parseInt(data);
                if (x == "1") {

                    alert("ההודעה נשלחה בהצלחה, הנך מועבר לדף הבית");
                    window.location.href = "<?php echo site_url('Homepage_controller/HomePage'); ?>";
                }
                else if (data != '1') {
                    $("#error").html(data);
                    $('html,body').scrollTop(0);
                }

            },
            error: function (data) {
                alert('Something is wrong');
            }


        });
    });
</script>









