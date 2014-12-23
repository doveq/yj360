<?php

/**
 * ip与页面关联表(辅助计算页面浏览量)
 */
class IpPage extends Eloquent {
    protected $table = 'ip_page';
    
    /**
     * 根据page_id和type删除记录
     * @param int $page_id
     * @param int $type notice表此值为0,class_notice表此值为1
     */
    public function delByPageType($page_id, $type) {
        return $this->where('page_id', $page_id)->where('type', $type)->delete();
    }
}
