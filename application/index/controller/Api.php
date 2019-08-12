<?php
namespace app\index\controller;


class Api extends Base
{
    protected function out($data){
        echo json_encode($data);
    }
    public function login(){
        $paramData=$this->buildParam(['user'=>'username','password'=>'password']);
        $paramData['password']=md5($paramData['password']);
        $paramData['status']='1';
        $check=$this->doModelAction($paramData,'common/user.login','User','isData');
        if($check){
            session('user',$check);
            return $this->showReturnCodeWithOutData('1001');
        }else{
            return $this->showReturnCodeWithOutData('1021');
        }
    }
    public function userAdd(){
        $paramData=$this->buildParam(['user'=>'user','name'=>'name','password'=>'pass','phone'=>'phone','address'=>'address']);
        $paramData['password']=md5($paramData['password']);
        $paramData['status']=3;
        $paramData['integral']=18000;
        $paramData['money']=0;
        $paramData['time']=time();
        $paramData['inv']=db('user')->where('uid',session('user'))->find()['inv'];
        $paramData['inv'].=','.session('user');
        $check=$this->doModelAction($paramData,'common/User.add','User','add');
        if($check['code']=='1001'){
            $check=$this->doModelAction(['source'=>session('user'),'user'=>$check['data']],'common/Inviation.add','Inviation','add');
        }
        $this->out($check);
    }
    public function loginOut(){
        session('user',null);
        $this->success('退出成功', '/index/index/index');
    }
}
?>