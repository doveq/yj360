<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;

use Favorite;
use User;

class FavoriteController extends \BaseController {

    public $pageSize = 30;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = Input::only('page');

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;
        $lists = Favorite::where(function($q){
            if (Input::get('user_id')) {
                $q->whereUserId(Input::get('user_id'));
            }
        })->orderBy('created_at', 'DESC')->paginate($this->pageSize);

        return $this->adminView('favorite.index', compact('query', 'lists'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // return $this->adminView('message.create');
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
        // $message = Message::find($id);
        // //更新状态
        // $message->status = 1;
        // $message->save();
        // return $this->adminView('message.show', compact('message'));

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
        Favorite::destroy($id);
        return Redirect::to('admin/favorite');
    }


}
