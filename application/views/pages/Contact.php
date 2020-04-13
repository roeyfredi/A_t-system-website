<main class="direction">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/contact_style.css"/>

    <div class="backgroundImg">
        <div class="center"> 
            <div class="row">

                <div class="col-md-12 direction" id="form_container">
                    <h2>צור קשר</h2>
                    <p>
                        השאר הודעה, ואנו ניצור איתך קשר ב-24 שעות הקרובות!
                    </p>
                    <form class="" role="form" method="post" id="reused_form">

                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label for="message">
                                    הודעה:</label>
                                <textarea class="form-control" type="textarea" id="message" name="message" maxlength="6000" rows="7"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <?php if (isset($_SESSION['user'][0]['first_name'])) {
                                ?>
                                <div class="col-sm-6 form-group">
                                    <label for="email">
                                        מספר פלאפון:</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['user'][0]['phone'] ?>" readonly>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="name">
                                        השם שלך:</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['user'][0]['first_name'] . ' ' . $user['user'][0]['last_name'] ?>" readonly>
                                </div>
                            <?php } else {
                                ?>
                                <div class="col-sm-6 form-group">
                                    <label for="email">
                                        מספר פלאפון:</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="name">
                                        השם שלך:</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>                           


                            <?php } ?>

                        </div>



                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <button type="submit" class="btn btn-lg btn-default pull-right contact_button">שלח</button>
                            </div>
                        </div>

                    </form>
                </div>
                <div id="success_message" style="width:100%; height:100%; display:none; ">
                    <h3>Posted your message successfully!</h3>
                </div>
                <div id="error_message"
                     style="width:100%; height:100%; display:none; ">
                    <h3>Error</h3>
                    Sorry there was an error sending your form.

                </div>
            </div>
        </div>
    </div>

</main>

<script>
    $(function ()
    {
        function after_form_submitted(data)
        {
            if (data.result == 'success')
            {
                $('form#reused_form').hide();
                $('#success_message').show();
                $('#error_message').hide();
            }
            else
            {
                $('#error_message').append('<ul></ul>');

                jQuery.each(data.errors, function (key, val)
                {
                    $('#error_message ul').append('<li>' + key + ':' + val + '</li>');
                });
                $('#success_message').hide();
                $('#error_message').show();

                //reverse the response on the button
                $('button[type="button"]', $form).each(function ()
                {
                    $btn = $(this);
                    label = $btn.prop('orig_label');
                    if (label)
                    {
                        $btn.prop('type', 'submit');
                        $btn.text(label);
                        $btn.prop('orig_label', '');
                    }
                });

            }//else
        }

        $('#reused_form').submit(function (e)
        {
            e.preventDefault();

            $form = $(this);
            //show some response on the button
            $('button[type="submit"]', $form).each(function ()
            {
                $btn = $(this);
                $btn.prop('type', 'button');
                $btn.prop('orig_label', $btn.text());
                $btn.text('Sending ...');
            });


            $.ajax({
                type: "POST",
                url: 'handler.php',
                data: $form.serialize(),
                success: after_form_submitted,
                dataType: 'json'
            });

        });
    });
</script>










