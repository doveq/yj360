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
        // dd($items);
        $subjects = Subject::all();
        return $this->adminView('item_content.index', compact('subject','subjects','items', 'query'));
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
