<?php namespace Admin;
use View;
use Session;
use SubjectItem;
use Validator;
use Input;
use Paginator;
use Redirect;


class SubjectItemController extends \BaseController {

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

        // $validator = Validator::make($query,
        //     array(
        //         'name'      => 'alpha_dash',
        //     )
        // );

        // if($validator->fails())
        // {
        //     return $this->adminPrompt("查找失败", $validator->messages()->first(), $url = "subject_item");
        // }

        $subject_item = new SubjectItem();
        $info = $subject_item->getList($query);

        // 分页
        $paginator = Paginator::make($info['data'], $info['total'], $pageSize);
        unset($query['pageSize']); // 减少分页url无用参数
        $paginator->appends($query);  // 设置分页url参数

        $p = array('list' => $info['data'],
            'query' => $query,
            'paginator' => $paginator );

        return $this->adminView('subject_item.index', $p);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return $this->adminView('subject_item.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // dd(Input::all());
        $data = Input::all();
        $data['created_at'] = date("Y-m-d H:i:s");
        $validator = Validator::make($data ,
            array('name' => 'required'
                )
        );

        if($validator->fails())
        {
            // return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "subject_item/create");
            return Redirect::to('admin/subject_item/create')
                ->withErrors($validator);
        }
        $subject_item = new SubjectItem();
        if ($subject_item->add($data)) {
            return $this->adminPrompt("添加成功", $validator->messages()->first(), $url = "subject_item");
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
        // echo "hahah";
        $subject_item = SubjectItem::find($id);
        // dd($info);
        return $this->adminView('subject_item.edit', compact("subject_item"));
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
                'name'      => 'required',
            )
        );
        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "subject_item");
        }
        $subject_item = SubjectItem::find($id);
        $subject_item->name = $data['name'];
        // dd($data);
        // dd($subject_item);
        $subject_item->save();

        return $this->adminPrompt("保存成功", $validator->messages()->first(), $url = "subject_item");
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
        SubjectItem::destroy($id);
        return Redirect::to('admin/subject_item');
    }


}
