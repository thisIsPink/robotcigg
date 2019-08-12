<?php
namespace app\index\controller;

class Info extends Base
{
    protected $returnValue=['code','data','msg'];
    protected function setData($data=[],$code=1001,$msg=''){
        return $this->showReturnCode($code,$this->returnValue,$msg);
    }
    public function memberInfo(){
        $id=session('user');
        $data=db('user')->alias('u')->join('inviation i','u.uid=i.user')->where([['i.source','=',$id],['status','in','3,1']])->field('u.user,name,phone,status')->select();
        $num=db('user')->alias('u')->join('inviation i','u.uid=i.user')->where([['i.source','=',$id],['status','in','3,1']])->count();
        foreach ($data as $key=>$value){
            $data[$key]['level']='官方代理';
        }
        if(is_array($data)){
            echo json_encode($this->layuiReturnCode($data,$num));
        }else{
            json_encode($this->layuiReturnCode());
        }
    }
}
?>