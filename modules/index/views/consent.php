<?php
/**
 * @filesource modules/index/views/consent.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Index\Consent;

use Gcms\Gcms;
use Kotchasan\Html;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * PDPA Consent
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\View
{
    /**
     * แสดง PDPA Consent
     *
     * @param Request $request
     *
     * @return object
     */
    public function render(Request $request)
    {
        $form = Html::create('form', array(
            'id' => 'consent_frm',
            'class' => 'consent_frm',
            'autocomplete' => 'off',
            'action' => 'index.php/index/model/consent/submit',
            'onsubmit' => 'doFormSubmit',
            'ajax' => true,
            'token' => true
        ));
        $form->add('header', array(
            'innerHTML' => '<h2>{LNG_Cookie Policy}</h2>'
        ));
        $fieldset = $form->add('fieldset');
        $fieldset->add('aside', array(
            'innerHTML' => '{LNG_COOKIE_POLICY_DETAILS}'
        ));
        $fieldset = $form->add('fieldset', array(
            'class' => 'info'
        ));
        $fieldset->add('div', array(
            'class' => 'table fullwidth collapse',
            'innerHTML' => '<span class=td>{LNG_Necessary cookies}</span><span class="td right color-orange">{LNG_Always enabled}</span>'
        ));
        $fieldset->add('aside', array(
            'innerHTML' => '{LNG_COOKIE_NECESSARY_DETAILS}'
        ));
        $fieldset = $form->add('fieldset', array(
            'class' => 'submit right'
        ));
        if (!empty(self::$cfg->privacy_module)) {
            $fieldset->add('a', array(
                'href' => Gcms::createUrl(self::$cfg->privacy_module),
                'innerHTML' => '{LNG_Privacy Policy}'
            ));
        }
        // submit
        $fieldset->add('submit', array(
            'class' => 'button orange large',
            'value' => '{LNG_Accept all}'
        ));
        // คืนค่า HTML
        return Language::trans($form->render());
    }
}
