<?php
/**
 * Copy Right jisunet.com
 * 人要活得优雅,代码更需要优雅
 * $Id: shop_comment.php 2335 2015-11-18 17:15:56  xinghuali
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

return array (
  'comment_id' => 
  array (
    'field' => 'comment_id',
    'label' => 'ID',
    'pk' => true,
    'add' => false,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => false,
    'list' => true,
    'type' => 'int',
    'comment' => '',
    'default' => '',
    'SO' => '=',
  ),
  'shop_id' => 
  array (
    'field' => 'shop_id',
    'label' => '企业',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => false,
    'list' => true,
    'type' => 'shop',
    'comment' => '',
    'default' => '',
    'SO' => '=',
  ),
  'uid' => 
  array (
    'field' => 'uid',
    'label' => '会员',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => false,
    'list' => true,
    'type' => 'member',
    'comment' => '',
    'default' => '',
    'SO' => '=',
  ),
  'score' => 
  array (
    'field' => 'score',
    'label' => '评分',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => false,
    'list' => true,
    'type' => 'int',
    'comment' => '评分1~5',
    'default' => '1',
    'SO' => false,
  ),
  'content' => 
  array (
    'field' => 'content',
    'label' => '评论内容',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => false,
    'show' => false,
    'list' => true,
    'type' => 'textarea',
    'comment' => '',
    'default' => '',
    'SO' => 'like',
  ),
  'reply' => 
  array (
    'field' => 'reply',
    'label' => '回复内容',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => false,
    'list' => false,
    'type' => 'textarea',
    'comment' => '',
    'default' => '',
    'SO' => false,
  ),
  'replyip' => 
  array (
    'field' => 'replyip',
    'label' => '回复IP',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => false,
    'list' => true,
    'type' => 'text',
    'comment' => '',
    'default' => '',
    'SO' => false,
  ),
  'replytime' => 
  array (
    'field' => 'replytime',
    'label' => '回复时间',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => false,
    'list' => true,
    'type' => 'unixtime',
    'comment' => '',
    'default' => '',
    'SO' => false,
  ),
  'audit' => 
  array (
    'field' => 'audit',
    'label' => '审核',
    'pk' => false,
    'add' => true,
    'edit' => true,
    'html' => false,
    'empty' => true,
    'show' => false,
    'list' => true,
    'type' => 'audit',
    'comment' => '',
    'default' => '',
    'SO' => '=',
  ),
  'closed' => 
  array (
    'field' => 'closed',
    'label' => '删除',
    'pk' => false,
    'add' => false,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => false,
    'list' => false,
    'type' => 'closed',
    'comment' => '',
    'default' => '',
    'SO' => false,
  ),
  'clientip' => 
  array (
    'field' => 'clientip',
    'label' => '评论IP',
    'pk' => false,
    'add' => false,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => false,
    'list' => true,
    'type' => 'clientip',
    'comment' => '',
    'default' => '',
    'SO' => false,
  ),
  'dateline' => 
  array (
    'field' => 'dateline',
    'label' => '评论时间',
    'pk' => false,
    'add' => false,
    'edit' => false,
    'html' => false,
    'empty' => false,
    'show' => false,
    'list' => true,
    'type' => 'dateline',
    'comment' => '',
    'default' => '',
    'SO' => 'betweendate',
  ),
);