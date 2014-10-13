<?php namespace Admin;
use View;
use Session;
use Product;
use Subject;
use Validator;
use Input;
use Paginator;
use Redirect;

class ProductController extends \BaseController {

    public $statusEnum = array('' => '所有状态', '0' => '准备发布', '1' => '已发布', '-1' => '下线');
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pageSize = 20;  // 每页显示条数

        // $query = Input::all();
        $query = Input::only('name', 'status', 'page', 'subject_id');

        $query['pageSize'] = $pageSize;
        //$query = array_filter($query); // 删除空值

        // 当前页数
        if( !isset($query['page']) || !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        // dd($query);
        $validator = Validator::make($query,
            array(
                // 'name'      => 'alpha_dash',
                'subject_id'      => 'numeric',
                'status'    => 'numeric'
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("查找失败", $validator->messages()->first(), $url = "product");
        }

        $product = new Product();
        $lists = $product->getList($query);
        $products = $lists['data'];

        $subjects_list = Subject::all();
        $subjects = array('' => '所有科目');
        foreach ($subjects_list as $key => $subject) {
            # code...
            $subjects[$subject->id] = $subject->name;
        }

        // 分页
        $paginator = Paginator::make($products, $lists['total'], $pageSize);
        unset($query['pageSize']); // 减少分页url无用参数
        $paginator->appends($query);  // 设置分页url参数
        $statusEnum = $this->statusEnum;
        return $this->adminView('product.index', compact('products','subjects','query', 'paginator', 'statusEnum'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return $this->adminView('product.create');
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
            return Redirect::to('admin/product/create')->withErrors($validator);
        }
        $product = new Product();
        if ($product->add($data)) {
            return $this->adminPrompt("添加成功", $validator->messages()->first(), $url = "product");
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
    }


}
