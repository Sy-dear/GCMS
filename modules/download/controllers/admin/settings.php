<?php
/**
 * @filesource modules/download/controllers/admin/settings.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Download\Admin\Settings;

use Gcms\Gcms;
use Gcms\Login;
use Kotchasan\Html;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * module=download-settings
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Gcms\Controller
{
    /**
     * จัดการการตั้งค่า
     *
     * @param Request $request
     *
     * @return string
     */
    public function render(Request $request)
    {
        // ข้อความ title bar
        $this->title = Language::trans('{LNG_Module settings} {LNG_Download}');
        // เลือกเมนู
        $this->menu = 'modules';
        // อ่านข้อมูลโมดูล และ config
        $index = \Index\Adminmodule\Model::getModuleWithConfig('download', $request->request('mid')->toInt());
        // admin
        $login = Login::adminAccess();
        // can_config หรือ สมาชิกตัวอย่าง
        if ($index && $login && (Gcms::canConfig($login, $index, 'can_config') || !Login::notDemoMode($login))) {
            // แสดงผล
            $section = Html::create('section');
            // breadcrumbs
            $breadcrumbs = $section->add('div', array(
                'class' => 'breadcrumbs'
            ));
            $ul = $breadcrumbs->add('ul');
            $ul->appendChild('<li><span class="icon-download">{LNG_Module}</span></li>');
            $ul->appendChild('<li><span>'.ucfirst($index->module).'</span></li>');
            $ul->appendChild('<li><span>{LNG_Settings}</span></li>');
            $section->add('header', array(
                'innerHTML' => '<h2 class="icon-config">'.$this->title.'</h2>'
            ));
            // แสดงฟอร์ม
            $section->appendChild(\Download\Admin\Settings\View::create()->render($request, $index));
            return $section->render();
        }
        // 404.html
        return \Index\Error\Controller::page404();
    }
}
