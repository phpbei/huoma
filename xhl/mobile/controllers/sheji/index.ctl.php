<?php
/**
 * Copy Right jisunet.com
 * 人要活得优雅,代码更需要优雅
 * $Id: designer.ctl.php 10025 2015-05-05 11:56:23  xinghuali
 */

class Ctl_Sheji_Index extends Ctl
{
    public function index($group_id=0,$jingyan=0,$page=1)
    {
        $pager = $filter = $attrs = $attr_ids = $attr_vids = $attr_value_ids = $attr_value_titles = array();
        $area_id = $group_id = $order = 0;
        $attr_values = K::M('data/attr')->attrs_by_from('zx:designer', true);
        $uri = $this->request['uri'];
        if(preg_match(' /index(-[\d\-]+)?\-(\d+).html/i', $uri, $m)){
            $page = (int)$m[2];
            if($m[1]){
                $attr_vids = explode('-', trim($m[1], '-'));
                $area_id = $attr_vids ? array_shift($attr_vids) : 0;
                $group_id = $attr_vids ? array_shift($attr_vids) : 0;
                $order = $attr_vids ? array_pop($attr_vids) : 0;
            }
        }
        foreach($attr_values as $k=>$v){
            if($v['filter']){
                $attr_value_ids[$k] = 0;
                foreach($attr_vids as $vv){
                    if($v['values'][$vv]){
                        $attr_value_ids[$k] = $vv;
                        $attr_ids[$k] = $vv;
                        $attrs[$k] = $v['values'][$vv];
                        $attr_value_titles[$k] = $v['values'][$vv]['title'];
                    }
                }
            }
        }
        $attr_vids = $attr_ids;    
        foreach($attr_values as $k=>$v){
            $vids = $attr_value_ids;
            $vids[$k] = 0;
            $vids['order'] = $order;
            $vids['page'] = 1;
            $v['link'] = $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $vids)));
            $v['checked'] = true;
            foreach($v['values'] as $kk=>$vv){
                $vv['checked'] = false;
                if(in_array($kk, $attr_ids)){
                    $v['checked'] = false;
                    $vv['checked'] = true;
                }                
                $vids[$k] = $kk;
                $vv['link'] = $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $vids)));
                $v['values'][$kk] = $vv;

            }
            $attr_values[$k] = $v;
        }
        if($group_list = K::M('member/group')->items_by_from('designer')){
            $group_all_link = $this->mklink('sheji/index', array($area_id, 0, implode('-', $attr_value_ids), $order, 1));
            foreach($group_list as $k=>$v){
                $v['link'] = $this->mklink('sheji/index', array($area_id, $k, implode('-', $attr_value_ids), $order, 1));
                $group_list[$k] = $v;
            }
        }

        $order_list = array(0=>array('title'=>'默认'), 1=>array('title'=>'签单'), 2=>array('title'=>'口碑'));
        $order_list[0]['link'] = $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $attr_value_ids), 0, 1));
        $order_list[1]['link'] = $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $attr_value_ids), 1, 1));
        $order_list[2]['link'] = $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $attr_value_ids), 2, 1));

        $pager = $filter = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['area_id'] = $area_id;
        $pager['group_id'] = $group_id;
        $pager['order'] = $order;
        $pager['limit'] = $limit = 30;
        $pager['count'] = $count = 0;
        if($area_id){
            $filter['area_id'] = $area_id;
        }
        if($group_id){
            $filter['group_id'] = $group_id;
        }
        $filter['closed'] = 0;
        $filter['audit'] = 1;
        if($attr_ids){
            $filter['attrs'] = $attr_ids;
			$jingyan = $attr_ids[9];
        }else{
			$jingyan = 0;
		}

        if ($kw = $this->GP('kw')) {
            $pager['sokw'] = $kw = htmlspecialchars($kw);
            $params['kw'] = $kw;
            $filter['name'] = "LIKE:%{$kw}%";            
        }
       if($order == 1){
            $orderby = array('tenders_num'=>'DESC');
        }else if($order == 2){
            $orderby = array('score'=>'DESC');
        }else{
            $orderby = array('group_id'=>'DESC','orderby'=>'ASC','uid'=>'ASC');
        }
        if ($items = K::M('designer/designer')->items_by_attr($filter, $orderby, $page, $limit, $count)) {
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $attr_value_ids), $order, '{page}'), $params));
			$items_tmp = array();
			foreach($items as $val){
				$val['anli'] = K::M('case/case')->items(array('uid'=>$val['uid'],'audit'=>1,'closed'=>0), array('mianji'=>'DESC'), 1, 4, $count);
				$items_tmp[] = $val;
				
			}
            $this->pagedata['items'] = $items_tmp;
        }
       
        $this->pagedata['attr_values'] = $attr_values;
        $this->pagedata['area_list'] = $area_list;
        $this->pagedata['group_list'] = $group_list;
        $this->pagedata['order_list'] = $order_list;
        $this->pagedata['area_all_link'] = $area_all_link;
        $this->pagedata['group_all_link'] = $group_all_link;
        $this->pagedata['pager'] = $pager;
        $this->pagedata['group_id'] = $group_id;
        $this->pagedata['jingyan'] = $jingyan;
        $this->pagedata['kw'] = urlencode($kw);
		
        $this->pagedata['attr_value_ids'] = $attr_value_ids;
        $seo = array('group_name'=>'', 'attr'=>'', 'page'=>'');
        /*if($area_id){
            $seo['area_name'] = $area_list[$area_id]['area_name'];
        }*/
        if($group_id){
            $seo['group_name'] = $group_list[$group_id]['group_name'];
        }
       
        if($attr_value_titles){
            $seo['attr'] = implode('_', $attr_value_titles);
        }
      
        if($page > 1){
            $seo['page'] = $page;
        }    
        $this->pagedata['seo'] = $seo;
        $this->seo->init('designer', $seo);
        $this->tmpl = 'mobile:sheji/index.html';
    }

    public function listcon($group_id=0,$jingyan=0,$kw='',$page=0)
    {
        if(!$page = $this->GP('page')){
            $page=1;
        }
        if(!$kw = $this->GP('kw')){
            $kw='';
        }
        
        $pager = $filter = $attrs = $attr_ids = $attr_vids = $attr_value_ids = $attr_value_titles = array();
        $area_id = $order = 0;
        $attr_values = K::M('data/attr')->attrs_by_from('zx:designer', true);
        $uri = $this->request['uri'];
		

		if($jingyan){
			$attr_ids = array('9'=>$jingyan);
		}
        $attr_vids = $attr_ids;    
        foreach($attr_values as $k=>$v){
            $vids = $attr_value_ids;
            $vids[$k] = 0;
            $vids['order'] = $order;
            $vids['page'] = 1;
            $v['link'] = $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $vids)));
            $v['checked'] = true;
            foreach($v['values'] as $kk=>$vv){
                $vv['checked'] = false;
                if(in_array($kk, $attr_ids)){
                    $v['checked'] = false;
                    $vv['checked'] = true;
                }                
                $vids[$k] = $kk;
                $vv['link'] = $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $vids)));
                $v['values'][$kk] = $vv;

            }
            $attr_values[$k] = $v;
        }
        if($group_list = K::M('member/group')->items_by_from('designer')){
            $group_all_link = $this->mklink('sheji/index', array($area_id, 0, implode('-', $attr_value_ids), $order, 1));
            foreach($group_list as $k=>$v){
                $v['link'] = $this->mklink('sheji/index', array($area_id, $k, implode('-', $attr_value_ids), $order, 1));
                $group_list[$k] = $v;
            }
        }

        $order_list = array(0=>array('title'=>'默认'), 1=>array('title'=>'签单'), 2=>array('title'=>'口碑'));
        $order_list[0]['link'] = $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $attr_value_ids), 0, 1));
        $order_list[1]['link'] = $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $attr_value_ids), 1, 1));
        $order_list[2]['link'] = $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $attr_value_ids), 2, 1));

        $pager = $filter = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['area_id'] = $area_id;
        $pager['group_id'] = $group_id;
        $pager['order'] = $order;
        $pager['limit'] = $limit = 30;
        $pager['count'] = $count = 0;
        if($area_id){
            $filter['area_id'] = $area_id;
        }
        if($group_id){
            $filter['group_id'] = $group_id;
        }
        $filter['closed'] = 0;
        $filter['audit'] = 1;
        if($attr_ids){
            $filter['attrs'] = $attr_ids;
        }
        if (!empty($kw)) {
			$kw= urldecode($kw);
            $pager['sokw'] = $kw = htmlspecialchars($kw);
            $params['kw'] = $kw;
            $filter['name'] = "LIKE:%{$kw}%";            
        }
        if($order == 1){
            $orderby = array('tenders_num'=>'DESC');
        }else if($order == 2){
            $orderby = array('score'=>'DESC');
        }else{
            $orderby = array('group_id'=>'DESC','uid'=>'ASC');
        }
        if ($items = K::M('designer/designer')->items_by_attr($filter, $orderby, $page, $limit, $count)) {
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $attr_value_ids), $order, '{page}'), $params));
            $items_tmp = array();
            foreach($items as $val){
                $val['anli'] = K::M('case/case')->items(array('uid'=>$val['uid'],'audit'=>1,'closed'=>0), array('mianji'=>'DESC'), 1, 4, $count);
                $items_tmp[] = $val;
                
            }
            $this->pagedata['items'] = $items_tmp;
        }
      // var_dump($cases);die;
        $this->pagedata['attr_values'] = $attr_values;
        $this->pagedata['area_list'] = $area_list;
        $this->pagedata['group_list'] = $group_list;
        $this->pagedata['order_list'] = $order_list;
        $this->pagedata['area_all_link'] = $area_all_link;
        $this->pagedata['group_all_link'] = $group_all_link;
        $this->pagedata['pager'] = $pager;
        $seo = array('group_name'=>'', 'attr'=>'', 'page'=>'');
       /* if($area_id){
            $seo['area_name'] = $area_list[$area_id]['area_name'];
        }*/
        if($group_id){
            $seo['group_name'] = $group_list[$group_id]['group_name'];
        }
        if($attr_value_titles){
            $seo['attr'] = implode('_', $attr_value_titles);
        }
        if($page > 1){
            $seo['page'] = $page;
        }    
        $this->seo->init('designer', $seo);
        $this->tmpl = 'mobile:sheji/listcon.html';
    }

    public function search($page=1)
    {
        $pager = $filter = $attrs = $attr_ids = $attr_vids = $attr_value_ids = $attr_value_titles = array();
        $area_id = $group_id = $order = 0;
        $attr_values = K::M('data/attr')->attrs_by_from('zx:designer', true);
        $uri = $this->request['uri'];

        if(preg_match(' /index(-[\d\-]+)?\-(\d+).html/i', $uri, $m)){
            $page = (int)$m[2];
            if($m[1]){
                $attr_vids = explode('-', trim($m[1], '-'));
                $area_id = $attr_vids ? array_shift($attr_vids) : 0;
                $group_id = $attr_vids ? array_shift($attr_vids) : 0;
                $order = $attr_vids ? array_pop($attr_vids) : 0;
            }
        }
        foreach($attr_values as $k=>$v){
            if($v['filter']){
                $attr_value_ids[$k] = 0;
                foreach($attr_vids as $vv){
                    if($v['values'][$vv]){
                        $attr_value_ids[$k] = $vv;
                        $attr_ids[$k] = $vv;
                        $attrs[$k] = $v['values'][$vv];
                        $attr_value_titles[$k] = $v['values'][$vv]['title'];
                    }
                }
            }
        }
        $attr_vids = $attr_ids;    
        foreach($attr_values as $k=>$v){
            $vids = $attr_value_ids;
            $vids[$k] = 0;
            $vids['order'] = $order;
            $vids['page'] = 1;
            $v['link'] = $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $vids)));
            $v['checked'] = true;
            foreach($v['values'] as $kk=>$vv){
                $vv['checked'] = false;
                if(in_array($kk, $attr_ids)){
                    $v['checked'] = false;
                    $vv['checked'] = true;
                }                
                $vids[$k] = $kk;
                $vv['link'] = $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $vids)));
                $v['values'][$kk] = $vv;

            }
            $attr_values[$k] = $v;
        }
        if($group_list = K::M('member/group')->items_by_from('designer')){
            $group_all_link = $this->mklink('sheji/index', array($area_id, 0, implode('-', $attr_value_ids), $order, 1));
            foreach($group_list as $k=>$v){
                $v['link'] = $this->mklink('sheji/index', array($area_id, $k, implode('-', $attr_value_ids), $order, 1));
                $group_list[$k] = $v;
            }
        }

        $order_list = array(0=>array('title'=>'默认'), 1=>array('title'=>'签单'), 2=>array('title'=>'口碑'));
        $order_list[0]['link'] = $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $attr_value_ids), 0, 1));
        $order_list[1]['link'] = $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $attr_value_ids), 1, 1));
        $order_list[2]['link'] = $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $attr_value_ids), 2, 1));

        $pager = $filter = array();
        $pager['page'] = $page = max((int)$page, 1);
        $pager['area_id'] = $area_id;
        $pager['group_id'] = $group_id;
        $pager['order'] = $order;
        $pager['limit'] = $limit = 10;
        $pager['count'] = $count = 0;
        if($area_id){
            $filter['area_id'] = $area_id;
        }
        if($group_id){
            $filter['group_id'] = $group_id;
        }
        $filter['closed'] = 0;
        $filter['audit'] = 1;
        if($attr_ids){
            $filter['attrs'] = $attr_ids;
        }
        if ($kw = $this->GP('kw')) {
            $pager['sokw'] = $kw = htmlspecialchars($kw);
            $params['kw'] = $kw;
            $filter['name'] = "LIKE:%{$kw}%";            
        }
        if($order == 1){
            $orderby = array('tenders_num'=>'DESC');
        }else if($order == 2){
            $orderby = array('score'=>'DESC');
        }else{
            $orderby = array('group_id'=>'DESC','uid'=>'ASC');
        }
        if ($items = K::M('designer/designer')->items_by_attr($filter, $orderby, $page, $limit, $count)) {
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink('sheji/index', array($area_id, $group_id, implode('-', $attr_value_ids), $order, '{page}'), $params));
            $items_tmp = array();
            foreach($items as $val){
                $val['anli'] = K::M('case/case')->items(array('uid'=>$val['uid'],'audit'=>1,'closed'=>0), array('mianji'=>'DESC'), 1, 4, $count);
                $items_tmp[] = $val;
                
            }
            $this->pagedata['items'] = $items_tmp;
        }
      // var_dump($cases);die;
        $this->pagedata['attr_values'] = $attr_values;
        $this->pagedata['area_list'] = $area_list;
        $this->pagedata['group_list'] = $group_list;
        $this->pagedata['order_list'] = $order_list;
        $this->pagedata['area_all_link'] = $area_all_link;
        $this->pagedata['group_all_link'] = $group_all_link;
        $this->pagedata['pager'] = $pager;
        $seo = array('area_name'=>'', 'attr'=>'', 'page'=>'');
        if($area_id){
            $seo['area_name'] = $area_list[$area_id]['area_name'];
        }
        if($attr_value_titles){
            $seo['attr'] = implode('_', $attr_value_titles);
        }
        if($page > 1){
            $seo['page'] = $page;
        }    
        $this->seo->init('designer', $seo);
        $this->tmpl = 'mobile:sheji/search.html';
    }

    public function attention($uid)
    {
        $detail = $this->check_designer($uid);
        if (!$detail['audit']) {
            $this->err->add('您关注的内容还在审核中，暂不可关注', 213);
        }else {
            K::M('designer/designer')->update($uid,array('attention_num'=>$detail['attention_num']+1));
            $this->err->add('关注成功！');
        }
    }

    public function yuyue($uid)
    {
        //var_dump($uid);die;
        if(!($uid = (int)$uid) && !($uid = (int)$this->GP('uid'))){
            $this->err->add('没有您要的数据', 211);
        }else if(!$detail = K::M('designer/designer')->detail($uid)){
            $this->err->add('没有您要的数据', 212);
        }else if(empty($detail['audit'])){
            $this->err->add("内容审核中，暂不可访问", 211)->response();
        }else{
            
               if(!$data = $this->GP('data')){
                    $this->err->add('非法的数据提交', 201);
                }else{
                    $verifycode_success = true;
                    $access = $this->system->config->get('access');
                    if($access['verifycode']['yuyue']){
                        if(!$verifycode = $this->GP('verifycode')){
                            $verifycode_success = false;
                            $this->err->add('验证码不正确', 212);
                        }else if(!K::M('magic/verify')->check($verifycode)){
                            $verifycode_success = false;
                            $this->err->add('验证码不正确', 212);
                        }
                    }
                    if($verifycode_success){
                        $data['designer_id'] = $uid;
                        $data['company_id'] = $detail['company_id'];
                        $data['uid'] = (int)$this->uid;
                        $data['content'] = "预约设计师:".$detail['uname'];
                        $data['city_id'] =  $this->request['city_id'];
                        if($yuyue_id = K::M('designer/yuyue')->create($data)){
                            K::M('designer/yuyue')->yuyue_count($uid);
                            $smsdata = $maildata = array('contact'=>$data['contact'] ? $data['contact'] : '参展商','mobile'=>$data['mobile'],'designer'=>$detail['realname']);
                            K::M('sms/sms')->send($data['mobile'], 'designer_yuyue', $smsdata);
                            if($company_id = $detail['company_id']){
                                if($company = K::M('company/company')->detail($company_id)){
                                    $company['member'] = $detail;
                                    K::M('sms/sms')->company('designer_tongzhi', $smsdata);
                                    K::M('helper/mail')->sendcompany($company, 'designer_yuyue', $maildata);
                                }
                            }else{
                                if($detail['verify_mobile'] && K::M('verify/check')->mobile($detail['mobile'])){
                                    K::M('sms/sms')->send($detail['mobile'], 'designer_tongzhi', $smsdata);
                                }
                                K::M('helper/mail')->sendmail($detail['mail'], 'designer_yuyue', $maildata);
                            }
                            $this->err->add('预约设计师成功');
                        }
                    }
                } 
        }
    }
    
    protected function check_designer($uid)
    {
        if(!($uid = (int)$uid) && !($uid = $this->GP('uid'))){
            $this->error(404);
        }else if(!$detail = K::M('designer/designer')->detail($uid)){
            $this->error(404);
        }
        $this->pagedata['detail'] = $detail;
        return $detail;
    }
}