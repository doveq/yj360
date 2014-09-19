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
        $relations = $subject->relation;
        // var_dump($relations);
        $tmp = array();
        foreach ($relations as $key => $relation) {
            $tmp[] = $relation->id;
        }
        // $relas = array_fetch($relations, 'id');
        // dd($relas);
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
        $data = Input::all();
        SubjectItemRelation::where('subject_id', '=', $id)->delete();
        // var_dump($data['relations']);
        if (count($data['relations']) > 0) {
            foreach ($data['relations'] as $key => $relation) {
                // var_dump($relation);
                SubjectItemRelation::insertGetId(array('subject_id' => $id, 'subject_item_id' => $relation));
            }
        }
        // echo "ok";
        return $this->adminPrompt("编辑成功", '', $url = "subject");

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
