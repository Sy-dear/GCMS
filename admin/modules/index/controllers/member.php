<?php
/**
 * @filesource modules/index/controllers/member.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Index\Member;

use Gcms\Login;
use Kotchasan\Html;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * module=member
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Gcms\Controller
{
    /**
     * รายชื่อสมาชิก
     *
     * @param Request $request
     *
     * @return string
     */
    public function render(Request $request)
    {
        // ข้อความ title bar
        $this->title = Language::get('Member list');
        // เลือกเมนู
        $this->menu = 'users';
        // แอดมิน, ไม่ใช่สมาชิกตัวอย่าง
        if (Login::notDemoMode(Login::isAdmin())) {
            // แสดงผล
            $section = Html::create('section');
            // breadcrumbs
            $breadcrumbs = $section->add('div', array(
                'class' => 'breadcrumbs'
            ));
            $ul = $breadcrumbs->add('ul');
            $ul->appendChild('<li><span class="icon-user">{LNG_Users}</span></li>');
            $ul->appendChild('<li><span>'.$this->title().'</span></li>');
            $section->add('header', array(
                'innerHTML' => '<h2 class="icon-users">'.$this->title.'</h2>'
            ));
            // แสดงตาราง
            $section->appendChild(\Index\Member\View::create()->render($request));
            // คืนค่า HTML
            return $section->render();
        }
        // 404.html
        return \Index\Error\Controller::page404();
    }
}
