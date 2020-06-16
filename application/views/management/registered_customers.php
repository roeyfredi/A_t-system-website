<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/registered_customers_style.css"/>
<?php
if (isset($_SESSION['user'])) {
    
} else {
    redirect('Homepage_controller/access_denied');
}
?>

<main>
    <p class="title">טבלת לקוחות</p>
    <h4 class="subtitle">בטבלה זו תוכל לנהל לקוחות ולצפות בעסקאותיהם.
    </h4><br>
    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <table>
                        <thead>
                            <tr class="table100-head">
                                <th class="column1">מספר משתמש</th>
                                <th class="column2">שם פרטי</th>
                                <th class="column3">שם משפחה</th>          
                                <th class="column4">כתובת</th>
                                <th class="column5">עיר</th>
                                <th class="column6">טלפון</th>
                                <th class="column7">אימייל</th>
                                <th class="column9"></th>
                                <th class="column10"><input id="search_input" type="text" placeholder="חפש בטבלה..."></th>
                            </tr>
                        </thead>
                        <?php foreach ($customers as $customer): ?>
                            <tbody id="myTable">

                                <tr>

                                    <td class = "column1 col1med"><?php echo $customer['user_number']; ?></td>
                                    <td class="column2"><?php echo $customer['first_name']; ?></td> 
                                    <td class="column3"><?php echo $customer['last_name']; ?></td>  
                                    <td class="column4"><?php echo $customer['adress']; ?></td>
                                    <td class="column5"><?php echo $customer['city']; ?></td>
                                    <td class="column6"><?php echo $customer['phone']; ?></td>
                                    <td class="column7"><?php echo $customer['email']; ?></td>
                                    <td class="column9"> 
                                        <a  class=column9 href="<?php echo site_url(); ?>/Management_controller/customer_orders?user_number=<?php echo $customer['user_number'] ?>">
                                            <p><button>מעבר לעסקאות </button></p>
                                        </a>
                                    </td> 
                                    <td class="column10_td"> 
                                        <a  class="column10_td" href="<?php echo site_url(); ?>/Management_controller/remove_customer_from_db?user_number=<?php echo $customer['user_number'] ?>">
                                            <p><button class="column10_td">מחיקת לקוח </button></p>
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