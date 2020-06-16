<?php
/** set your paypal credential **/

$config['client_id'] = 'AV_aE7HSn4lmy3TuOU0xA_ZknSPgWrylTXaLuFxdoethu6fkvPzd4-bnrhFKbgPJSjlIvXQsLtJkP2cU';
$config['secret'] = 'EEXPb5lFUnhW1vDpSetpaTKgG1g0T4PZghT-rgSIBztijrwKQ3NhN4ocL2huOJsRRsHSySLtZ7cjlvvV';

/**
 * SDK configuration
 */
/**
 * Available option 'sandbox' or 'live'
 */
$config['settings'] = array(

    'mode' => 'sandbox',
    /**
     * Specify the max request time in seconds
     */
    'http.ConnectionTimeOut' => 1000,
    /**
     * Whether want to log to a file
     */
    'log.LogEnabled' => true,
    /**
     * Specify the file that want to write on
     */
    'log.FileName' => 'application/logs/paypal.log',
    /**
     * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
     *
     * Logging is most verbose in the 'FINE' level and decreases as you
     * proceed towards ERROR
     */
    'log.LogLevel' => 'FINE'
);
