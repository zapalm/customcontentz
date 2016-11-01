<?php
/**
 * Custom contents: module for PrestaShop 1.5-1.6
 *
 * @author    zapalm <zapalm@ya.ru>
 * @copyright 2011-2016 zapalm
 * @link      http://prestashop.modulez.ru/en/frontend-features/42-custom-contents.html The module's homepage
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_'))
    exit;

class CustomContentz extends Module
{
    function __construct() {
        $this->name          = 'customcontentz';
        $this->version       = '0.9.0';
        $this->tab           = 'front_office_features';
        $this->author        = 'zapalm';
        $this->need_instance = 0;
        $this->bootstrap     = false;

        parent::__construct();

        $this->displayName  = $this->l('Custom contents');
        $this->description  = $this->l('Allows to append a static text to a different places of a site.');
    }

    function install() {
        return parent::install()
            && $this->registerHook('header')
            && $this->registerHook('home')
            && $this->registerHook('top')
            && $this->registerHook('footer')
            && Configuration::updateValue('CUSTOMCONTENTZ_CAT_FOOTER_TEXT','')
            && Configuration::updateValue('CUSTOMCONTENTZ_HOME_TEXT', '')
            && Configuration::updateValue('CUSTOMCONTENTZ_TOP_TEXT', '');
    }

    public function uninstall() {
        return parent::uninstall()
            && Configuration::deleteByName('CUSTOMCONTENTZ_CAT_FOOTER_TEXT')
            && Configuration::deleteByName('CUSTOMCONTENTZ_HOME_TEXT')
            && Configuration::deleteByName('CUSTOMCONTENTZ_TOP_TEXT');
    }

    public function getContent() {
        $output = '';

        if (Tools::isSubmit('submit_save')) {
            $res  = Configuration::updateValue('CUSTOMCONTENTZ_CAT_FOOTER_TEXT', Tools::getValue('CUSTOMCONTENTZ_CAT_FOOTER_TEXT'));
            $res &= Configuration::updateValue('CUSTOMCONTENTZ_CAT_DESC', (int)Tools::getValue('CUSTOMCONTENTZ_CAT_DESC'));
            $res &= Configuration::updateValue('CUSTOMCONTENTZ_HOME_TEXT', Tools::getValue('CUSTOMCONTENTZ_HOME_TEXT'));
            $res &= Configuration::updateValue('CUSTOMCONTENTZ_TOP_TEXT', Tools::getValue('CUSTOMCONTENTZ_TOP_TEXT'));

            $output .= ($res
                ? $this->displayConfirmation($this->l('Settings updated'))
                : $this->displayError($this->l('Some setting not updated'))
            );
        }

        $output .= '
            <fieldset style="width: 400px">
                <legend><img src="' . _PS_ADMIN_IMG_ . 'cog.gif" />' . $this->l('Settings') . '</legend>
                    <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
                        <label>' . $this->l('Input a text that will be display on the category footer') . ':</label>
                        <div class="margin-form">
                            <textarea cols=27 rows=5 name="CUSTOMCONTENTZ_CAT_FOOTER_TEXT">' . Configuration::get('CUSTOMCONTENTZ_CAT_FOOTER_TEXT') . '</textarea>
                        </div>

                        <label>' . $this->l('Prepend a category description to the text.') . '</label>
                        <div class="margin-form">
                            <input name="CUSTOMCONTENTZ_CAT_DESC" type="checkbox" value="1"' . (Configuration::get('CUSTOMCONTENTZ_CAT_DESC') ? 'checked="checked"' : '') . '>
                        </div>

                        <label>' . $this->l('Input a text that will be display on the homepage') . ':</label>
                        <div class="margin-form">
                            <textarea cols=27 rows=5 name="CUSTOMCONTENTZ_HOME_TEXT">' . Configuration::get('CUSTOMCONTENTZ_HOME_TEXT') . '</textarea>
                        </div>

                        <label>' . $this->l('Input a text that will be display on the top of the site') . ':</label>
                        <div class="margin-form">
                            <textarea cols=27 rows=5 name="CUSTOMCONTENTZ_TOP_TEXT">' . Configuration::get('CUSTOMCONTENTZ_TOP_TEXT') . '</textarea>
                        </div>

                        <center><input type="submit" name="submit_save" value="' . $this->l('Save') . '" class="button" /></center>
                    </form>
            </fieldset>
            <br class="clear">
        ';

        return $output;
    }

    public function hookHeader() {
        $this->context->controller->addCSS($this->_path . '/views/css/customcontentz.css');
    }

    function hookHome($params) {
        $this->context->smarty->assign(array(
            'place'                     => 'home',
            'CUSTOMCONTENTZ_HOME_TEXT'  => Configuration::get('CUSTOMCONTENTZ_HOME_TEXT'),
        ));

        return $this->display(__FILE__, '/views/templates/customcontentz.tpl');
    }

    function hookTop($params) {
        $this->context->smarty->assign(array(
            'place'                   => 'top',
            'CUSTOMCONTENTZ_TOP_TEXT' => Configuration::get('CUSTOMCONTENTZ_TOP_TEXT'),
        ));

        return $this->display(__FILE__, '/views/templates/customcontentz.tpl');
    }

    function hookFooter($params) {
        // display text on a category page only
        $categoryText = (string)Configuration::get('CUSTOMCONTENTZ_CAT_FOOTER_TEXT');
        if ($categoryText === '' || (int)Tools::getValue('id_category') <= 0) {
            return '';
        }

        if (Configuration::get('CUSTOMCONTENTZ_CAT_DESC')) {
            $category = new Category(Tools::getValue('id_category'), $this->context->language->id);
            $categoryText = strip_tags($category->description) . ' ' . $categoryText;
        }

        $this->context->smarty->assign(array(
            'place'                          => 'footer',
            'CUSTOMCONTENTZ_CAT_FOOTER_TEXT' => $categoryText,
        ));

        return $this->display(__FILE__, '/views/templates/customcontentz.tpl');
    }
}
