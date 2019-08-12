<?php
namespace app\common\model;

use think\Model;

class Basis extends Model
{
    public function editData($data){
        if (isset($data['id'])){
            if (is_numeric($data['id']) && $data['id']>0){
                $save = $this->allowField(true)->save($data,[ $this->pk => $data['id']]);
            }else{
                $save  = $this->allowField(true)->save($data);
            }
        }else{
            $save  = $this->allowField(true)->save($data);
        }
        if ( $save == 0 || $save == false) {
            $res=[  'code'=> 1009,  'msg' => '数据更新失败', ];
        }else{
            $res=[  'code'=> 1001,  'msg' => '数据更新成功',  ];
        }
        return $res;
    }
    public function getMeetCondition($where = ''){
        return $this->where($where)->count();
    }
    public function isData($where = ''){
        if(empty($where)){
            return false;
        }else{
            $data=$this->where($where)->find();
            if($data){
                return $data[$this->pk];
            }else{
                return false;
            }
        }
    }
}
?>