<?php

class MessageController extends BaseController {

    public $pageSize = 30;

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

        if (!isset($query['column_id'])) {
            $query['column_id'] = 3;
        }

        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        $lists = Message::where(function($q){
            $q->Where('receiver_id', Session::get('uid'));
                // ->orWhere('sender_id', Session::get('uid'));
        })->where(function($q)
            {
                if (strlen(Input::get('status')) > 0) {
                    $q->whereStatus(Input::get('status'));
                }
                if (strlen(Input::get('type')) > 0) {
                    $q->whereStatus(Input::get('type'));
                }

            })->orderBy('created_at', 'DESC')->paginate($this->pageSize);

        // $statusEnum = $this->statusEnum;
        // $typeEnum = $this->typeEnum;
        return $this->indexView('message.index', compact('query', 'lists', 'columns'));
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

        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        $user = User::find($query['receiver_id']);
        return $this->indexView('message.create', compact('user','columns', 'query'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $query = Input::only('receiver_id', 'content', 'column_id', 'dialog');
        $validator = Validator::make($query,
            array(
                'receiver_id'      => 'numeric|required',
                'content' => 'required',
                // 'name' => 'alpha_dash',
            )
        );

        if($validator->fails())
        {
            return Redirect::to('/message/create?receiver_id='.$query['receiver_id']."&column_id=".$query['column_id'])->withErrors($validator)->withInput($query);
        }
        $message = new Message();
        $message->sender_id = Session::get('uid');
        $message->receiver_id = $query['receiver_id'];
        $message->content = $query['content'];
        $message->created_at = date("Y-m-d H:i:s");
        $message->type = 1;
        $message->dialog = $query['dialog'];
        $message->save();
        return Redirect::to('/message?column_id=' . $query['column_id']);
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
            })->orderBy('created_at', 'asc')->get();
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        return $this->indexView('message.show', compact('message', 'messages', 'columns', 'query'));

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

}
