<?php
namespace app\common\model;

class Inviation extends Basis
{
    protected $table = 'inviation';
    protected $pk   = 'uid';
    public function add($data)
    {
        if ($this->insert($data)) {
            return ['code' => 1001, 'msg' => '操作成功'];
        } else {
            return ['code' => 1009, 'msg' => '操作失败'];
        }
    }
}
?>