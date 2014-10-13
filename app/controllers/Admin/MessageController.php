<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;

use Message;
use User;

class MessageController extends \BaseController {

    public $statusEnum = array('' => '所有状态', '0' => '未读', '1' => '已读', '-1' => '已删除');
    public $typeEnum = array('0' => '系统信息', '1' => '私信');
    public $pageSize = 30;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = Input::only('page','status','type');

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;
        $lists = Message::whereReceiverId(Session::get('uid'))->where(function($q)
            {
                if (Input::get('status') == "0") {
                    $q->whereStatus(0);
                } else if (Input::get('status') == '1') {
                    $q->whereStatus(1);
                } else if (Input::get('status') == '-1') {
                    $q->whereStatus(-1);
                }
                if (Input::get('type') == "0") {
                    $q->whereType(0);
                } else if (Input::get('type') == '1') {
                    $q->whereType(1);
                } else if (Input::get('type') == '-1') {
                    $q->whereType(-1);
                }

            })->orderBy('created_at', 'DESC')->paginate($this->pageSize);

        $statusEnum = $this->statusEnum;
        $typeEnum = $this->typeEnum;
        return $this->adminView('message.index', compact('query', 'statusEnum', 'lists', 'typeEnum'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->adminView('message.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $query = Input::only('receiver_id', 'content', 'name', 'type', 'page');

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        if ($query['name']) {
            $user = User::whereName($query['name'])->first();
            if (!$user) {
                return $this->adminPrompt("未找到收件人", '', $url = "message/create");
            } else {
                $query['receiver_id'] = $user->id;
            }
        }
        $validator = Validator::make($query,
            array(
                'receiver_id'      => 'numeric|required',
                'content' => 'alpha_dash|required',
                'name' => 'alpha_dash',
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("提交失败", $validator->messages()->first(), $url = "message");
        }
        $message = new Message();
        $message->sender_id = Session::get('uid');
        $message->receiver_id = $query['receiver_id'];
        $message->content = $query['content'];
        $message->created_at = date("Y-m-d H:i:s");
        $message->type = $query['type'];
        $message->save();
        return $this->adminPrompt("操作成功", $validator->messages()->first(), $url = "message");
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $message = Message::find($id);
        //更新状态
        $message->status = 1;
        $message->save();
        return $this->adminView('message.show', compact('message'));

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
        $query = Input::only('id','status');
        // dd($data);
        $validator = Validator::make($query,
            array(
                'id'      => 'numeric|required',
                'status'  => 'numeric',
            )
        );
        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "message");
        }
        $message = Message::find($id);
        if ($query['status']) $message->status = $query['status'];

        $message->save();
        return Redirect::to('admin/message');
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
        Message::destroy($id);
        return Redirect::to('admin/message');
    }


}
