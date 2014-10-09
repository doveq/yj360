<?php namespace Admin;
use View;
use Session;
use Subject;
use SubjectItem;
use SubjectContent;
use Validator;
use Input;
use Paginator;

class ItemContentController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $query = Input::only('subject_id', 'page');
        //$query = array_filter($query); // 删除空值

        // dd($query);
        $validator = Validator::make($query,
            array(
                'subject_id'    => 'numeric|required',
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("访问失败", $validator->messages()->first(), $url = "subject");
        }

        $subject = Subject::find($query['subject_id']);
        $items = $subject->items;
        return $this->adminView('item_content.index', compact('subject','items','query'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        $query = Input::only('subject_id', 'subject_item_id');
        $validator = Validator::make($query,
            array(
                'subject_id'    => 'numeric|required',
                'subject_item_id'    => 'numeric|required',
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("访问失败", $validator->messages()->first(), $url = "subject");
        }

        $subject = Subject::find($query['subject_id']);
        $items = $subject->items;
        $subject_item = SubjectItem::find($query['subject_item_id']);

        return $this->adminView('item_content.create', compact('subject', 'items', 'subject_item', 'query'));
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
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "subject");
        }
        $subjectcontent = new SubjectContent();
        $subjectcontent->name = $data['name'];
        $subjectcontent->pic = $data['pic'];
        $subjectcontent->description = $data['description'];
        $subjectcontent->created_at = $data['created_at'];
        $subjectcontent->subject_item_id = $data['subject_item_id'];
        $subjectcontent->save();
        if ($subjectcontent->save()) {
            return $this->adminPrompt("操作成功", $validator->messages()->first(), $url = "subject");
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
        $subject = Subject::find($id);
        $items = $subject->items;
        return $this->adminView('subject_content.edit', compact('subject','items'));
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
