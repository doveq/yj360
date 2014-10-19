<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;

use Product;

class ProductController extends \BaseController {

    public $statusEnum = array('' => '所有状态', '0' => '准备发布', '1' => '已发布', '-1' => '下线');
    public $policyEnum = array('0' => '收费', '1' => '部分免费', '2' => '免费');
    public $pageSize = 30;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = Input::only('name', 'status', 'page', 'column_id');
        $validator = Validator::make($query,
            array(
                'subject_id' => 'numeric',
                'status'     => 'numeric'
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("查找失败", $validator->messages()->first(), $url = "product");
        }
        $lists = Product::where(function($q){
            if (strlen(Input::get('status')) > 0) {
                $query->whereStatus(Input::get('status'));
            }
            if (Input::get('name')) {
                $query->where('name', 'LIKE', '%'.Input::get('name').'%');
            }
            if (Input::get('column_id')) {
                $query->whereColumnId(Input::get('column_id'));
            }
        })->orderBy('id', 'DESC')->paginate($this->pageSize);

        $statusEnum = $this->statusEnum;
        $policyEnum = $this->policyEnum;
        return $this->adminView('product.index', compact('lists','query', 'statusEnum', 'policyEnum'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $policyEnum = $this->policyEnum;
        return $this->adminView('product.create', compact('policyEnum'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // dd(Input::all());
        $query = Input::all();
        $query['created_at'] = date("Y-m-d H:i:s");
        $validator = Validator::make($query ,
            array(
                'name' => 'required',
                'price' => 'required',
                )
        );

        if($validator->fails())
        {
            return Redirect::to('/admin/product/create')->withErrors($validator)->withInput($query);
        }
        if(Input::hasFile('thumbnail')) {
            // $originalName = Input::file('pic')->getClientOriginalName();
            $extension = Input::file('thumbnail')->getClientOriginalExtension();
            $filename = Str::random() . "." . $extension;
            $destinationPath = Config::get('app.thumbnail_dir');
            Input::file('thumbnail')->move($destinationPath, $filename);
            $query['filename'] = $filename;
        }
        $product                                            = new Product();
        $product->name                                      = $query['name'];
        $product->price                                     = $query['price'];
        if (isset($query['period'])) $product->valid_period = $query['period'];
        if (isset($query['filename'])) $product->thumbnail  = $query['filename'];
        $product->created_at                                = date("Y-m-d H:i:s");
        $product->status                                    = 0;
        $product->policy                                    = $query['policy'];
        if ($product->save()) {
            return Redirect::to('/admin/product');
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

        $product = Product::find($id);
        $policyEnum = $this->policyEnum;
        // dd($product);
        return $this->adminView('product.edit', compact('product', 'policyEnum'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $query = Input::only('name', 'price', 'period', 'thumbnail', 'policy', 'status');

        $validator = Validator::make($query ,
            array(
                'name'      => 'requiredwith:name',
                'thumbnail' => 'image',
                // 'status'    => 'numeric',
                'policy'      => 'numeric',
                )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "product");
        }
        if (isset($query['name']) && $query['name'] == '') {
            $errors = "名称不能为空";
            return Redirect::to('/admin/product/'.$id."/edit")->withErrors($errors)->withInput($query);
        }
        if(Input::hasFile('thumbnail')) {
            // $originalName = Input::file('pic')->getClientOriginalName();
            $extension = Input::file('thumbnail')->getClientOriginalExtension();
            $filename = Str::random() . "." . $extension;
            $destinationPath = Config::get('app.thumbnail_dir');
            Input::file('thumbnail')->move($destinationPath, $filename);
            $query['filename'] = $filename;
        }
        $product = Product::find($id);

        if (isset($query['name'])) $product->name           = $query['name'];
        if (isset($query['price'])) $product->price         = $query['price'];
        if (isset($query['period'])) $product->valid_period = $query['period'];
        if (isset($query['filename'])) $product->thumbnail  = $query['filename'];
        if (isset($query['policy'])) $product->policy       = $query['policy'];
        if (isset($query['status'])) $product->status       = $query['status'];

        if ($product->save() ) {
            return Redirect::to('/admin/product');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return Redirect::to('/admin/product');
    }


}
