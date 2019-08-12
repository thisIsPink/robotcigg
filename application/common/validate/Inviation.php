<?php

namespace app\common\validate;

use think\Validate;

class Inviation extends Validate
{

    protected $rule = [
        'id'=>'number',
        'source'=>'require|max:10|number',
        'user'=>'require|max:10|number',
    ];

    protected $field = [
        'source'=>'邀请人',
        'user'=>'被邀请人',
    ];
    protected $scene= [
        'add'=>['source','user']
    ];
}
