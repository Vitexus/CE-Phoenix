<?php

/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2020 osCommerce

  Released under the GNU General Public License
 */

class pi_hall extends abstract_module {

    const CONFIG_KEY_BASE = 'PI_HALL_';

    public $content_width;
    public $api_version;
    public $group;

    function __construct() {
        parent::__construct();
        $this->group = basename(dirname(__FILE__));

        $this->description .= '<div class="alert alert-warning">' . MODULE_CONTENT_BOOTSTRAP_ROW_DESCRIPTION . '</div>';
        $this->description .= '<div class="alert alert-info">' . $this->display_layout() . '</div>';

        if (defined('PI_HALL_STATUS')) {
            $this->group = 'pi_modules_' . strtolower(PI_HALL_GROUP);
            $this->content_width = (int) PI_HALL_CONTENT_WIDTH;
        }
    }

    function getOutput() {
        global $oscTemplate, $product_info;

        $content_width = $this->content_width;
        $thumbnail_width = PI_HALL_CONTENT_WIDTH_EACH;

        $pi_image = $pi_thumb = null;
        echo 'HALL';

        return new PureOSC\ui\Hall($product_info['product_name']);
    }

    function display_layout() {
        return new PureOSC\ui\Hall('Hall thumbnail');
    }

    protected function get_parameters() {
        return [
            'PI_HALL_STATUS' => [
                'title' => 'Enable HALL Module',
                'value' => 'True',
                'desc' => 'Should this module be shown on the product info page?',
                'set_func' => "tep_cfg_select_option(['True', 'False'], ",
            ],
            'PI_HALL_CONTENT_WIDTH' => [
                'title' => 'Content Width',
                'value' => '12',
                'desc' => 'What width container should the content be shown in?',
                'set_func' => "tep_cfg_select_option(['12', '11', '10', '9', '8', '7', '6', '5', '4', '3', '2', '1'], ",
            ],
            'PI_HALL_CONTENT_WIDTH_EACH' => [
                'title' => 'Thumbnail Width',
                'value' => 'col-4 col-sm-6 col-lg-4',
                'desc' => 'What width container should each thumbnail be shown in? Default:  XS 3 each row, SM/MD 2 each row, LG/XL 3 each row.',
            ],
            'PI_HALL_MODAL_SIZE' => [
                'title' => 'Modal Popup Size',
                'value' => 'modal-md',
                'desc' => 'Choose the size of the Popup.  sm = small, md = medium etc.',
                'set_func' => "tep_cfg_select_option(['modal-sm', 'modal-md', 'modal-lg', 'modal-xl'], ",
            ],
            'PI_HALL_SWIPE_ARROWS' => [
                'title' => 'Show Swipe Arrows',
                'value' => 'True',
                'desc' => 'Swipe Arrows make for a better User Experience in some cases.',
                'set_func' => "tep_cfg_select_option(['True', 'False'], ",
            ],
            'PI_HALL_INDICATORS' => [
                'title' => 'Show Indicators',
                'value' => 'True',
                'desc' => 'Indicators allow users to jump from image to image without having to swipe.',
                'set_func' => "tep_cfg_select_option(['True', 'False'], ",
            ],
            'PI_HALL_SORT_ORDER' => [
                'title' => 'Sort Order',
                'value' => '200',
                'desc' => 'Sort order of display. Lowest is displayed first.',
            ],
        ];
    }

}
