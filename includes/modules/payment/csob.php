<?php

use Ease\Functions;
use Ease\WebPage;

/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2020 osCommerce

  Released under the GNU General Public License
 */


require_once DIR_FS_CATALOG . '/ext/modules/payment/csob/crypto.php';

/**
 * Description of csob
 *
 * @author vitex
 */
class csob extends abstract_payment_module {

    const CONFIG_KEY_BASE = 'MODULE_PAYMENT_CSOB_';

    private $lastMessage = '';
    public $url = 'https://iapi.iplatebnibrana.csob.cz/api/v1.8';

    public function __construct() {
        parent::__construct();

        //$this->signature = 'purehtml|csob|2.3';
        $this->api_version = '1.8';

        $this->public_title = MODULE_PAYMENT_CSOB_TEXT_TITLE;
        $this->sort_order = $this->sort_order ?? 0;
//        $this->order_status = defined('MODULE_PAYMENT_CSOB_PREPARE_ORDER_STATUS_ID') && ((int) MODULE_PAYMENT_CSOB_PREPARE_ORDER_STATUS_ID > 0) ? (int) MODULE_PAYMENT_CSOB_PREPARE_ORDER_STATUS_ID : 0;

        $this->sort_order = defined('MODULE_PAYMENT_CSOB_SORT_ORDER') ? MODULE_PAYMENT_CSOB_SORT_ORDER : 0;

        $this->order_status = defined('MODULE_PAYMENT_CSOB_PREPARE_ORDER_STATUS_ID') && ((int) MODULE_PAYMENT_CSOB_PREPARE_ORDER_STATUS_ID > 0) ? (int) MODULE_PAYMENT_CSOB_PREPARE_ORDER_STATUS_ID : 0;

        $exts = array_filter(['xmlwriter', 'SimpleXML', 'openssl', 'dom', 'hash', 'curl'], function ($extension) {
            return !extension_loaded($extension);
        });

        $csob_error = null;
        if (!empty($exts)) {
            $csob_error = sprintf(MODULE_PAYMENT_CSOB_ERROR_ADMIN_PHP_EXTENSIONS, implode('<br>', $exts));
        }

        if (!isset($csob_error) && defined('MODULE_PAYMENT_CSOB_STATUS')) {
            if (!tep_not_null(MODULE_PAYMENT_CSOB_MERCHANT_ID) || !tep_not_null(MODULE_PAYMENT_CSOB_PUBLIC_KEY) || !tep_not_null(MODULE_PAYMENT_CSOB_SECRET_KEY) || !tep_not_null(MODULE_PAYMENT_CSOB_PUBLIC_KEY)) {
                $csob_error = MODULE_PAYMENT_CSOB_ERROR_ADMIN_CONFIGURATION;
            }
        }

        if (!isset($csob_error) && defined('MODULE_PAYMENT_CSOB_STATUS')) {
            
        }

        if (isset($csob_error)) {
            $this->description = '<div class="alert alert-warning">' . $csob_error . '</div>' . $this->description;

            $this->enabled = false;
        }
    }

    private function prepare_payment() {
        global $order;
        $order_id = $order->get_id();

        $lang_query = tep_db_query("SELECT code FROM languages WHERE languages_id = " . (int) $_SESSION['languages_id']);
        $lang = tep_db_fetch_array($lang_query);

//        tep_draw_hidden_field('cartId', $order_id)
//                . tep_draw_hidden_field('amount', $this->format_raw($order->info['total']))
//                . tep_draw_hidden_field('currency', $_SESSION['currency'])
//                . tep_draw_hidden_field('desc', STORE_NAME)
//                . tep_draw_hidden_field('name', $order->billing['name'])
//                . tep_draw_hidden_field('address1', $order->billing['street_address'])
//                . tep_draw_hidden_field('town', $order->billing['city'])
//                . tep_draw_hidden_field('region', $order->billing['state'])
//                . tep_draw_hidden_field('postcode', $order->billing['postcode'])
//                . tep_draw_hidden_field('country', $order->billing['country']['iso_code_2'])
//                . tep_draw_hidden_field('tel', $order->customer['telephone'])
//                . tep_draw_hidden_field('email', $order->customer['email_address'])
//                . tep_draw_hidden_field('fixContact', 'Y')
//                . tep_draw_hidden_field('hideCurrency', 'true')
//                . tep_draw_hidden_field('lang', strtoupper($lang['code']))
//                . tep_draw_hidden_field('signatureFields', 'amount:currency:cartId')
//                . tep_draw_hidden_field('signature', md5(MODULE_PAYMENT_CSOB_MD5_PASSWORD . ':' . $this->format_raw($order->info['total']) . ':' . $_SESSION['currency'] . ':' . $order_id))
//                . tep_draw_hidden_field('MC_callback', tep_href_link('ext/modules/payment/rbsworldpay/hosted_callback.php', '', 'SSL', false))
//                . tep_draw_hidden_field('M_sid', session_id())
//                . tep_draw_hidden_field('M_cid', $_SESSION['customer_id'])
//                . tep_draw_hidden_field('M_lang', $_SESSION['language'])
//                . tep_draw_hidden_field('M_hash', build_hash($order_id));

        $merchantId = Functions::cfg('MODULE_PAYMENT_CSOB_MERCHANT_ID');
        $privateKey = Functions::cfg('MODULE_PAYMENT_CSOB_SECRET_KEY');
        $publicKey = Functions::cfg('MODULE_PAYMENT_CSOB_PUBLIC_KEY');
        $privateKeyPassword = null;
        $orderNo = $order->get_id();
        $totalAmount = $order->totals[2]['value'];
        $shippingAmount = $order->totals[1]['value'];
        $returnUrl = tep_href_link('ext/modules/payment/csob/welcomeback.php', '', null, true);

        $goods_desc = '';
        foreach ($order->products as $product) {
            $goods_desc .= $product['name'] . ' ';
        }
        $customerId = $order->customer['customers_id'];
        $returnMethodPOST = "yes";
        $returnMethodPOST = "no";
        $closePayment = false;
        $merchantData = base64_encode(json_encode(['orderId' => $order_id, 'customerId' => $customerId, 'payment' => $_SESSION['payment']]));
        if (!array_key_exists($order->info['currency'], Constants::$CURRENCY)) {
            throw new Exception('Unsupported currency');
        }
        $currency = $order->info['currency'];

        if ($lang['code'] == 'cs') {
            $lang['code'] = 'cz';
        }

        if (!array_key_exists(strtoupper($lang['code']), Constants::$LANGUAGE)) {
            throw new Exception('Unsupported language');
        }
        $language = strtoupper($lang['code']);

        $dttm = (new DateTime ())->format("YmdHis");

        $cart = createCartData($goods_desc, $totalAmount, $shippingAmount);
        //echo "preparing cart data:\n";
        //echo htmlspecialchars(json_encode($cart, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE)) . "\n\n";

        $data = createPaymentInitData($merchantId, $orderNo, $dttm, $totalAmount, $returnUrl, $cart, $customerId, $privateKey, $privateKeyPassword, $closePayment, $merchantData, $returnMethodPOST, $currency, $language);

        //echo "prepared payment/init request:\n";
        //echo htmlspecialchars(json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE)) . "\n\n";
        //echo "processing payment/init request ...\n\n";

        $ch = curl_init($this->url . NativeApiMethod::$init);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json;charset=UTF-8'
        ));

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'payment/init failed, reason: ' . htmlspecialchars(curl_error($ch));
            return;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode != 200) {
            echo 'payment/init failed, http response: ' . htmlspecialchars($httpCode);
            return;
        }

        curl_close($ch);

        //   echo "payment/init result:\n" . htmlspecialchars($result) . "\n\n";
//        $order->set_status('WAIT FOR PAYMENT');

        $result_array = json_decode($result, true);
        if (is_null($result_array ['resultCode'])) {
            echo 'payment/init failed, missing resultCode';
            return;
        } else {
            $paymentSuccessful = false;
            $this->lastMessage = $result_array['resultMessage'];
            $_SESSION['csob_error'] = $result_array['resultMessage'];
            if ($result_array ['resultCode'] != 0) {
                tep_redirect(tep_href_link('checkout_payment.php', 'payment_error=' . 'csob' . '&error=' . $result_array['resultCode']));
            }
        }

        if (verifyResponse($result_array, $publicKey, "payment/init verify") == false) {
            $_SESSION['csob_error'] = 'payment/init failed, unable to verify signature ';
            tep_redirect(tep_href_link('checkout_payment.php', 'payment_error=' . 'csob'));
        }

        $payId = $result_array ['payId'];
        $params = createGetParams($merchantId, $payId, $dttm, $privateKey, $privateKeyPassword);

        tep_redirect(htmlspecialchars($this->url . NativeApiMethod::$process . $params, ENT_QUOTES));
    }

    static public function resultCode($code) {
        switch ($code) {
            case 0:
                $error = 'OK'; //(operace proběhla korektně, transakce založena, stav aktualizován apod.)
                break;
            case 100:
                $error = 'Missing parameter {name}'; // (chybějící povinný parametr)
                break;
            case 110 :
                $error = 'Invalid parameter {name} '; //(chybný formát parametru)
                break;
            case 120:
                $error = 'Merchant blocked'; // (obchodník nemá povoleny platby)
                break;
            case 130:
                $error = 'Session expired'; //(vypršela platnost požadavku)
                break;
            case 140:
                $error = 'Payment not found'; // (platba nenalezena)
                break;
            case 150:
                $error = 'Payment not in valid state'; //(nesprávný stav platby, operaci nelze provést)
                break;
            case 160:
                $error = 'Payment method disabled'; //(operace není povolena, obchodník si o nastavení musí smluvně zažádat) 
                break;
            case 170:
                $error = 'Payment method unavailable'; //(nedostupost poskytovatele metody, služba není v tomto čase dosažitelná)
                break;
            case 180:
                $error = 'Operation not allowed'; //(nepovolená operace)
                break;
            case 190:
                $error = 'Payment method error'; //(chyba ve zpracování u poskytovatele metody)
                break;
            case 230:
                $error = 'Merchant not onboarded for MasterPass'; // (obchodník není registrovaný v MasterPass)
                break;
            case 240:
                $error = 'MasterPass request token already initialized'; // (MasterPass token byl již inicializován)
                break;
            case 250:
                $error = 'MasterPass request token does not exist'; // (nenalezen MasterPass token, nelze dokončit platbu pomocí MasterPass)
                break;
            case 270:
                $error = 'MasterPass canceled by user'; // (zákazník nedokončil výběr karty/adresy v MasterPass wallet)
                break;
            case 500:
                $error = 'EET Rejected'; //(EET hlášení bylo odmítnuto FS)
                break;
            case 600:
                $error = 'MALL Pay payment declined in precheck'; //operaci mallpay/init nelze dokončit z důvodu zamítnutí žádosti v systému MALL Pay
                break;
            case 700:
                $error = 'Oneclick template not found'; //(šablona pro platbu na klik nebyla nalezena)
                break;
            case 710:
                $error = 'Oneclick template payment expired'; //(šablona pro platbu nebyla použita více jak 12 měsíců, platba expirovala)
                break;
            case 720:
                $error = 'Oneclick template card expired'; //(karta pro šablonu pro platbu na klik expirovala)
                break;
            case 730:
                $error = 'Oneclick template customer rejected'; // (šablona pro platbu na klik byla zrušena na pokyn zákazníka)
                break;
            case 740:
                $error = 'Oneclick template payment reversed'; //(šablona pro platbu na klik byla reverzována)
                break;
            case 800:
                $error = 'Customer not found'; //(zákazník identifikovaný pomocí customerId nenalezen)
                break;
            case 810:
                $error = 'Customer found, no saved card(s)'; //(zákazník identifikovaný pomocí customerId byl nalezen, ale nemá žádné dříve uložené karty na platební bráně)
                break;
            case 820:
                $error = 'Customer found, found saved card(s)'; //(zákazník identifikovaný pomocí customerId byl nalezen a má uložené karty na platební bráně)
                break;
            case 900:
                $error = 'Internal error'; // (interní chyba ve zpracování požadavku)
                break;
            default:
                throw new Exception('Unknown Payment response code: ' . $result_array['resultCode']);
                break;
        }
        return $error;
    }

    /**
     * Update payment status
     *  
     * @return null
     */
    public function update_status() {
        if (!$this->enabled || !isset($GLOBALS['order'])) {
            return;
        }

        // disable the module if the order only contains virtual products
        if ('virtual' === $GLOBALS['order']->content_type) {
            $this->enabled = false;
            return;
        }

        if (isset($GLOBALS['order']->delivery['country']['id'])) {
            $this->update_status_by($GLOBALS['order']->delivery);
        }
    }

    public function pre_confirmation_check() {
        return false;
    }

    public function confirmation() {
        return false;
    }

    public function process_button() {
        return false;
    }

    public function before_process() {
        global $order;
            $order->info['order_status'] = MODULE_PAYMENT_CSOB_ORDER_STATUS_ID;

        switch (WebPage::getRequestValue('resultCode')) {
            case '0':
            default:
                $order->info['order_status'] = MODULE_PAYMENT_CSOB_PROBLEM_ORDER_STATUS_ID;
                break;
        }
        
        tep_db_query("UPDATE orders SET orders_status = " . (int) $order->info['order_status'] . ", last_modified = NOW() WHERE orders_id = " . (int) $order->get_id());

        return true;
    }

    public function after_process() {
        $this->prepare_payment();
        return $this->success;
    }

    public function get_error() {
        global $order;
        $message = MODULE_PAYMENT_CSOB_ERROR_GENERAL;

        if (isset($_SESSION['csob_error'])) {
            $message = $_SESSION['csob_error'] . ' ' . $message;
            unset($_SESSION['csob_error']);
        } else {
            if (!empty($_GET['error'])) {
                $message .= "\n" . self::resultCode($_GET['error']) . "\n";
            }
        }
        
        
        $nextOrderid = current(tep_db_fetch_array(tep_db_query('SELECT MAX(orders_id) FROM orders')))+1;        
        
        tep_db_query("UPDATE orders SET orders_id = " . (int) $nextorderid . ", last_modified = NOW() WHERE orders_id = " . (int) $order->get_id());
        $order->info['orders_id'] = $nextOrderid;
        
        $error = [
            'title' => MODULE_PAYMENT_CSOB_ERROR_TITLE,
            'error' => $message,
        ];

        return $error;
    }

    /**
     * Payment method configuration keys definitoin
     * 
     * @return array
     */
    protected function get_parameters() {
        return [
            'MODULE_PAYMENT_CSOB_STATUS' => [
                'title' => 'Enable CSOB Payment gateway Module',
                'value' => 'True',
                'desc' => 'Do you want to accept CSOB Payment gateway payments?',
                'set_func' => "tep_cfg_select_option(['True', 'False'], ",
            ],
            'MODULE_PAYMENT_CSOB_ZONE' => [
                'title' => 'Payment Zone',
                'value' => '0',
                'desc' => 'If a zone is selected, only enable this payment method for that zone.',
                'use_func' => 'tep_get_zone_class_title',
                'set_func' => 'tep_cfg_pull_down_zone_classes(',
            ],
            'MODULE_PAYMENT_CSOB_SORT_ORDER' => [
                'title' => 'Sort order of display.',
                'value' => '0',
                'desc' => 'Sort order of display. Lowest is displayed first.',
            ],
            'MODULE_PAYMENT_CSOB_ORDER_STATUS_ID' => [
                'title' => 'Set Order Status',
                'value' => self::ensure_order_status('MODULE_PAYMENT_CSOB_PROCESSING_ORDER_STATUS_ID', 'Card payment pending'),
                'desc' => 'Set the status of orders made with this payment module to this value',
                'set_func' => 'tep_cfg_pull_down_order_statuses(',
                'use_func' => 'tep_get_order_status_name',
            ],
            'MODULE_PAYMENT_CSOB_MERCHANT_ID' => [
                'title' => _('Your merchant id'),
                'value' => '00000000',
                'desc' => _('Your merchant unique identifier (supplied by csob)')
            ],
            'MODULE_PAYMENT_CSOB_SECRET_KEY' => [
                'title' => _('Your secret key'),
                'desc' => _('Your secret key (supplied by csob on https://platebnibrana.csob.cz/keygen/)')
            ],
            'MODULE_PAYMENT_CSOB_PUBLIC_KEY' => [
                'title' => _('Your public key'),
                'value' => 'mips_iplatebnibrana.csob.cz.pub',
                'desc' => _('Your public key (supplied by csob)')
            ],
            'MODULE_PAYMENT_CSOB_PROCESSING_ORDER_STATUS_ID' => [
                'title' => 'Wait for payment Order Status',
                'desc' => 'Include transaction information in this order status level',
                'value' => self::ensure_order_status('MODULE_PAYMENT_CSOB_PROCESSING_ORDER_STATUS_ID', 'Card payment pending'),
                'set_func' => 'tep_cfg_pull_down_order_statuses(',
                'use_func' => 'tep_get_order_status_name',
            ],
            'MODULE_PAYMENT_CSOB_DONE_ORDER_STATUS_ID' => [
                'title' => 'All OK settled payment Order Status',
                'desc' => 'Include transaction information in this order status level',
                'value' => self::ensure_order_status('MODULE_PAYMENT_CSOB_DONE_ORDER_STATUS_ID', 'Settled by Card'),
                'set_func' => 'tep_cfg_pull_down_order_statuses(',
                'use_func' => 'tep_get_order_status_name',
            ],
            'MODULE_PAYMENT_CSOB_PROBLEM_ORDER_STATUS_ID' => [
                'title' => 'Card payment problem Order Status',
                'desc' => 'Include transaction information in this order status level',
                'value' => self::ensure_order_status('MODULE_PAYMENT_CSOB_PROBLEM_ORDER_STATUS_ID', 'Card payment problem'),
                'set_func' => 'tep_cfg_pull_down_order_statuses(',
                'use_func' => 'tep_get_order_status_name',
            ],
        ];
    }

}
