<?php
/*
 $Id$

 osCommerce, Open Source E-Commerce Solutions
 http://www.oscommerce.com

 Copyright (c) 2020 osCommerce

 Released under the GNU General Public License
 */

  class cd_company_number extends abstract_customer_data_module {

    const CONFIG_KEY_BASE = 'MODULE_CUSTOMER_DATA_COMPANY_NUMBER_';

    const PROVIDES = [ 'company_number' ];
    const REQUIRES = [  ];

    protected function get_parameters() {
      return [
        static::CONFIG_KEY_BASE . 'STATUS' => [
          'title' => 'Enable Company Number module',
          'value' => 'True',
          'desc' => 'Do you want to add the module to your shop?',
          'set_func' => "tep_cfg_select_option(['True', 'False'], ",
        ],
        static::CONFIG_KEY_BASE . 'GROUP' => [
          'title' => 'Customer data group',
          'value' => '3',
          'desc' => 'In what group should this appear?',
          'use_func' => 'tep_get_customer_data_group_title',
          'set_func' => 'tep_cfg_pull_down_customer_data_groups(',
        ],
        static::CONFIG_KEY_BASE . 'REQUIRED' => [
          'title' => 'Require Company Number module (if enabled)',
          'value' => 'True',
          'desc' => 'Do you want the company_number to be required in customer registration?',
          'set_func' => "tep_cfg_select_option(['True', 'False'], ",
        ],
        static::CONFIG_KEY_BASE . 'MIN_LENGTH' => [
          'title' => 'Minimum Length',
          'value' => '3',
          'desc' => 'Minimum length of company_number',
        ],
        static::CONFIG_KEY_BASE . 'PAGES' => [
          'title' => 'Pages',
          'value' => 'account_edit;create_account;customers',
          'desc' => 'On what pages should this appear?',
          'set_func' => 'tep_draw_account_edit_pages(',
          'use_func' => 'abstract_module::list_exploded',
        ],
        static::CONFIG_KEY_BASE . 'SORT_ORDER' => [
          'title' => 'Sort Order',
          'value' => '5500',
          'desc' => 'Sort order of display. Lowest is displayed first.',
        ],
        static::CONFIG_KEY_BASE . 'TEMPLATE' => [
          'title' => 'Template',
          'value' => 'includes/modules/customer_data/cd_whole_row_input.php',
          'desc' => 'What template should be used to surround this input?',
        ],
      ];
    }

    public function get($field, &$customer_details) {
      switch ($field) {
        case 'company_number':
          if (!isset($customer_details[$field])) {
            $customer_details[$field] = $customer_details['company_number']
              ?? $customer_details['customers_company_number'] ?? null;
          }
          return $customer_details[$field];
      }
    }

    public function display_input($customer_details = null) {
      $label_text = ENTRY_COMPANY_NUMBER;

      $input_id = 'inputVatNumber';
      $attribute = 'id="' . $input_id . '" autocomplete="tel" placeholder="' . ENTRY_COMPANY_NUMBER_TEXT . '"';
      $postInput = '';
      if ($this->is_required()) {
        $attribute = self::REQUIRED_ATTRIBUTE . $attribute;
        $postInput = FORM_REQUIRED_INPUT;
      }

      $company_number = null;
      if (!empty($customer_details) && is_array($customer_details)) {
        $company_number = $this->get('company_number', $customer_details);
      }

      $input = tep_draw_input_field('company_number', $company_number, $attribute)
             . $postInput;

      include $GLOBALS['oscTemplate']->map_to_template(MODULE_CUSTOMER_DATA_COMPANY_NUMBER_TEMPLATE);
    }

    public function process(&$customer_details) {
      $customer_details['company_number'] = tep_db_prepare_input($_POST['company_number']);

      if (strlen($customer_details['company_number']) < MODULE_CUSTOMER_DATA_COMPANY_NUMBER_MIN_LENGTH
        && ($this->is_required()
          || !empty($customer_details['company_number'])
          )
        )
      {
        $GLOBALS['messageStack']->add_classed(
          $GLOBALS['message_stack_area'] ?? 'customer_data',
          sprintf(ENTRY_COMPANY_NUMBER_ERROR, MODULE_CUSTOMER_DATA_COMPANY_NUMBER_MIN_LENGTH));

        return false;
      }

      return true;
    }

    public function build_db_values(&$db_tables, $customer_details, $table = 'both') {
      tep_guarantee_subarray($db_tables, 'customers');
      $db_tables['customers']['customers_company_number'] = $customer_details['company_number'];
    }

    public function build_db_aliases(&$db_tables, $table = 'both') {
      tep_guarantee_subarray($db_tables, 'customers');
      $db_tables['customers']['customers_company_number'] = 'company_number';
    }

  }
