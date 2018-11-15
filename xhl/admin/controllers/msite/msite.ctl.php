<?php
/**
 * Copy Right jisunet.com
 * 人要活得优雅,代码更需要优雅
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Msite_Msite extends Ctl
{
    
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        
        if($items = K::M('msite/msite')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:msite/msite/items.html';
    }





    public function create()
    {
        if($data = $this->checksubmit('data')){
            
            if($wx_id = K::M('msite/msite')->create($data)){
                $this->err->add('添加内容成功');
                $this->err->set_data('forward', '?msite/msite-index.html');
            } 
        }else{
           $this->tmpl = 'admin:msite/msite/create.html';
        }
    }

    public function edit($wx_id=null)
    {
        if(!($wx_id = (int)$wx_id) && !($wx_id = $this->GP('wx_id'))){
            $this->err->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('msite/msite')->detail($wx_id)){
            $this->err->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            
            if(K::M('msite/msite')->update($wx_id, $data)){
                $this->err->add('修改内容成功');
            }  
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:msite/msite/edit.html';
        }
    }



    public function delete($wx_id=null)
    {
        if($wx_id = (int)$wx_id){
            if(!$detail = K::M('msite/msite')->detail($comment_id)){
                $this->err->add('你要删除的内容不存在或已经删除', 211);
            }else{
                if(K::M('msite/msite')->delete($wx_id)){
                    $this->err->add('删除内容成功');
                }
            }
        }else if($ids = $this->GP('wx_id')){
            if(K::M('msite/msite')->delete($ids)){
                $this->err->add('批量删除内容成功');
            }
        }else{
            $this->err->add('未指定要删除的内容ID', 401);
        }
    }  

}