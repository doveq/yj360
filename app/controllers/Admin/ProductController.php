<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;

use Product;
use Column;
use ColumnQuestionRelation;
use ProductQuestionRelation;

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
        $lists = Product::with('column')->where(function($q){
            if (strlen(Input::get('status')) > 0) {
                $query->whereStatus(Input::get('status'));
            }
            if (Input::get('name')) {
                $query->where('name', 'LIKE', '%'.Input::get('name').'%');
            }
            // if (Input::get('column_id')) {
            //     $query->whereColumnId(Input::get('column_id'));
            // }
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
        $query = Input::only('column_id');
        $validator = Validator::make($query ,
            array(
                'column_id' => 'numeric|required',
                )
        );

        if($validator->fails())
        {
            return Redirect::to('/admin/product')->withErrors($validator)->withInput($query);
        }
        $column = Column::find($query['column_id']);
        $questions = $column->questions;
        // dd($questions);
        $policyEnum = $this->policyEnum;
        return $this->adminView('product.create', compact('policyEnum', 'column', 'questions'));
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
                'price' => 'numeric|required',
                'column_id' => 'numeric|required',
                )
        );

        if($validator->fails())
        {
            return Redirect::to('/admin/product/create?column_id='.$column_id)->withErrors($validator)->withInput($query);
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
        $product->column_id                                 = $query['column_id'];
        if (isset($query['period'])) $product->valid_period = $query['period'];
        if (isset($query['filename'])) $product->thumbnail  = $query['filename'];
        $product->created_at                                = date("Y-m-d H:i:s");
        $product->status                                    = 0;
        $product->policy                                    = $query['policy'];

        if ($product->save()) {
            $newProductId = $product->id;
        }
        //如果有免费题目,保存
        if ($query['policy'] == 1 && $query['question']) {
            foreach ($query['question'] as $key => $qid) {
                // $pqr = new ProductQuestionRelation();
                $pqr = ProductQuestionRelation::firstOrCreate(array('question_id' => $qid, 'product_id' => $newProductId));
                $pqr->product_id = $newProductId;
                $pqr->question_id = $qid;
                $pqr->created_at = date("Y-m-d H:i:s");
                $pqr->save();
            }
        }
        return Redirect::to('/admin/product');

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
        // $questions = ColumnQuestionRelation::whereColumnId($product->column_id)->orderBy('created_at', 'DESC')->get();
        // $check_questions = ProductQuestionRelation::whereProductId($id)->select('question_id')->get()->toArray();
        // $free_questions = array_flatten($check_questions);
        // dd($free_questions);
        $questions = Column::find($product->column->id)->questions;
        $free_questions = array_flatten($product->questions->toArray());
        return $this->adminView('product.edit', compact('product', 'policyEnum', 'questions', 'free_questions'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $query = Input::only('name', 'price', 'period', 'thumbnail', 'policy', 'status', 'column_id', 'question');

        $validator = Validator::make($query ,
            array(
                'name'      => 'requiredwith:name',
                'thumbnail' => 'image',
                'column_id'    => 'numeric',
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
        // dd($product->questions->toArray());

        if (isset($query['name'])) $product->name           = $query['name'];
        if (isset($query['price'])) $product->price         = $query['price'];
        if (isset($query['period'])) $product->valid_period = $query['period'];
        if (isset($query['filename'])) $product->thumbnail  = $query['filename'];
        if (isset($query['policy'])) $product->policy       = $query['policy'];
        if (isset($query['status'])) {
            $product->status       = $query['status'];
            if ($query['status'] == 1) {
                $product->online_at = date("Y-m-d H:i:s");
            } else {
                $product->online_at = null;
            }
        }

        $product->save();
        //如果有免费题目,保存
        if ($query['policy'] == 1 && $query['question']) {
            $cur_ids = array();
            foreach($product->questions as $list){
              $cur_ids[] = $list->id;
            }
            $a = array_diff($query['question'], $cur_ids);
            $b = array_diff($cur_ids, $query['question']);
            //detach IDs
            if (!empty($b)) $product->questions()->detach($b);
            //add new IDs
            if (!empty($a)) $product->questions()->attach($a);
        }
        return Redirect::to('/admin/product');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        Product::find($id)->questions()->detach();
        Product::find($id)->delete();
        return Redirect::to('/admin/product');
    }


}
