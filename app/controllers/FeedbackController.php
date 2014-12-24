<?php

class FeedbackController extends BaseController {

    public $typeEnum = array('' => '所有类型', '1' => '网站使用', '2' => '其他');
    public $pageSize = 10;


    public function index()
    {
        $list = Feedback::where('user_id', Session::get('uid'))->orderBy('id', 'desc')->paginate($this->pageSize);
        
        // 标记回复为已读
        $this->_readreplys($list);

        return $this->indexView('profile.feedback', compact('list'));
    }
    
    /**
     * 标记回复为已读
     */
    public function _readreplys($fblist) {
        $reply_ids = array();
        foreach($fblist as $f) {
            if(!empty($f) && !empty($f->reply)) {
                $reply_ids[] = $f->id;
            }
        }
        FeedbackUser::readreplys(Session::get('uid'), $reply_ids);
    }

    public function doPost()
    {
        $content = Input::get('content');

        if(empty($content))
            return $this->indexPrompt("", "请填写反馈信息", $url = "/feedback", false);

        $f = new Feedback();
        $f->user_id = Session::get('uid');
        $f->type = 1;
        $f->content = htmlentities(trim($content));
        $f->save();

        return $this->indexPrompt("", "问题反馈提交成功", $url = "/feedback", false);
    }

}
