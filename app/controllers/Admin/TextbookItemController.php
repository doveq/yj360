<?php namespace Admin;
use View;
use Session;
use TextbookItem;
use Validator;
use Input;
use Paginator;
use Redirect;

class TextbookItemController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pageSize = 20;  // 每页显示条数

        $query = Input::only('name', 'page');
        $query['pageSize'] = $pageSize;
        //$query = array_filter($query); // 删除空值

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $validator = Validator::make($query,
            array(
                'name'      => 'alpha_dash',
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("访问失败", $validator->messages()->first(), $url = "textbook_item");
        }

        $textbook_item = new TextbookItem();
        $data = $textbook_item->getList($query);

        // 分页
        $paginator = Paginator::make($data['data'], $data['total'], $pageSize);
        unset($query['pageSize']); // 减少分页url无用参数
        $paginator->appends($query);  // 设置分页url参数
// dd($textbook_items);
        $textbook_items = $data['data'];
        return $this->adminView('textbook_item.index', compact('textbook_items','query', 'paginator'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->adminView('textbook_item.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
        $data = Input::all();
        // $data['online_at'] = date("Y-m-d H:i:s");
        $data['created_at'] = date("Y-m-d H:i:s");
        // $data['status'] = 0;
        $validator = Validator::make($data ,
            array('name' => 'required'
                )
        );
        // dd($data);
        // unset($data['pic']);

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "textbook_item/create");
        }
        $textbook_item = new TextbookItem();
        $textbook_item->name = $data['name'];
        $textbook_item->created_at = $data['created_at'];
        // $textbook_item->save();
        if ($textbook_item->save()) {
            return $this->adminPrompt("操作成功", $validator->messages()->first(), $url = "textbook_item");
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
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
        $textbook_item = TextbookItem::find($id);
        return $this->adminView('textbook_item.edit', compact('textbook_item'));
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
        $data = Input::only('name');
        // dd($data);
        $validator = Validator::make($data,
            array(
                'name'      => 'required|alpha_dash',
            )
        );
        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "textbook_item");
        }
        $textbook_item = TextbookItem::find($id);
        $textbook_item->name = $data['name'];
        // dd($data);
        // dd($textbook_item);
        $textbook_item->save();

        return $this->adminPrompt("保存成功", $validator->messages()->first(), $url = "textbook_item");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        TextbookItem::destroy($id);
        return Redirect::to('admin/textbook_item');
    }


}
