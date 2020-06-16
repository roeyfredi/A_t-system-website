<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/management_welcome_page_style.css"/>

<?php
if (isset($_SESSION['user'])) {
    
} else {

    redirect('Homepage_controller/access_denied');
}
?>

<main>
    <div class="col-xl-3 float_right tab vertical_nav">
        <button class="tablinks active" id="homepage_mobile" onclick="openInfo(event, 'homepage')"><i class="fa fa-home" aria-hidden="true"></i> דף הבית- ניהול</button>
        <button class="tablinks"  onclick="openInfo(event, 'costumers')"><i class="fa fa-user" aria-hidden="true"></i> לקוחות</button>
        <button class="tablinks" onclick="openInfo(event, 'inventory')"><i class="fa fa-truck" aria-hidden="true"></i> מלאי</button>
        <!--        <button class="tablinks"></button>-->
    </div>

    <!-- Tab content -->
    <div class="management_options">
        <div id="homepage" class="col-md-9 tabcontent float_right">
            <h3 class="homepage_title">שלום <?php echo $user['user'][0]['first_name'] ?>, ברוך הבא לדף מנהל</h3>
            <h4 class="subtitle">.בעמוד זה תוכל לצפות בסטטיסטקות שונות על ביצועי האתר
            </h4><br>
            <h4 class="hidden_homepage_mobile">על מנת לצפות בעמוד זה, אנא סובב את המכשיר לרוחב</h4><br>

            <div class='time' id='time'></div>

            <h4 class="top_products_sales_title">המוצרים הנמכרים ביותר</h4>
            <div id="barchart_top_products_sales"></div>
            <div class="legend">
                <h4 class="legend_title">מקרא</h4>
                <?php
                foreach ($top_products_sales as $product) {
                    echo $product['product_code_fk'] . " - " . $product['model'] . "<br>";
                }
                ?>
            </div>

            <hr class="hr_line">
            <h4 class="top_products_sales_title">התפלגות המכירות החודשיות לפי יחידות על פי קטגוריות מוצרים </h4>
            <div id="piechart_products_unit_sales_by_categories"></div>
            <div class="management_page"></div>
            <hr class="hr_line">
            <h4 class="top_products_sales_title">הכנסות חודשיות בשקלים על פי קטגוריות מוצרים </h4>
            <div id="piechart_products_sales_income_by_categories"></div>
            <div class="management_page"></div>
            <hr class="hr_line">





        </div>

        <div id="costumers" class="col-md-9 tabcontent float_right">
            <h3 class="costumers_title">לקוחות</h3>

            <div class="col-md-6 float_right">
                <a href="<?php echo site_url(); ?>/Management_controller/registered_customers">
                    <div class="boxed">
                        <p class="box_info">טבלת לקוחות</p>
                        <img class="img_box" src="<?php echo base_url(); ?>assets/images/customers_icon.jpg"/>
                    </div>
                </a>
            </div>

            <div class="col-md-6 float_right">
                <a href="<?php echo site_url(); ?>/Management_controller/contacts_messages">
                    <div class="boxed">
                        <p class="box_info">הודעות מלקוחות</p>
                        <img class="img_box" src="<?php echo base_url(); ?>assets/images/message_icon.jpg"/>
                    </div>
                </a>
            </div>
        </div>


        <div id="inventory" class="col-md-9 tabcontent float_right">
            <h3 class="inventory_title">מלאי</h3>
            <div class="col-md-3 float_right">
                <a href="<?php echo site_url(); ?>/Management_controller/add_new_product">
                    <div class="boxed">
                        <p class="box_info"> הוסף מוצר חדש למלאי</p>
                        <img class="img_box" src="<?php echo base_url(); ?>assets/images/new_product.png"/>
                    </div>
                </a>
            </div>
            <div class="col-md-3 float_right">
                <a href="<?php echo site_url(); ?>/Management_controller/products_table">
                    <div class="boxed">
                        <p class="box_info"> טבלת מוצרים</p>
                        <img class="img_box" src="<?php echo base_url(); ?>assets/images/table_product.png"/>
                    </div>
                </a>
            </div>
            <div class="col-md-3 float_right">
                <a href="<?php echo site_url(); ?>/Management_controller/inventory_orders">
                    <div class="boxed">
                        <p class="box_info">הזמנת מלאי</p>
                        <img class="img_box" src="<?php echo base_url(); ?>assets/images/order_inventory_pic.png"/>
                    </div>
                </a>
            </div>

            <div class="col-md-3 float_right">
                <a href="<?php echo site_url(); ?>/Management_controller/inventory_orders_status">
                    <div class="boxed">
                        <p class="box_info">סטטוס הזמנות מלאי</p>
                        <img class="img_box" src="<?php echo base_url(); ?>assets/images/inventory_orders_status.jpg"/>
                    </div>
                </a>
            </div>

        </div>
    </div>
    <div class="management_page">
    </div>

</main>

<script>

    var monthNames = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ];
    var dayNames = [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday"
    ];
    function checkTime() {
        var date = new Date();
        var sufix = "";
        var hours = ("0" + date.getHours()).slice(-2);
        var minutes = ("0" + date.getMinutes()).slice(-2);
        var day = date.getDate();
        var month = monthNames[date.getMonth()];
        var weekday = dayNames[date.getDay()];
        if (day > 3 && day < 21)
            sufix = "th";
        switch (day % 10) {
            case 1:
                sufix = "st";
            case 2:
                sufix = "nd";
            case 3:
                sufix = "rd";
            default:
                sufix = "th";
        }
        document.getElementById("time").innerHTML =
                "<span class='hour'>" +
                hours +
                ":" +
                minutes +
                "</span><br/><span class='date'>" +
                month +
                " " +
                day +
                sufix +
                ", " +
                weekday +
                ".";
    }

    setInterval(checkTime(), 1000);
    function openInfo(evt, tabName) {
        // Declare all variables
        var i, tabcontent, tablinks;
        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }



    $(document).ready(function () {
        $("#search_input").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    Number.prototype.pad = function (n) {
        for (var r = this.toString(); r.length < n; r = 0 + r)
            ;
        return r;
    };
    Number.prototype.pad = function (n) {
        for (var r = this.toString(); r.length < n; r = 0 + r)
            ;
        return r;
    };</script>

<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['מק"ט', ''],
<?php
foreach ($top_products_sales as $static) {
    echo "['" . 'מק"ט:' . $static['product_code_fk'] . "'," . $static['sum(quantity)'] . "],";
}
?>
        ]);

        var options = {
            tooltip: {isHtml: true},
            legend: {position: 'none'},
            title: {
                display: true,
                text: 'המוצרים הנמכרים ביותר'
            },
            is3D: true,
            backgroundColor: {fill: '#808080'},
            chartArea: {
                backgroundColor: '#808080',
            },
            vAxes: {
                0: {title: 'מספר רכישות', titleTextStyle: {color: '#FFF'}, textStyle: {color: '#FFF', fontSize: 10}},
            },
            hAxis: {
                title: 'מק"ט',
                textStyle: {color: '#FFF'},
                titleTextStyle: {color: '#FFF'},
                fontSize: 10,
            },
            bar: {groupWidth: "90%"},
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('barchart_top_products_sales'));

        chart.draw(data, options);
    }
</script>



<script type="text/javascript">

    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(pieDrawChart);

    function pieDrawChart() {

        var data = google.visualization.arrayToDataTable([
            ['קטגוריה', 'כמות יחידות'],
<?php
foreach ($products_unit_sales_by_categories as $static) {
    echo "['" . $static['product_type'] . "'," . $static['sum(quantity)'] . "],";
}
?>
        ]);

        var options = {
            is3D: true,
            backgroundColor: {fill: '#808080'},
            legend: {useHTML: true, textStyle: {color: 'white', ltr: true}},
            tooltip: {
                useHTML: true,
                style: {
                    fontSize: '20px',
                    fontFamily: 'tahoma',
                },
            },
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_products_unit_sales_by_categories'));

        chart.draw(data, options);
    }
</script>

<script type="text/javascript">

    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(pieDrawChart2);

    function pieDrawChart2() {

        var data = google.visualization.arrayToDataTable([
            ['קטגוריה', 'הכנסה כספית'],
<?php
foreach ($products_sales_income_by_categories as $static) {
    echo "['" . $static['product_type'] . "'," . $static['sum(products_in_order_of_costumers.price_per_unit*products_in_order_of_costumers.quantity)'] . "],";
}
?>
        ]);

        var options = {
            is3D: true,
            backgroundColor: {fill: '#808080'},
            legend: {useHTML: true, textStyle: {color: 'white', rtl: false}},
            tooltip: {
                useHTML: true,
                style: {
                    fontSize: '20px',
                    fontFamily: 'tahoma',
                },
            },
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_products_sales_income_by_categories'));

        chart.draw(data, options);
    }
</script>


