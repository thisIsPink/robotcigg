<?php
namespace app\admin\controller;



class Api extends Base
{
    protected function out($data){
        echo json_encode($data);
    }
    public function login(){
        $paramData=$this->buildParam(['user'=>'username','password'=>'password']);
        if(md5($paramData['password'])==md5('123456')&&$paramData['user']=='admin'){
            session('admin','true');
            return $this->showReturnCodeWithOutData('1001');
        }else{
            return $this->showReturnCodeWithOutData('1021');
        }
    }
    public function userAdd(){
        $paramData=$this->buildParam(['user'=>'user','name'=>'name','password'=>'pass','phone'=>'phone','address'=>'address']);
        $paramData['password']=md5($paramData['password']);
        $paramData['status']=1;
        $paramData['integral']=18000;
        $paramData['money']=0;
        $paramData['time']=time();
        $paramData['inv']='0';
        $check=$this->doModelAction($paramData,'common/User.add','User','add');
        $this->out($check);
    }
    public function memberExamine(){
        $paramData=$this->buildParam(['uid'=>'id','status'=>'status']);
        if($paramData['status']=='1'){
            $check=$this->doModelAction($paramData,'common/User.valStatus','User','changeStatus');
            if($check['code']=='1001'){
                $info=db('user')->where('uid',$paramData['uid'])->field('inv,integral')->find();
                db('user')->where([['uid','in',$info['inv']],['status','=','1']])->setInc('integral',$info['integral']);
            }
        }else{
            $check=$this->doModelAction($paramData,'common/User.valStatus','User','changeStatus');
        }
        $this->out($check);
    }
    public function emptyAll(){
        if(session('admin')=='true')
        {
            $data = db('user')->order('uid', 'desc')->field('uid,integral,inv')->cursor();
            $users = [];
            $time=time();
            foreach ($data as $value) {
                if (!isset($users[$value['uid']])) {
                    $users[$value['uid']] = ['money' => 0, 'down_money' => 0];
                }
                if ($value['integral'] < 100000) {
                    $money = $value['integral'] * 0;
                } elseif ($value['integral'] < 300000) {
                    $money = bcadd(bcmul($value['integral'], 0.04), $users[$value['uid']]['money'], 2);
                } elseif ($value['integral'] < 800000) {
                    $money = bcadd(bcmul($value['integral'], 0.05), $users[$value['uid']]['money'], 2);
                } elseif ($value['integral'] < 2000000) {
                    $money = bcadd(bcmul($value['integral'], 0.06), $users[$value['uid']]['money'], 2);
                } elseif ($value['integral'] < 5000000) {
                    $money = bcadd(bcmul($value['integral'], 0.07), $users[$value['uid']]['money'], 2);
                } elseif ($value['integral'] < 10000000) {
                    $money = bcadd(bcmul($value['integral'], 0.08), $users[$value['uid']]['money'], 2);
                } elseif ($value['integral'] < 20000000) {
                    $money = bcadd(bcmul($value['integral'], 0.09), $users[$value['uid']]['money'], 2);
                } else {
                    $money = bcadd(bcmul($value['integral'], 0.1), $users[$value['uid']]['money'], 2);
                }
                $down = explode(',', $value['inv']);
                foreach ($down as $values) {
                    if (!isset($users[$values])) {
                        if ($values == 0) continue;
                        $users[$values] = ['money' => 0, 'down_money' => 0];
                    }
                    $users[$values]['money'] = bcsub($users[$values]['money'], $money, 2);
                    $users[$values]['down_money'] = bcadd($users[$values]['down_money'], $money, 2);
                }
                if (isset($users[$value['uid']['down_money']])) {
                    $down_money = $users[$value['uid']['down_money']];
                } else {
                    $down_money = 0;
                }
                $users[$value['uid']] = ['user' => $value['uid'],  'integral' => $value['integral'], 'down_money' => $down_money, 'money' => $money,'time'=>$time];
            }
            db('in_log')->insertAll($users);
            $check=$this->doModelAction(false,false,'User','emptyAll');
        }else{
            $check=['code'=>'1002','msg'=>'没有权限'];
        }
        $this->out($check);
    }
    public function memberStatus(){
        $paramData=$this->buildParam(['uid'=>'id','status'=>'status']);
        $check=$this->doModelAction($paramData,'common/User.valStatus','User','changeStatus');
        $this->out($check);
    }
    public function memberMoneyedit(){
        $paramData=$this->buildParam(['uid'=>'id','money'=>'money','type'=>'type']);
        if((int)$paramData['money']==0){
            $this->out(['code'=>'1002','msg'=>'金额格式不正确']);
            return;
        }
        $check=$this->doModelAction($paramData,'common/User.valMoney','User','changeMoney');
        $this->out($check);
    }
    public function memberEdit(){
        $paramData=$this->buildParam(['uid'=>'id','field'=>'field','value'=>'value']);
        if($paramData['field']=='name'||$paramData['field']=='phone'||$paramData['field']=='address'||$paramData['field']=='password'){
            if($paramData['field']=='password')$paramData['value']=md5($paramData['value']);
            $data=['uid'=>$paramData['uid'],$paramData['field']=>$paramData['value']];
            $check=$this->doModelAction($data,'common/User.'.$paramData['field'].'Val','User','changeEdit');
        }else{
            $check=['code'=>'1002','msg'=>'参数错误'];
        }
        $this->out($check);
    }
    public function loginOut(){
        session('admin',null);
        $this->success('退出成功', '/admin/index/index');
    }
}
?>