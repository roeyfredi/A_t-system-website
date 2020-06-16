<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/contacts_messages_style.css"/>
<main>
    <p class="title">צור קשר - הודעות שהתקבלו</p>
    <h4 class="subtitle">בעמוד זה תוכל לצפות בכלל ההודעות שהתקבלו מהאתר.
    </h4><br>
    <div class="limiter">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <table>
                        <thead>
                            <tr class="table100-head">
                                <th class="column1">מספר הודעה</th>
                                <th class="column1">תאריך הפניה</th>
                                <th class="column2">שם הלקוח</th>
                                <th class="column3">מספר טלפון</th>
                                <th class="column4">נושא ההודעה</th>
                                <th class="column5"></th>
                                <th class="column6"></th>
                            </tr>
                        </thead>
                        <?php foreach ($messages as $message): ?>
                            <tbody id="myTable">
                                <tr class="message fix_message">
                                    <td class="column1 col1med"><?php echo $message['message_id']; ?></td>
                                    <td class="column2 col1med"><?php echo $message['date']; ?></td>
                                    <td class="column3"><?php echo $message['contact_name']; ?></td> 
                                    <td class="column4"><?php echo $message['contact_phone']; ?></td>
                                    <td class="column5"><?php echo $message['contact_subject']; ?></td>
                                    <td class="column6"><button type="button" id="button_message" class="message_details_button">צפה בהודעה</button></td>
                                    <td class="column7">
                                        <a href="<?php echo site_url(); ?>/Management_controller/remove_message_from_db?message_id=<?php echo $message['message_id'] ?>">
                                            <p><button class="delete_message">מחיקת הודעה </button></p>
                                        </a>
                                    </td>


                                </tr>
                                <tr class="message_details">

                                    <td colspan="7" class="hiddenRow">

                                        <div class="test"> 
                                            <?php
                                            foreach ($messages as $messagem):
                                                if ($messagem['message_id'] == $message['message_id']) {
                                                    ?> 
                                                    <br>
                                                    <h4 class="message_contact"><b>נושא ההודעה:</b> </h4><br>
                                                    <p class="message_contact"><?php echo $messagem['contact_message']; ?></p>

                                                    <?php
                                                }
                                                ?> 
                                            <?php endforeach; ?>

                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function () {

        $('.message_details').hide();
        $(".message_details_button").click(function () {

            $(this).parents("tr").next().slideToggle();
        });
    });


</script>