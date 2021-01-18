<?php

/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2020 osCommerce

  Released under the GNU General Public License
 */

chdir('../../../../');
require 'includes/application_top.php';

echo '<pre>';
print_r($_REQUEST);
echo '</pre>';

\Ease\WebPage::getRequestValue('payId');
\Ease\WebPage::getRequestValue('dttm');

$merchantData = json_decode(base64_decode(\Ease\WebPage::getRequestValue('merchantData')), 'true');
$paymentStatus = \Ease\WebPage::getRequestValue('paymentStatus','int');
$resultCode = \Ease\WebPage::getRequestValue('resultCode','int');

$customer_id = $merchantData['customerId'];

// load the selected payment module
$payment_modules = new payment($merchantData['payment']);

$order = new order($merchantData['orderId']);

$payment_modules->update_status();

if (( is_array($payment_modules->modules) && (count($payment_modules->modules) > 1) && !is_object(${$_SESSION['payment']}) ) || (is_object(${$_SESSION['payment']}) && (${$_SESSION['payment']}->enabled == false))) {
    tep_redirect(tep_href_link('checkout_payment.php', 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));
}

if (is_array($payment_modules->modules)) {
    $payment_modules->pre_confirmation_check();
}

switch ($resultCode) {
    case 0:
        switch ($paymentStatus) {
            case '4':
                $order->info['order_status'] = MODULE_PAYMENT_CSOB_DONE_ORDER_STATUS_ID;
                tep_db_query("UPDATE orders SET orders_status = " . (int)$order->info['order_status'] . ", last_modified = NOW() WHERE orders_id = " . (int)$order->get_id());
                tep_redirect(tep_href_link('checkout_success.php','', 'SSL'));
                break;
            case '':
                break;
            case '':
                break;
            case '':
                break;

            default:
                //TODO https://github.com/csob/paymentgateway/wiki/Pr%C5%AFb%C4%9Bh-platby#trx-life-cycle
                throw new Exception('Unknown payment status');
                break;
        }


        tep_redirect(tep_href_link('checkout_payment.php', 'payment_error=' . 'csob' . '&error=' . $resultCode));

        break;
    default:
        //     $order->info['order_status'] = MODULE_PAYMENT_CSOB_ORDER_STATUS_ID;


        break;
}


