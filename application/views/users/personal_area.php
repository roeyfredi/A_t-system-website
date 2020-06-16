<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/personal_area_style.css"/>
<?php
if (isset($_SESSION['user'])) {
    
} else {

    redirect('Homepage_controller/access_denied');
}
?>

<main>
    <div id="tabContent">
        <h2 style='text-align: center;'>שלום <?php echo $user_info[0]['first_name'] ?>, ברוך הבא לאיזור האישי </h2>
        <ul class="tabs">
            <li class="selected"><a href="TabbedDivs_combo.html#" rel="view1">הפרופיל שלי</a></li>
            <li><a href="TabbedDivs_combo.html#" rel="view2">ההזמנות שלי</a></li>
        </ul>

        <div class="tabcontents">

            <div id="view1" class="tabcontent">

                <a href="<?php echo site_url(); ?>/Customer_controller/update_customer_profile?user_number=<?php echo $user['user'][0]['user_number']; ?> ">
                    <img class="img_box" src="<?php echo base_url(); ?>assets/images/update_icon.jpg" title="עדכן פרטים">
                </a>
                
                <h2 style='text-align: center; text-decoration: underline;'>הפרטים שלי</h2><br>
                <p class='personal_area_p'>מספר לקוח:</p><p class='details_of_customer'><?php echo $user_info[0]['user_number'] ?></p><br>
                <p class='personal_area_p'>שם פרטי:</p><p class='details_of_customer'><?php echo $user_info[0]['first_name'] ?></p><br>
                <p class='personal_area_p'>שם משפחה:</p><p class='details_of_customer'><?php echo $user_info[0]['last_name'] ?></p><br>
                <p class='personal_area_p'>שם משתמש:</p><p class='details_of_customer'><?php echo $user_info[0]['username'] ?></p><br>
                <p class='personal_area_p'>איימיל:</p><p class='details_of_customer'><?php echo $user_info[0]['email'] ?></p><br>
                <p class='personal_area_p'>כתובת:</p><p class='details_of_customer'><?php echo $user_info[0]['adress'] ?></p><br>
                <p class='personal_area_p'>עיר:</p><p class='details_of_customer'><?php echo $user_info[0]['city'] ?></p><br>
                <p class='personal_area_p'>טלפון:</p><p class='details_of_customer'><?php echo $user_info[0]['phone'] ?></p><br>
                <br />
            </div>
            <!--- end view1 --->

            <div id="view2" class="tabcontent">
                <h2 style='text-align: center; text-decoration: underline;'>ההזמנות שלי</h2>
                <?php echo form_open('/Customer_controller/personal_area'); ?>
                <div class="limiter">
                    <div class="container-table100">
                        <div class="wrap-table100">
                            <div class="table100">
                                <table>
                                    <thead>
                                        <tr class="table100-head">
                                            <th class="column1">מספר הזמנה</th>
                                            <th class="column2">תאריך הזמנה</th>
                                            <th class="column3">מחיר הזמנה</th>   
                                            <th class="column4">אספקה</th>   
                                            <th class="column5">אישור הזמנה</th>
                                            <th class="column6">פרטי הזמנה</th>
                                        </tr>
                                    </thead>
                                    <?php foreach ($purchases as $purchase): ?>
                                        <tbody id="myTable">  
                                            <tr class="order_details_tr">
                                                <td class = "column1 col1med"><?php echo $purchase['order_number_fk']; ?></td>

                                                <td class="column2"><?php echo date('תאריך: d-m-y', strtotime($purchase['order_date'])); ?><?php echo '<br>' . date('שעה:H:i', strtotime($purchase['order_date'])); ?></td> 
                                                <td class="column3"><?php echo number_format($purchase['total_price']) . ' &#8362'; ?></td>  
                                                <td class="column4">
                                                    <?php if ($purchase['supply'] == "delivery") { ?>
                                                        משלוח בתוספת של 50 ש"ח
                                                    <?php } if ($purchase['supply'] == "installation") { ?>
                                                        התקנה בתוספת של 100 ש"ח
                                                    <?php } if ($purchase['supply'] == "self_pickup") { ?>
                                                        איסוף עצמי ללא תוספת תשלום
                                                    <?php } ?>

                                                </td>
                                                <td class="column5">
                                                    <input type="text"  name="order_number" class="order_number" value=<?php echo $purchase['order_number_fk']; ?> />
                                                    מאושר
                                                </td>   

                                                <td class="column6"><button type="button" id="button_details" class="order_details_button">צפה בפרטי הזמנה</button></td>
                                            </tr>
                                            <tr class="order_details">

                                                <td colspan="6" class="hiddenRow">

                                                    <div class="products_in_order_mobile"> 
                                                        <?php
                                                        $i = 1;
                                                        foreach ($product_purchase as $product_in_order):
                                                            if ($purchase['order_number_fk'] == $product_in_order['order_number_fk']) {
                                                                ?> 
                                                                <br>
                                                                <?php echo '<img class="product_image" src="data:image/jpeg;base64,' . base64_encode($product_in_order['image']) . '"/>'; ?>
                                                                <span id="number_of_product"><?php echo $i . ")" ?></span>
                                                                <p><?php echo '<b>מק"ט:</b>' . $product_in_order['product_code_fk']; ?></p>
                                                                <p><?php echo '<b>שם מוצר:</b>' . $product_in_order['model']; ?></p>
                                                                <p><?php echo '<b>כמות:</b>' . $product_in_order['quantity']; ?></p>
                                                                <p><?php echo '<b>מחיר ליחידה:</b>' . number_format($product_in_order['price_per_unit']) . ' &#8362'; ?></p>

                                                                <hr>


                                                                <?php
                                                                $i++;
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
            </div>
        </div>
        <?php echo form_close() ?>


    </div>
    <!--- end div class tabcontents --->

    <!--- end div tabContent --->
</main>

<script>


    $(document).ready(function () {

        $('.order_details').hide();
        $(".order_details_button").click(function () {

            $(this).parents("tr").next().slideToggle();
        });
    });
    var tabs = (function () {
        var b = function (c, a) {
            var b = new RegExp("(^| )" + a + "( |$)");
            return b.test(c.className) ? true : false;
        },
                j = function (a, c) {
                    if (!b(a, c))
                        if (a.className == "")
                            a.className = c;
                        else
                            a.className += " " + c;
                },
                h = function (a, b) {
                    var c = new RegExp("(^| )" + b + "( |$)");
                    a.className = a.className.replace(c, "$1");
                    a.className = a.className.replace(/ $/, "");
                },
                g = function (c, b) {
                    var a = document.getElementsByTagName("html");
                    if (a)
                        a[0].scrollTop += b;
                },
                e = function () {
                    var b = window.location.pathname;
                    if (b.indexOf("/") != -1)
                        b = b.split("/");
                    var a = b[b.length - 1] || "root";
                    if (a.indexOf(".") != -1)
                        a = a.substring(0, a.indexOf("."));
                    if (a > 20)
                        a = a.substring(a.length - 19);
                    return a;
                },
                d = e(),
                c = function (a) {
                    this.a = 0;
                    this.b = [];
                    this.c = [];
                    this.d = [];
                    this.e = 0;
                    this.f(a);
                };
        c.prototype = {
            g: function (b) {
                var c = new RegExp(d + b + "=(\\d+)"),
                        a = document.cookie.match(c);
                return a ? a[1] : this.h();
            },
            h: function () {
                for (var a = 0, c = this.d.length; a < c; a++)
                    if (b(this.d[a], "selected"))
                        return a;
                return 0;
            },
            j: function (d, c) {
                for (var b = d.getAttribute("rel"), a = 0; a < this.b.length; a++)
                    if (this.b[a].getAttribute("rel") == b) {
                        j(this.b[a].parentNode, "selected");
                        c && this.e && this.k(this.a, a);
                    } else
                        h(this.b[a].parentNode, "selected");
                this.l(b);
            },
            k: function (a, b) {
                document.cookie = d + a + "=" + b + "; path=/";
            },
            l: function (b) {
                for (var a = 0; a < this.c.length; a++)
                    this.c[a].style.display = this.c[a].id == b ? "block" : "none";
            },
            m: function (a) {
                if (a.id)
                    for (var b = 0; b < this.b.length; b++)
                        if (this.b[b].getAttribute("rel") == a.id)
                            return this.b[b];
                return a.parentNode.nodeName != "BODY" ? this.m(a.parentNode) : null;
            },
            n: function (d, c) {
                var a = document.getElementById(d);
                if (a) {
                    var b = this.m(a);
                    if (b) {
                        this.j(b, 0);
                        if (!c)
                            setTimeout(function () {
                                a.scrollIntoView();
                                g(a, -120);
                            }, 0);
                        else
                            setTimeout(function () {
                                window.scrollTo(0, 0);
                            }, 0);
                        return 1;
                    } else
                        return 0;
                }
            },
            f: function (a) {
                this.a = a.i;
                this.b = a.getElementsByTagName("a");
                this.d = a.getElementsByTagName("li");
                for (var b = 0; b < this.b.length; b++)
                    if (this.b[b].getAttribute("rel")) {
                        this.c.push(document.getElementById(this.b[b].getAttribute("rel")));
                        var f = this;
                        this.b[b].onclick = function () {
                            f.j(this, 1);
                            return false;
                        };
                    }
                var e = a.getAttribute("persist") || "";
                this.e = e.toLowerCase() == "true" ? 1 : 0;
                var d = window.location.hash;
                if (d && d.length > 1)
                    if (
                            this.n(
                                    d.substring(1),
                                    window.location.search.indexOf("noscroll=true") > -1
                                    )
                            )
                        return;
                var c = this.e ? parseInt(this.g(a.i)) : this.h();
                if (c >= this.b.length)
                    c = 0;
                this.j(this.b[c], 0);
            }
        };
        var a = [],
                i = function (d) {
                    var b = false;
                    function a() {
                        if (b)
                            return;
                        b = true;
                        setTimeout(d, 4);
                    }
                    if (document.addEventListener)
                        document.addEventListener("DOMContentLoaded", a, false);
                    else if (document.attachEvent) {
                        try {
                            var e = window.frameElement != null;
                        } catch (f) {
                        }
                        if (document.documentElement.doScroll && !e) {
                            function c() {
                                if (b)
                                    return;
                                try {
                                    document.documentElement.doScroll("left");
                                    a();
                                } catch (d) {
                                    setTimeout(c, 10);
                                }
                            }
                            c();
                        }
                        document.attachEvent("onreadystatechange", function () {
                            document.readyState === "complete" && a();
                        });
                    }
                    if (window.addEventListener)
                        window.addEventListener("load", a, false);
                    else
                        window.attachEvent && window.attachEvent("onload", a);
                },
                f = function () {
                    for (
                            var e = document.getElementsByTagName("ul"), d = 0, f = e.length;
                            d < f;
                            d++
                            )
                        if (b(e[d], "tabs")) {
                            e[d].i = a.length;
                            a.push(new c(e[d]));
                        }
                };
        i(f);
        return {
            open: function (c, d) {
                for (var b = 0; b < a.length; b++)
                    a[b].n(c, d);
            }
        };
    })();


</script>