<?php
/**
 * @filesource modules/personnel/models/admin/settings.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Personnel\Admin\Settings;

use Gcms\Gcms;
use Gcms\Login;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 *  บันทึกการตั้งค่า
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{
    /**
     * ค่าติดตั้งเริ่มต้น
     *
     * @return array
     */
    public static function defaultSettings()
    {
        return array(
            'image_width' => 200,
            'image_height' => 250,
            'can_write' => array(1),
            'can_config' => array(1)
        );
    }

    /**
     * บันทึกข้อมูล config ของโมดูล
     *
     * @param Request $request
     *
     * @return JSON
     */
    public function submit(Request $request)
    {
        $ret = array();
        // referer, token, can_config, ไม่ใช่สมาชิกตัวอย่าง
        if ($request->initSession() && $request->isSafe() && $login = Login::adminAccess()) {
            if (Login::notDemoMode($login)) {
                // รับค่าจากการ POST
                $save = array(
                    'image_width' => max(75, $request->post('image_width')->toInt()),
                    'image_height' => max(75, $request->post('image_height')->toInt()),
                    'can_write' => $request->post('can_write', array())->toInt(),
                    'can_config' => $request->post('can_config', array())->toInt()
                );
                // อ่านข้อมูลโมดูล และ config
                $index = \Index\Adminmodule\Model::getModuleWithConfig('personnel', $request->post('id')->toInt());
                // สามารถตั้งค่าได้
                if ($index && Gcms::canConfig($login, $index, 'can_config')) {
                    // บันทึก
                    $save['can_write'][] = 1;
                    $save['can_config'][] = 1;
                    $this->db()->update($this->getTableName('modules'), $index->module_id, array('config' => serialize($save)));
                    // คืนค่า
                    $ret['alert'] = Language::get('Saved successfully');
                    $ret['location'] = 'reload';
                    // เคลียร์
                    $request->removeToken();
                }
            }
        }
        if (empty($ret)) {
            $ret['alert'] = Language::get('Unable to complete the transaction');
        }
        // คืนค่าเป็น JSON
        echo json_encode($ret);
    }
}
