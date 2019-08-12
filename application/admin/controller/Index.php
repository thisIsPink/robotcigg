<?php
namespace app\admin\controller;

class Index extends Base
{
    private function isLogin()
    {
        if(session('admin')==null){
            return $this->index();
        }else{
            return true;
        }
    }
    public function index()
    {
        if(session('admin')){
            return $this->fetch();
        }else{
            return $this->fetch('login');
        }
    }
    public function welcome(){
        if($this->isLogin()){
            $integral=db('user')->where('inv','0')->sum('integral');
            $this->assign('integral',$integral);
            return $this->fetch();
        }
    }
    public function _empty($name)
    {
        if($this->isLogin()){
            return $this->fetch($name);
        }
    }
}
?>