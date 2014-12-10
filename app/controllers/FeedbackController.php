<?php

class FeedbackController extends BaseController {

    public $typeEnum = array('' => '所有类型', '1' => '网站使用', '2' => '其他');


    public function index()
    {
        $list = Feedback::where('user_id', Session::get('uid'))->orderBy('id', 'desc')->paginate(5);

        return $this->indexView('profile.feedback', compact('list'));
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
