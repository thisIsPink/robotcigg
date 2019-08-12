<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    private function isLogin()
    {
        if(session('user')==null){
            return $this->index();
        }else{
            return true;
        }
    }
    public function index()
    {
        if(session('user')){
            return $this->fetch();
        }else{
            return $this->fetch('login');
        }
    }
    public function welcome(){
        if($this->isLogin()){
            $id=session('user');
            $userInfo=db('user')->where('uid',$id)->field('inv,user,name,phone,status,integral,money')->find();
            $invInfo=db('user')->where('uid',substr($userInfo['inv'],-1))->field('user,name,phone,status')->find();
            $upMoney=db('in_log')->where('user',$id)->order('time','desc')->find();
            $userInfo['up_money']=$upMoney?$upMoney['integral']:0;
            $data=$id;
            for ($i=0;$i<4;$i++){
                $data=$this->downInv($data);
                $down[]=$data[0];
                $data=$data[1];
            }
            $this->assign('down',$down);
            $this->assign('dtime',time());  //当前时间
            $this->assign('invInfo',$invInfo);  //上级信息
            $this->assign('userInfo',$userInfo);//用户信息
            return $this->fetch();
        }
    }
    public function _empty($name)
    {
        if($this->isLogin()){
            return $this->fetch($name);
        }
    }
    protected function downInv($where){
        $data=db('inviation')->field('user')->where([['source','in',$where]])->select();
        $num=db('inviation')->alias('i')->join('user u','u.uid=i.user')->field('user')->where([['source','in',$where],['u.status','=','1']])->count();
        return [$num,array_column($data, 'user')];
    }

}
