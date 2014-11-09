<?php

class IndexController extends BaseController {

    public function index()
    {
        // 如果已经登录
        if(Auth::check())
        {
            return Redirect::to('/column/static');
        }

        return $this->indexView('index');
    }

    public function column()
    {
        //初级
        //配套教材
        $cl1 = 6;
        $ptjc = Column::find($cl1)->child()->whereStatus(1)->get();
        // dd($ptjc);
        //专题训练
        $cl2 = 8;
        $ztxl = Column::find($cl2)->child()->get();
        //真题测试
        $cl3 = 10;
        $ztcs = Column::find($cl3)->child()->get();
        //难点解答
        $cl4 = 11;
        $ndjd = Column::find($cl1)->child()->get();

        $color = array("#2fc8d0","#efc825","#5fc1e8","#f28695","#f49543","#abd663","#b18ac1");

        return $this->indexView('column', compact('color', 'ptjc', 'ztxl', 'ztcs', 'ndjd'));
    }

    public function about()
    {

        return $this->indexView('index.about');
    }

    public function link()
    {

        return $this->indexView('index.link');
    }

    public function feedback()
    {

        return $this->indexView('index.feedback');
    }

    public function follow()
    {

        return $this->indexView('index.follow');
    }

    /* 访问方法不存在时调用 */
    public function missingMethod($parameters = array())
    {
        exit('没有这个访问方法');
    }
}
