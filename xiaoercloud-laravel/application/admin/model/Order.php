<?php

namespace app\admin\model;

use think\Model;


class Order extends Model
{

    

    

    // 表名
    protected $name = 'order';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'pay_status_text'
    ];

    // 类型转换
    protected $type = [

    ];
    

    
    public function getPayStatusList()
    {
        return ['待支付' => __('待支付'), '已支付' => __('已支付'), '已取消' => __('已取消')];
    }


    public function getPayStatusTextAttr($value, $data)
    {
        $value = $value ?: ($data['pay_status'] ?? '');
        $list = $this->getPayStatusList();
        return $list[$value] ?? '';
    }




}
