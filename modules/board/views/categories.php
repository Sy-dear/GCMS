<?php
/**
 * @filesource modules/board/views/categories.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Board\Categories;

use Gcms\Gcms;
use Kotchasan\Http\Request;
use Kotchasan\Template;

/**
 * แสดงรายการหมวดหมู่
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\View
{
    /**
     * แสดงรายการหมวดหมู่
     *
     * @param Request $request
     * @param object  $index   ข้อมูลโมดูล
     *
     * @return object
     */
    public function index(Request $request, $index)
    {
        // อ่านรายการหมวดหมู่ทั้งหมด
        $categories = \Index\Category\Model::all((int) $index->module_id);
        // categoryitem.html
        $listitem = Template::create('board', $index->module, 'categoryitem');
        // รายการ
        foreach ($categories as $item) {
            if (!empty($item->icon) && is_file(ROOT_PATH.DATA_FOLDER.'board/'.$item->icon)) {
                $icon = WEB_URL.DATA_FOLDER.'board/'.$item->icon;
            } else {
                $icon = WEB_URL.(isset($index->default_icon) ? $index->default_icon : 'modules/board/img/default_icon.png');
            }
            $listitem->add(array(
                '/{TOPIC}/' => $item->topic,
                '/{DETAIL}/' => $item->detail,
                '/{PICTURE}/' => $icon,
                '/{URL}/' => Gcms::createUrl($index->module, '', $item->category_id),
                '/{COUNT}/' => number_format($item->c1),
                '/{COMMENTS}/' => number_format($item->c2)
            ));
        }
        // category.html
        $template = Template::create('board', $index->module, 'category');
        $template->add(array(
            '/{TOPIC}/' => $index->topic,
            '/{DETAIL}/' => $index->detail,
            '/{LIST}/' => $listitem->render(),
            '/{STYLE}/' => 'iconview',
            '/{MODULE}/' => $index->module
        ));
        // breadcrumb ของโมดูล
        if (Gcms::$menu->isHome($index->index_id)) {
            // เป็นหน้าหลัก
            $index->canonical = WEB_URL.'index.php';
        } else {
            $index->canonical = Gcms::createUrl($index->module);
            $menu = Gcms::$menu->findTopLevelMenu($index->index_id);
            if ($menu) {
                // ใช้ข้อความจากเมนู
                Gcms::$view->addBreadcrumb($index->canonical, $menu->menu_text, $menu->menu_tooltip);
            } else {
                // โมดูล
                Gcms::$view->addBreadcrumb(Gcms::createUrl($index->module), $index->topic);
            }
        }
        // JSON-LD (Index)
        Gcms::$view->setJsonLd(\Index\Jsonld\View::webpage($index));
        // คืนค่า
        return (object) array(
            'canonical' => $index->canonical,
            'module' => $index->module,
            'topic' => $index->topic,
            'description' => $index->description,
            'keywords' => $index->keywords,
            'detail' => $template->render()
        );
    }
}
