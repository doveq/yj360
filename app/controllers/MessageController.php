<?php

class MessageController extends BaseController {

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

        if (!isset($query['column_id'])) {
            $query['column_id'] = 3;
        }

        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->get();
        $lists = Message::whereReceiverId(Session::get('uid'))->where(function($q)
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
        $query = Input::only('receiver_id');
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

        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->get();
        $user = User::find($query['receiver_id']);
        return $this->indexView('message.create', compact('user','columns'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $query = Input::only('receiver_id', 'content');
        $validator = Validator::make($query,
            array(
                'receiver_id'      => 'numeric|required',
                'content' => 'required',
                // 'name' => 'alpha_dash',
            )
        );

        if($validator->fails())
        {
            return Redirect::to('/message/create?receiver_id='.$query['receiver_id'])->withErrors($validator)->withInput($query);
        }
        $message = new Message();
        $message->sender_id = Session::get('uid');
        $message->receiver_id = $query['receiver_id'];
        $message->content = $query['content'];
        $message->created_at = date("Y-m-d H:i:s");
        $message->type = 1;
        $message->save();
        return Redirect::to('/message');
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
        if (!isset($query['column_id'])) {
            $query['column_id'] = 3;
        }
        $message->status = 1;
        $message->save();
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->get();
        return $this->indexView('message.show', compact('message', 'columns'));

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
        //
        Message::destroy($id);
        return Redirect::to('/message');
    }



    /* 发送手机短信 
        $mobile 手机号
        $msg 短信信息
    */
    public function mobileMsg()
    {
        $query = Input::only('mobile','code');

        // 信息格式必须备案才能发移动手机号
        $msg = "验证码：{$query['code']}（为了保证账户安全，请勿向他人泄漏）【音教360】";

        $cpmid = Config::get('app.mobile_cpid');
        $port = Config::get('app.mobile_port');
        $md5 = Config::get('app.mobile_md5');
        $post = Config::get('app.mobile_post');
        $timestamp = time();
        $signature = md5($md5 . $timestamp);

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
            <MtPacket>
            <cpid>{$cpmid}</cpid>
            <mid>0</mid>
            <cpmid>{$cpmid}</cpmid>
            <mobile>{$query['mobile']}</mobile>
            <port>{$port}</port>
            <msg>{$msg}</msg>
            <msgtype>1</msgtype>
            <signature>{$signature}</signature>
            <timestamp>{$timestamp}</timestamp>
            <validtime>1800</validtime>
            </MtPacket>
        ";

        $header[] = "Content-type: text/xml"; //定义content-type为xml
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $response = curl_exec($ch);

        /*
        if(curl_errno($ch))
        {
             curl_error($ch);
        }
        */
        curl_close($ch);

        $xml = simplexml_load_string($response);
        var_dump($xml);
        exit;

        // 发送成功
        if($xml->result == 0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
  }

}
