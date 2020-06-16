<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/update_customer_profile_style.css"/>
<?php
if (isset($_SESSION['user'])) {
    
} else {

    redirect('Homepage_controller/access_denied');
}
?>


<main>
    <?php
//    $description = $product[0]['description'];
//    echo($description);
    ?>

    <div class="center">

        <p id="error"></p>
        <?php
        $attributes = array('name' => 'login_data');
        echo form_open_multipart('Management_controller/update_profile_notes', $attributes);
        ?>

        <p class="title">עדכן פרופיל</p>

        <div><label>מספר לקוח: </label><input id="user_number" class="formInput" type="text" name="user_number" value="<?php echo $user_info[0]['user_number'] ?>" readonly disabled></div>
        <div><label>שם פרטי: </label><input id="first_name" class="formInput" type="text" name="first_name" value="<?php echo $user_info[0]['first_name'] ?>"></div>

        <div><label>שם משפחה: </label><input id="last_name"  class="formInput" type="text" name="last_name"  maxlength="25" value="<?php echo $user_info[0]['last_name'] ?>"></div>
        <div><label>כתובת:</label><input id="adress" class="formInput" type="text"  name="adress" value="<?php echo $user_info[0]['adress'] ?>"></div>

        <div><label>עיר:</label><input id="city"  class="formInput" type="text"  name="city" value="<?php echo $user_info[0]['city'] ?>"></div>

        <div><label>טלפון:</label><input id="phone" class="formInput" type="text"  name="phone" value="<?php echo $user_info[0]['phone'] ?>"></div>
        <div><label>אימייל:</label><input id="email" class="formInput" type="text"  name="email" value="<?php echo $user_info[0]['email'] ?>"></div>  
        <div><input id="update_profile_button" type="button" value="עדכן פרופיל" name="submit"></div>        



    </div>
</main>


<script>

    $("#update_profile_button").click(function () {
 
        var user_number = $("#user_number").val();
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var adress = $("#adress").val();
        var city = $("#city").val();
        var phone = $("#phone").val();
        var email = $("#email").val();

        var form_data = new FormData();
        form_data.append("user_number", user_number);
        form_data.append("first_name", first_name);
        form_data.append("last_name", last_name);
        form_data.append("adress", adress);
        form_data.append("city", city);
        form_data.append("phone", phone);
        form_data.append("email", email);


        $.ajax({
            type: 'POST',
            url: "<?php echo site_url(); ?>" + "/Customer_controller/update_profile_notes",
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            error: function () {
                alert('Something is wrong');
            },
            success: function (data) {
                var x= parseInt(data);
                if (x == "1") {
                    alert("הפרופיל עודכן בהצלחה!");
                    window.location.href = "<?php echo site_url('Customer_controller/personal_area'); ?>";
                }
                else {
                    $("#error").html(data);
                    $('html,body').scrollTop(0);

                }

            }

        });


    });
</script>