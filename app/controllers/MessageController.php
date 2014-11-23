<?php

class MessageController extends BaseController {

    public $pageSize = 10;

    public function __construct()
    {
        $query = Input::only('column_id');

        if ((!isset($query['column_id']) || !is_numeric($query['column_id'])) && Request::path() != 'column/static') {
            echo ("<script>window.location.href='/column/static';</script>");
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = Input::only('page','status','type','column_id');

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        // $lists = Message::where(function($q){
        //     $q->Where('receiver_id', Session::get('uid'));
        //         // ->orWhere('sender_id', Session::get('uid'));
        // })->where(function($q)
        //     {
        //         if (strlen(Input::get('status')) > 0) {
        //             $q->whereStatus(Input::get('status'));
        //         }
        //         if (strlen(Input::get('type')) > 0) {
        //             $q->whereStatus(Input::get('type'));
        //         }

        //     })->orderBy('created_at', 'DESC')->paginate($this->pageSize);

        $send_users = Message::whereSenderId(Session::get('uid'))->select('receiver_id')->distinct()->get();
        $s = array();
        foreach ($send_users as $key => $value) {
            // echo $value->receiver_id . "\n\r";
            $s[] = $value->receiver_id;
        }

        $receiv_users = Message::whereReceiverId(Session::get('uid'))->select('sender_id')->distinct()->get();
        foreach ($receiv_users as $key => $value) {
            // echo $value->receiver_id . "\n\r";
            $s[] = $value->sender_id;
        }

        // $m = Message::where(function($q) use ($s) {
        //     $q->whereSenderId(Session::get('uid'))
        //         ->whereIn('receiver_id', $s);
        // })->orWhere(function($q) use ($s){
        //     $q->whereReceiverId(Session::get('uid'))
        //         ->whereIn('sender_id', $s);
        // })->groupBy('sender_id', 'receiver_id')->orderBy('created_at', 'desc')->get();

        $ids = implode(",", $s);
        $m = DB::select('select * from (select * from message where (`sender_id` = '.Session::get('uid').' and `receiver_id` in ('.$ids.')) or (sender_id in ('.$ids.') and receiver_id='.Session::get('uid').') order by id desc) temp group by sender_id, receiver_id order by created_at desc');

        // $lists = array();
        $tmp = array();
        $xx = array();
        foreach ($m as $key => $value) {
            if ($value->sender_id < $value->receiver_id) {
                $x = $value->sender_id."-".$value->receiver_id;
            } else {
                $x = $value->receiver_id."-".$value->sender_id;
            }
            if (!isset($tmp[$x])) {
                $tmp[$x] = 1;
                // $lists[$key] = $value;
                $xx[] = $value->id;
            }
        }
        $lists = Message::whereIn('id', $xx)->orderBy('created_at', 'desc')->get();
        // dd($tmp);
// dd(count($lists));
        // 获取父类名页面显示
        $cn = new Column();
        $arr = $cn->getPath($query['column_id']);
        $columnHead = $arr[0];
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        return $this->indexView('message.index', compact('query', 'lists', 'columns', 'columnHead'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $query = Input::only('receiver_id', 'column_id');
        $validator = Validator::make($query,
            array(
                'receiver_id'      => 'numeric|required',
            )
        );

        if($validator->fails())
        {
            return Redirect::to('message')->withErrors($validator)->withInput($query);
        }
        if (!isset($query['column_id'])) {
            $query['column_id'] = 3;
        }

        // 获取父类名页面显示
        $cn = new Column();
        $arr = $cn->getPath($query['column_id']);
        $columnHead = $arr[0];
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        $user = User::find($query['receiver_id']);
        return $this->indexView('message.create', compact('user','columns', 'query', 'columnHead'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $query = Input::only('user_id', 'content', 'column_id', 'dialog', 'class_id');
        $validator = Validator::make($query,
            array(
                'user_id'      => 'numeric|required',
                'content' => 'required',
                // 'name' => 'alpha_dash',
            )
        );

        if($validator->fails())
        {
            return Redirect::to('/message/talk?column_id=' . $query['column_id'] . '&class_id=' .$query['class_id'].'&user_id='.$query['user_id'])->withErrors($validator)->withInput($query);
        }
        $message = new Message();
        $message->sender_id = Session::get('uid');
        $message->receiver_id = $query['user_id'];
        $message->content = $query['content'];
        $message->created_at = date("Y-m-d H:i:s");
        $message->type = 1;
        if (isset($query['dialog'])) $message->dialog = $query['dialog'];
        $message->save();
        return Redirect::to('/message/talk?column_id=' . $query['column_id'] . '&class_id=' .$query['class_id'].'&user_id='.$query['user_id']);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $query = Input::all();
        $message = Message::find($id);
        if ($message->status == 0) {
            $message->status = 1;
            $message->save();
        }
        // $messages = Message::whereSenderId($message->sender_id)->orWhere('receiver_id', $message->receiver_id)->orderBy('created_at')->get();
        $messages = Message::where(function($q) use ($message) {
            $q->whereSenderId($message->sender_id)
                ->orWhere('sender_id', $message->receiver_id);
            })->where(function($q) use ($message) {
                $q->whereReceiverId($message->receiver_id)
                ->orWhere('receiver_id', $message->sender_id);
            })->orderBy('created_at', 'dasc')->get();

        $msgs = array();
        foreach ($messages as $key => $value) {
            $msgs[] = $value->id;
        }
        Message::whereIn('id', $msgs)->update(array('status' => 1));
        // 获取父类名页面显示
        $cn = new Column();
        $arr = $cn->getPath($query['column_id']);
        $columnHead = $arr[0];
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        return $this->indexView('message.show', compact('message', 'messages', 'columns', 'query', 'columnHead'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // //
        // // echo "hahah";
        // $training = Training::find($id);
        // $statusEnum = $this->statusEnum;
        // $reses = User::where('type', 1)->select('id','name')->get()->toArray();
        // // $teachers = DB::table('users')->select('id','name')->get();
        // $teachers = array();
        // foreach ($reses as $key => $teacher) {
        //     $teachers[$teacher['id']] = $teacher['name'];
        // }
        // // dd($teachers);
        // return $this->adminView('training.edit', compact("training", "statusEnum", "teachers"));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        // //
        // $query = Input::only('id','name','status', 'user_id', 'memo');
        // // dd($data);
        // $validator = Validator::make($query,
        //     array(
        //         'id'      => 'numeric',
        //         // 'name'  => 'alpha_dash',
        //         'status'  => 'numeric',
        //         'user_id' => 'numeric',
        //     )
        // );
        // // dd($query['status']);
        // if($validator->fails())
        // {
        //     if (Request::ajax()) {
        //         return Response::json('error');
        //     } else {
        //         return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "training");
        //     }
        // }
        // if (isset($query['name']) && $query['name'] == '') {
        //     $errors = "名称不能为空";
        //     if (Request::ajax()) {
        //         return Response::json('error');
        //     } else {
        //         return Redirect::to('/admin/training/'.$id."/edit")->withErrors($errors)->withInput($query);
        //     }
        // }
        // $class = Training::find($id);
        // if (isset($query['name'])) $class->name           = $query['name'];
        // if (isset($query['user_id'])) $class->user_id = $query['user_id'];
        // if (isset($query['status'])) $class->status       = $query['status'];

        // if ($class->save()) {
        //     if (Request::ajax()) {
        //         return Response::json('ok');
        //     } else {
        //         return Redirect::to('/admin/training');
        //     }
        // }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $query = Input::only('column_id');
        Message::destroy($id);
        if (Request::ajax()) {
            return Response::json('ok');
        } else {
            return Redirect::to('/message?column_id='.$query['column_id']);
        }
    }


    public function talk()
    {
        $query = Input::only('column_id', 'user_id', 'class_id');

        $m = Message::where(function($q) use ($query) {
            $q->whereSenderId(Session::get('uid'))
                ->orWhere('sender_id', $query['user_id']);
            })->where(function($q) use ($query) {
                $q->whereReceiverId(Session::get('uid'))
                ->orWhere('receiver_id', $query['user_id']);
            })->orderBy('created_at', 'dasc');//->paginate($this->pageSize);

        // dd($m->count());
        $allnums = $m->count();
        $messages = $m->paginate($this->pageSize);
        if ($allnums > 0) {
            $msgs = array();
            foreach ($messages as $key => $value) {
                $msgs[] = $value->id;
            }
            Message::whereIn('id', $msgs)->update(array('status' => 1));
        }

        $classes = Classes::find($query['class_id'])->first();
        $user = User::whereId($query['user_id'])->first();

        // 获取父类名页面显示
        $columnHead = Column::whereId($query['column_id'])->first();;
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        return $this->indexView('message.talk', compact('messages', 'columns', 'query', 'columnHead', 'classes', 'user', 'allnums'));
    }

    public function deleteAll()
    {
        $query = Input::only('column_id', 'user_id', 'class_id');
        $m = Message::where(function($q) use ($query) {
            $q->whereSenderId(Session::get('uid'))
                ->orWhere('sender_id', $query['user_id']);
            })->where(function($q) use ($query) {
                $q->whereReceiverId(Session::get('uid'))
                ->orWhere('receiver_id', $query['user_id']);
            })->delete();

        if (Request::ajax()) {
            return Response::json('ok');
        }
    }

}
