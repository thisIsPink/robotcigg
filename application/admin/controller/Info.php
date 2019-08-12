<?php
namespace app\admin\controller;

class Info extends Base
{
    protected $returnValue=['code','data','msg'];
    protected function setData($data=[],$num){
        return $this->layuiReturnCode($data,$num);
    }
    public function memberInfo(){
        $paramData=$this->buildParam(['page'=>'page','limit'=>'limit']);
        $data=db('user')->alias('u1')->leftJoin('inviation i','u1.uid=i.user')->leftJoin('user u2','u2.uid=i.source')->where([['u1.status','in','1,2']])->order('u1.uid','desc')->page($paramData['page'],$paramData['limit'])->field('u1.uid,u1.user,u1.name,u1.phone,u1.address,u1.integral,u1.money,u1.status,u2.user user2')->select();
        $num=db('user')->where([['status','in','1,2']])->count();
        echo json_encode($this->setData($data,$num));
    }
    public function memberExamine(){
        $paramData=$this->buildParam(['page'=>'page','limit'=>'limit']);
        $data=db('user')->alias('u')->join('inviation i','i.user=u.uid')->join('user u1','i.source=u1.uid')->order('u.uid','desc')->where('u.status','3')->field('u.uid,u1.user source,u.user,u.name,u.phone,u.address')->page($paramData['page'],$paramData['limit'])->select();
        $num=db('user')->where('status','3')->count();
        echo json_encode($this->setData($data,$num));
    }
    public function settlement()
    {
        $data = db('user')->order('uid', 'desc')->field('uid,user,name,phone,integral,inv')->cursor();
        $users = [];
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
            $users[$value['uid']] = ['user' => $value['user'], 'name' => $value['name'], 'phone' => $value['phone'], 'integral' => $value['integral'], 'down_money' => $down_money, 'money' => $money];
        }
        echo json_encode($this->setData($users, 0));
    }
    public function tree(){
        $data=db('user')->field('uid,user,name,inv,status')->cursor();
        $tree=[];
        foreach ($data as $value) {
            $down=explode(',',$value['inv']);
            if(count($down)==1){
                $tree[$value['uid']]=['title'=>'<i class="layui-icon">&#xe66f;</i> &nbsp&nbsp'.$value['user'].':'.$value['name'].' &nbsp&nbsp;'.($value['status']=='1'?':已激活':':未激活')];
            }else{
                $arr=&$tree;
                for($i=1;$i<count($down);$i++){
                    if($i==count($down)-1){
                        $arr[$down[$i]]['children'][$value['uid']]=['title'=>'<i class="layui-icon">&#xe66f;</i> &nbsp&nbsp'.$value['user'].':'.$value['name'].' &nbsp&nbsp;'.($value['status']=='1'?':已激活':':未激活')];
                    }else{
                        $arr=&$arr[$down[$i]]['children'];
                    }
                }
            }
        }
        $tree=$this->formattingTree($tree);
        echo json_encode($tree);
    }
    public function formattingTree($arr){
        $arr=array_values($arr);
        foreach ($arr as &$value){
            if(isset($value['children'])) {
                $value['children'] = $this->formattingTree($value['children']);
            }
        }
        return $arr;
    }
    public function settlementLog(){
        $paramData=$this->buildParam(['page'=>'page','limit'=>'limit']);
        $data=db('in_log')->alias('i')->Join('user u','u.uid=i.user')->order('i.id','desc')->page($paramData['page'],$paramData['limit'])->field('u.user,u.name,u.phone,i.integral,i.money,i.down_money,i.time')->where([['i.integral','>','100000']])->select();
        $num=db('in_log')->where([['integral','>','100000']])->count();
        echo json_encode($this->setData($data,$num));
    }
}
?>