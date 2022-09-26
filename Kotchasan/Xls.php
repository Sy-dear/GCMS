<?php
/**
 * @filesource Kotchasan/Xls.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Kotchasan;

/**
 * Xls function
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Xls
{
    /**
     * สร้างไฟล์ XLS สำหรับดาวน์โหลด
     * คืนค่า true
     *
     * @param string $file ชื่อไฟล์ ไม่ต้องมีนามสกุล
     * @param array $header ส่วนหัวของข้อมูล
     * @param array $datas ข้อมูล
     *
     * @return bool
     */
    public static function send($file, $header, $datas)
    {
        // header
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$file.'.xls"');
        header("Pragma:no-cache");
        // XLS Template
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"';
        echo ' xmlns:x="urn:schemas-microsoft-com:office:excel"';
        echo ' xmlns="http://www.w3.org/TR/REC-html40">';
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"';
        echo ' "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
        echo '<html>';
        echo '<head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        echo '</head>';
        echo '<body><table><thead><tr>';
        $n = 0;
        foreach ($header as $k => $items) {
            if ($k === 'rows') {
                foreach ($items as $rows) {
                    if ($n > 0) {
                        echo '</tr><tr>';
                    }
                    foreach ($rows as $item) {
                        // th
                        echo self::cell('th', $item);
                    }
                    $n++;
                }
            } else {
                // th
                echo self::cell('th', $items);
            }
        }
        echo '</tr></thead><tbody>';
        foreach ($datas as $items) {
            echo '<tr>';
            foreach ($items as $item) {
                echo self::cell('td', $item);
            }
            echo '</tr>';
        }
        echo '</tbody></table></body>';
        echo '</html>';
        // คืนค่า สำเร็จ
        return true;
    }

    /**
     * สร้าง th หรือ td
     *
     * @param string $type th,td
     * @param array $item
     */
    public static function cell($type, $item)
    {
        $value = '';
        $prop = '';
        if (is_array($item)) {
            foreach ($item as $k => $v) {
                if ($k == 'value') {
                    $value = $v;
                } else {
                    $prop .= ' '.$k.'="'.$v.'"';
                }
            }
        } else {
            $value = $item;
        }
        return '<'.$type.$prop.'>'.$value.'</'.$type.'>';
    }
}
