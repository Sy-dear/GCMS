<?php
/**
 * @filesource modules/index/models/upgrade1380.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Index\Upgrade1380;

/**
 * อัปเกรด
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Index\Upgrade\Model
{
    /**
     * อัปเกรดเป็นเวอร์ชั่น 13.8.0
     *
     * @return object
     */
    public static function upgrade($db)
    {
        return (object) array(
            'content' => '<li class="correct">Upgrade to Version <b>13.8.0</b> complete.</li>',
            'version' => '13.8.0'
        );
    }
}
