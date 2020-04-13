<main>
     <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/log_in_style.css"/>
    
    <div class="log_in center">
      
        
<?php echo form_open('Login_controller/auth'); ?>
        <fieldset>
            <p class="title">התחברות</p>
              <p id="error"><?php if (isset($error)) {echo $error['message'];} ?></p>
            <div><input placeholder="הכנס שם משתמש" type="text" name="user"></div>
            <div><input placeholder="הכנס סיסמא" type="password" name="password"></div>
            
            <div><button type="submit" class="submit_button" name="submit">התחברות</button></div>
            
   
        </fieldset>
    </div>

</main>
