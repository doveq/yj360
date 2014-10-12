<?php namespace Admin;

use View;
use Session;
use Subject;
use SubjectItem;
use SubjectItemRelation;
use Validator;
use Input;
use Redirect;


class SubjectItemRelationController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        echo "haha";
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        return $this->adminView('subject_item_relation.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
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
        $subject = Subject::find($id);
        $subject_items = SubjectItem::all();
        // $relations = SubjectItemRelation::where('subject_id', '=', $id)->get();
        $items = $subject->items;
        // var_dump($relations);
        $tmp = array();
        foreach ($items as $key => $item) {
            $tmp[] = $item->id;
        }

        foreach ($subject_items as $key => $subject_item) {
            if (in_array($subject_item->id, $tmp)) {
                $subject_item->checked = 1;
            } else {
                $subject_item->checked = 0;
            }
            $subject_items[$key] = $subject_item;
        }
        return $this->adminView('subject_item_relation.edit', compact('subject', 'subject_items'));
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
        $query = Input::all();

        $cur_ids = array();
        $subject = Subject::find($id);
        foreach($subject->items as $list){
          $cur_ids[] = $list->id;
        }
        $a = array_diff($query['relations'], $cur_ids);
        $b = array_diff($cur_ids, $query['relations']);
        //detach IDs
        if (!empty($b)) $subject->items()->detach($b);
        //add new IDs
        if (!empty($a)) $subject->items()->attach($a);
        // echo "ok";
        return $this->adminPrompt("编辑成功", '', $url = "item_content?subject_id=" . $id);

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
