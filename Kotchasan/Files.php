<?php
/**
 * @filesource Kotchasan/Files.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Kotchasan;

use Kotchasan\Http\UploadedFile;

/**
 * รายการ File รูปแบบ Array
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Files implements \Iterator
{
    /**
     * @var int
     */
    private $position = 0;
    /**
     * แอเรย์เก็บรายการ UploadedFile
     *
     * @var array
     */
    private $datas = array();

    /**
     * init Class
     */
    public function __construct()
    {
        $this->position = 0;
        $this->datas = array();
    }

    /**
     * เพื่ม File ลงในคอลเล็คชั่น
     *
     * @param string $name         ชื่อของ Input
     * @param string $path         ไฟล์อัปโหลด รวมพาธ
     * @param string $originalName ชื่อไฟล์ที่อัปโหลด
     * @param string $mimeType     MIME Type
     * @param int    $size         ขนาดไฟล์อัปโหลด
     * @param int    $error        ข้อผิดพลาดการอัปโหลด UPLOAD_ERR_XXX
     */
    public function add($name, $path, $originalName, $mimeType = null, $size = null, $error = null)
    {
        $this->datas[] = array(
            $name,
            new UploadedFile($path, $originalName, $mimeType, $size, $error)
        );
    }

    /**
     * inherited from Iterator
     */
    #[\ReturnTypeWillChange]
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function valid()
    {
        return isset($this->datas[$this->position]);
    }

    /**
     * คืนค่า UploadedFile รายการปัจจุบัน
     *
     * @return \Kotchasan\Http\UploadedFile
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->datas[$this->position][1];
    }

    /**
     * คืนค่าคีย์หรือลำดับของ UploadedFile ในลิสต์รายการ
     *
     * @return string
     */
    #[\ReturnTypeWillChange]
    public function key()
    {
        return $this->datas[$this->position][0];
    }

    /**
     * คืนค่า UploadedFile รายการถัดไป
     *
     * @return \Kotchasan\Http\UploadedFile
     */
    #[\ReturnTypeWillChange]
    public function next()
    {
        $this->position++;
    }

    /**
     * อ่าน File ที่ต้องการ
     *
     * @param string|int $key รายการที่ต้องการ
     *
     * @return \Kotchasan\Http\UploadedFile
     */
    public function get($key)
    {
        $result = null;
        foreach ($this->datas as $values) {
            if ($values[0] === $key) {
                $result = $values[1];
                break;
            }
        }
        return $result;
    }
}
