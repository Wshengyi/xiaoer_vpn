<?php

namespace app\admin\model;

use think\Model;


class Subscription extends Model
{

    

    

    // 表名
    protected $name = 'subscription';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'sub_status_text'
    ];

    // 类型转换
    protected $type = [

    ];
    

    
    public function getSubStatusList()
    {
        return ['有效' => __('有效'), '已暂停' => __('已暂停'), '已取消' => __('已取消')];
    }


    public function getSubStatusTextAttr($value, $data)
    {
        $value = $value ?: ($data['sub_status'] ?? '');
        $list = $this->getSubStatusList();
        return $list[$value] ?? '';
    }




}
