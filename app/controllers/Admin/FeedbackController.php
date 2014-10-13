<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;

use Feedback;
use User;

class FeedbackController extends \BaseController {

    public $typeEnum = array('' => '所有类型', '1' => '网站使用', '2' => '其他');
    public $pageSize = 5;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = Input::only('page', 'type');

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;
        $lists = Feedback::where(function($q)
            {
                if (Input::get('type')) {
                    $q->whereType(Input::get('type'));
                }

            })->orderBy('created_at', 'DESC')->paginate($this->pageSize);

        $typeEnum = $this->typeEnum;
        return $this->adminView('feedback.index', compact('query', 'lists', 'typeEnum'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // return $this->adminView('feedback.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // $query = Input::only('receiver_id', 'content', 'name', 'type', 'page');

        // // 当前页数
        // if( !is_numeric($query['page']) || $query['page'] < 1 )
        //     $query['page'] = 1;

        // if ($query['name']) {
        //     $user = User::whereName($query['name'])->first();
        //     if (!$user) {
        //         return $this->adminPrompt("未找到收件人", '', $url = "message/create");
        //     } else {
        //         $query['receiver_id'] = $user->id;
        //     }
        // }
        // $validator = Validator::make($query,
        //     array(
        //         'receiver_id'      => 'numeric|required',
        //         'content' => 'alpha_dash|required',
        //         'name' => 'alpha_dash',
        //     )
        // );

        // if($validator->fails())
        // {
        //     return $this->adminPrompt("查找失败", $validator->messages()->first(), $url = "message");
        // }
        // $message = new Message();
        // $message->sender_id = Session::get('uid');
        // $message->receiver_id = $query['receiver_id'];
        // $message->content = $query['content'];
        // $message->created_at = date("Y-m-d H:i:s");
        // $message->type = $query['type'];
        // $message->save();
        // return $this->adminPrompt("操作成功", $validator->messages()->first(), $url = "message");
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $feedback = Feedback::find($id);
        $typeEnum = $this->typeEnum;
        return $this->adminView('feedback.show', compact('feedback', 'typeEnum'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
        echo "hahah";
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
        // $query = Input::only('id','status');
        // // dd($data);
        // $validator = Validator::make($query,
        //     array(
        //         'id'      => 'numeric|required',
        //         'status'  => 'numeric',
        //     )
        // );
        // if($validator->fails())
        // {
        //     return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "message");
        // }
        // $message = Message::find($id);
        // if ($query['status']) $message->status = $query['status'];

        // $message->save();
        // return Redirect::to('admin/message');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        Feedback::destroy($id);
        return Redirect::to('admin/feedback');
    }


}
