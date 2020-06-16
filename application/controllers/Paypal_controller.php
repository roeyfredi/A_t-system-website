<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once(APPPATH . 'libraries/paypal-php-sdk/paypal/rest-api-sdk-php/sample/bootstrap.php'); // require paypal files

//לשרת שאנו מעלים זו השורה require_once(APPPATH.'/libraries/PayPal-PHP-SDK/paypal/rest-api-sdk-php/sample/bootstrap.php');

use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;

$supplay = 'test';

class Paypal_controller extends CI_Controller {

    public $_api_context;

    function __construct() {
        parent::__construct();
        $this->load->model('Paypal_model', 'paypal');
        $this->config->load('paypal');
        $this->load->model('Users_model');
        $this->load->model('Products_model');
        $this->load->model('Cart_model');
        $this->load->model('Paypal_model');
        $this->load->library('cart');
        $this->load->helper('url_helper');
        $this->load->helper('form');
        $this->load->library('session');
        //$this->load->controller('Shopping_cart_controller');

        $this->_api_context = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                $this->config->item('client_id'), $this->config->item('secret')
                )
        );
    }

    public function index() {

        $data['title'] = "הסל שלי";
        $data['user'] = $this->session->all_userdata();
        $this->load->view('templates/header', $data);
        $this->load->view('pages/shopping_cart', $data);
        $this->load->view('templates/footer');
    }

    public function create_payment_with_paypal() {


        //$data['user'] = $this->session->all_userdata();


        $_SESSION['supplay'] = $this->input->post('supply');
        //$data['user']['cart_contents']['supply'] =$supplay;
        //$this->session->set_userdata($data);
        //$data['user']['user'][0]['supplay']=$supplay;
        //
        // setup PayPal api context
        $this->_api_context->setConfig($this->config->item('settings'));


// ### Payer
// A resource representing a Payer that funds a payment
// For direct credit card payments, set payment method
// to 'credit_card' and add an array of funding instruments.

        $payer['payment_method'] = 'paypal';

// ### Itemized information
// (Optional) Lets you specify item wise
// information

        $item1["name"] = $this->input->post('user_number');
        $item1["sku"] = $this->input->post('item_number');  // Similar to `item_number` in Classic API
        $item1["description"] = $this->input->post('item_description');
        $item1["currency"] = "ILS";
        $item1["quantity"] = 1;
        $item1["price"] = $this->input->post('item_price');

        $itemList = new ItemList();
        $itemList->setItems(array($item1));

// ### Additional payment details
// Use this optional field to set additional
// payment information such as tax, shipping
// charges etc.
        $details['tax'] = $this->input->post('details_tax');
        $details['subtotal'] = $this->input->post('details_subtotal');
// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
        $amount['currency'] = "ILS";
        $amount['total'] = $details['subtotal'];
        $amount['details'] = $details;
// ### Transaction
// A transaction defines the contract of a
// payment - what is the payment for and who
// is fulfilling it.
        $transaction['description'] = 'Payment description';
        $transaction['amount'] = $amount;
        $transaction['invoice_number'] = uniqid();
        $transaction['item_list'] = $itemList;
//$transaction['supplay'] = $supplay;
// ### Redirect urls
// Set the urls that the buyer must be redirected to after
// payment approval/ cancellation.
        $baseUrl = base_url();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($baseUrl . "index.php/Paypal_controller/getPaymentStatus")
                ->setCancelUrl($baseUrl . "index.php/Paypal_controller/getPaymentStatus");

// ### Payment
// A Payment Resource; create one using
// the above types and intent set to sale 'sale'
        $payment = new Payment();
        $payment->setIntent("sale")
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (Exception $ex) {
// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
//ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $ex);
            echo ("faild");
            echo $ex;
            exit(1);
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        if (isset($redirect_url)) {
            /** redirect to paypal * */
            redirect($redirect_url);
        }

        $this->session->set_flashdata('success_msg', 'Unknown error occurred');
        redirect('Paypal_controller/index');
    }

    public function getPaymentStatus() {


        // paypal credentials

        /** Get the payment ID before session clear * */
        $data['user'] = $this->session->all_userdata();

        $user_number = $data ['user']['user'][0]['user_number'];

// paypal credentials

        /** Get the payment ID before session clear * */
        $payment_id = $this->input->get("paymentId");
        $PayerID = $this->input->get("PayerID");
        $token = $this->input->get("token");
        /** clear the session payment ID * */
        if (empty($PayerID) || empty($token)) {
            $this->session->set_flashdata('success_msg', 'Payment failed');
            redirect('Paypal_controller/cancel');
        }

        $payment = Payment::get($payment_id, $this->_api_context);


        /** PaymentExecution object includes information necessary * */
        /** to execute a PayPal account payment. * */
        /** The payer_id is added to the request query parameters * */
        /** when the user is redirected from paypal back to your site * */
        $execution = new PaymentExecution();
        $execution->setPayerId($this->input->get('PayerID'));

        /*         * Execute the payment * */
        $result = $payment->execute($execution, $this->_api_context);


//  DEBUG RESULT, remove it later **/
        if ($result->getState() == 'approved') {
            $trans = $result->getTransactions();

// item info
            $Subtotal = $trans[0]->getAmount()->getDetails()->getSubtotal();
            $Tax = $trans[0]->getAmount()->getDetails()->getTax();

            $payer = $result->getPayer();
// payer info //
            $PaymentMethod = $payer->getPaymentMethod();
            $PayerStatus = $payer->getStatus();
            $PayerMail = $payer->getPayerInfo()->getEmail();

            $relatedResources = $trans[0]->getRelatedResources();
            $sale = $relatedResources[0]->getSale();
// sale info //
            $saleId = $sale->getId();
            $CreateTime = $sale->getCreateTime();
            $UpdateTime = $sale->getUpdateTime();
            $State = $sale->getState();
            $Total = $sale->getAmount()->getTotal();
            //$data['user'] = $this->session->all_userdata();
            $supply = $_SESSION['supplay'];

            /** it's all right * */
            /** Here Write your database logic like that insert record or value in database if you want * */
            $this->paypal->create($user_number, $Total, $Subtotal, $Tax, $PaymentMethod, $PayerStatus, $PayerMail, $saleId, $CreateTime, $UpdateTime, $State, $supply);
            $this->session->set_flashdata('success_msg', 'Payment success');

            $data['last_order'] = $this->Paypal_model->get_last_row_from_payments_table();
            $data['costumer_order'] = $this->Paypal_model->insert_to_db_costumers_orders($data['last_order']);
            $this->Paypal_model->update_table_products_in_costumer_order($data['last_order']);
            $this->Cart_model->remove_after_order('all');

            $this->send_email($Subtotal, $supply);
            redirect('Paypal_controller/success');
            
        }
        $this->session->set_flashdata('success_msg', 'Payment failed');

        redirect('Paypal_controller/cancel');
    }

    public function success() {
        $data['title'] = "סטטוס הזמנה";
        $data['user'] = $this->session->all_userdata();
        $data['last_order'] = $this->Paypal_model->get_last_row_from_payments_table();

        $this->load->view('templates/header', $data);
        $this->load->view("paypal/success", $data);
        $this->load->view('templates/footer');
    }

    public function cancel() {
        $data['title'] = "סטטוס הזמנה";
        $data['user'] = $this->session->all_userdata();

        $this->load->view('templates/header', $data);
        $this->load->view("paypal/cancel", $data);
        $this->load->view('templates/footer');
    }
    
      public function send_email($total, $supply) {
        
        $data['last_order'] = $this->Paypal_model->get_last_row_from_payments_table();
        $order_number=$data['last_order']['order_number'];
        $to = $email;
        $subject = "הזמנתך באתר A.t System התקבלה בתאריך: " . date('d-m-Y');

        $message = "
<html>
<head>

</head>
<body>
<p>הזמנה התקבלה ואושרה במערכת בהצלחה </p>
<p>מספר ההזמנה: ". $order_number+1 . "</p>
<p>סך ההזמנה הכוללת : " .$total ." שקלים.</p>
<p>תודה שרכשת A.t System </p>

</body>
</html>
";

        // Always set content-type when sending HTML email
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


// More headers
        $headers .= 'From:business.a.t.system@gmail.com';
        
      

        mail($to, $subject, $message, $headers);

       
    }


}
