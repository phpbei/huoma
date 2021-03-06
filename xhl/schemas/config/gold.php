<?php
/**
 * Copy Right jisunet.com
 * 人要活得优雅,代码更需要优雅
 * #fileid#
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

return array (
  'open' => 
  array (
    'label' => '是否开启',
    'field' => 'open',
    'type' => 'boolean',
    'default' => '',
    'comment' => '',
    'html' => false,
    'empty' => false,
  ),
  'onpay' => 
  array (
    'label' => '开启在线充值',
    'field' => 'onpay',
    'type' => 'boolean',
    'default' => '',
    'comment' => '',
    'html' => false,
    'empty' => false,
  ),
  'huilv' => 
  array (
    'label' => '展币汇率',
    'field' => 'huilv',
    'type' => 'number',
    'default' => '',
    'comment' => '1RMB兑换多少展币',
    'html' => false,
    'empty' => false,
  ),
  'minpay' => 
  array (
    'label' => '最小充值',
    'field' => 'minpay',
    'type' => 'number',
    'default' => '',
    'comment' => 'RMB',
    'html' => false,
    'empty' => false,
  ),
);