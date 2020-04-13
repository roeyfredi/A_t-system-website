<main>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/registration_style.css"/>




    <?php echo form_open('Registration_controller/registerNotes'); ?>
    <div class="center">
        <fieldset>
            <p class="title">הרשמה</p>

            <p id="error"></p>

            <div><input placeholder="הכנס שם פרטי" type="text" id='first_name' name="first_name" maxlength="15"></div>
            <div><input placeholder="הכנס שם משפחה" type="text" id='last_name' name="last_name" maxlength="15"></div>
            <div><input placeholder="הכנס כתובת" type="text" id='adress' name="adress" maxlength="25"></div>
            <div><input placeholder="הכנס עיר" type="text" id='city' name="city" maxlength="15"></div>
            <div><input placeholder="הכנס מספר טלפון" type="text" id='phone' name="phone"></div>
            <div><input placeholder="הכנס שם משתמש" type="text" id='username' name="username" maxlength="15"></div>
            <div><input placeholder="הכנס סיסמא" type="password" id='password' name="password" maxlength="8" onkeyup="check()" ></div> 
            <div><input placeholder="הכנס אימות סיסמא" type="password" id='passwordConf' name="passwordConf" maxlength="8" onkeyup="check()"></div>
            <p id='message'></p>
            <div><input placeholder="הכנס אימייל" type="email" id='email' name="email"></div>

            <div><input id="user_registration" class="user_registration" type="button" value="הירשם" name="submit" ></div>




        </fieldset>
    </div>
    <?php echo form_close(); ?>

</main>

<script>
    var check = function () {
        if (document.getElementById('password').value ==
                document.getElementById('passwordConf').value) {
            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = 'סיסמה תואמת';
        } else {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'סיסמה לא תואמת';
        }
    }

    $("#user_registration").click(function () {

        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var phone = $("#phone").val();
        var email = $("#email").val();
        var username = $("#username").val();
        var password = $("#password").val();
        var passwordConf = $("#passwordConf").val();
        var city = $("#city").val();
        var adress = $("#adress").val();

        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>" + "/Registration_controller/registerNotes",
            data: {first_name: first_name, last_name: last_name, adress: adress, city: city, phone: phone, username: username,
                password: password, passwordConf: passwordConf, email: email},
            success: function (data) {
                var x = data;
                x = parseInt(data);
                if (x == "1") {
                    alert("ההרשמה הסתיימה בהצלחה, הנכם מועברים לדף הבית!");
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