<?php
namespace app\common\model;

class User extends Basis
{
    protected $table = 'user';
    protected $pk = 'uid';
    public function add($data){
        if($this->where('user',$data['user'])->find()){
            return [  'code'=> 1002,  'msg' => '用户已存在'];
        }else{
            $id=$this->insertGetId($data);
            if($id) {
                return [  'code'=> 1001, 'data'=>$id, 'msg' => '操作成功'];
            }else{
                return [  'code'=> 1009,  'msg' => '操作失败'];
            }
        }
    }
    public function changeStatus($data){
        $id=$data[$this->pk];
        unset($data[$this->pk]);
        if($this->where('uid',$id)->update($data)){
            return [  'code'=> 1001,  'msg' => '操作成功'];
        }else{
            return [  'code'=> 1009,  'msg' => '操作失败'];
        }
    }
    public function emptyAll(){
        if($this->where([['integral','>','0']])->update(['integral'=>'0'])){
            return [  'code'=> 1001,  'msg' => '操作成功'];
        }else{
            return [  'code'=> 1009,  'msg' => '操作失败'];
        }
    }
    public function changeMoney($data){
        $id=$data[$this->pk];
        unset($data[$this->pk]);
        $userInfo=$this->where($this->pk,$id)->find();
        $user=str_replace('0',$id,$userInfo['inv']);
        if($data['type']=='add'){
            $res=$this->where([[$this->pk,'in',$user]])->setInc('integral',$data['money']);
        }else if ($data['type']=='reduce'){
            if($userInfo['integral']-$data['money']<0){
                $res=false;
            }else{
                $res=$this->where([[$this->pk,'in',$user]])->setDec('integral',$data['money']);
            }
        }
        if($res){
            return [  'code'=> 1001,  'msg' => '操作成功'];
        }else{
            return [  'code'=> 1009,  'msg' => '操作失败'];
        }
    }
    public function changeEdit($data){
        $id=$data[$this->pk];
        unset($data[$this->pk]);
        if($this->where($this->pk,$id)->update($data)){
            return [  'code'=> 1001,  'msg' => '操作成功'];
        }else{
            return [  'code'=> 1009,  'msg' => '操作失败'];
        }
    }
}