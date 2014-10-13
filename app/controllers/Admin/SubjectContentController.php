<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;

use Subject;
use SubjectItem;
use SubjectContent;

class SubjectContentController extends \BaseController {

    public $statusEnum = array('所有状态', '0' => '准备发布', '1' => '已发布', '-1' => '下线');

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pageSize = 20;  // 每页显示条数
        $query = Input::only('name', 'subject_id', 'subject_item_id', 'page');
        $query['pageSize'] = $pageSize;

        // 当前页数
        if( !isset($query['page']) || !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $validator = Validator::make($query,
            array(
                'subject_id'    => 'numeric|required',
                'subject_item_id'    => 'numeric|required',
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("访问失败", $validator->messages()->first(), $url = "subject_content");
        }
        $subject_contents = new SubjectContent();
        $info = $subject_contents->getList($query);

        // 分页
        $paginator = Paginator::make($info['data'], $info['total'], $pageSize);
        unset($query['pageSize']); // 减少分页url无用参数
        $paginator->appends($query);  // 设置分页url参数

        $subject_item = SubjectItem::find($query['subject_item_id']);


        $subject = Subject::find($query['subject_id']);
        $subject_items = $subject->items;
        $contents = $info['data'];
        $statusEnum = $this->statusEnum;
        return $this->adminView('subject_content.index', compact('subject_item','contents','subject', 'subject_items', 'query', 'paginator', 'statusEnum'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
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
        $subject_items = $subject->items;
        $subject_item = SubjectItem::find($query['subject_item_id']);

        return $this->adminView('subject_content.create', compact('subject', 'subject_item','subject_items','query'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
        $query = Input::all();
        $query['created_at'] = date("Y-m-d H:i:s");
        $validator = Validator::make($query ,
            array('name' => 'required',
                'subject_id'    => 'numeric|required',
                'subject_item_id'    => 'numeric|required',
                )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(),
                $url = "subject_content?subject_id=".$query['subject_id']."&subject_item_id=".$query['subject_item_id']);
        }
        $subjectcontent                  = new SubjectContent();
        $subjectcontent->name            = $query['name'];
        $subjectcontent->pic             = $query['pic'];
        $subjectcontent->description     = $query['description'];
        $subjectcontent->created_at      = $query['created_at'];
        $subjectcontent->subject_id      = $query['subject_id'];
        $subjectcontent->subject_item_id = $query['subject_item_id'];
        if ($subjectcontent->save()) {
            return $this->adminPrompt("操作成功", $validator->messages()->first(),
                $url = "subject_content?subject_id=".$query['subject_id']."&subject_item_id=".$query['subject_item_id']);
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
        $subject_content = SubjectContent::find($id);
        // $items = $subject->items;
        $subject = Subject::find($subject_content->subject_id);
        $subject_items = $subject->items;
        $subject_item = SubjectItem::find($subject_content->subject_item_id);
        $statusEnum = $this->statusEnum;
        return $this->adminView('subject_content.edit', compact('subject_content','subject','subject_items','subject_item','statusEnum'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $query = Input::only('name', 'desc', 'status');

        $validator = Validator::make($query ,
            array(
                // 'name' => 'alpha_dash',
                // 'desc' => 'alpha_dash',
                // 'online_at' => 'date',
                'status' => 'numeric'
                )
        );
        $subject_content = SubjectContent::find($id);

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(),
                $url = "subject_content?subject_id=".$subject_content->subject_id."&subject_item_id=".$subject_content->subject_item_id);
        }

        if (isset($query['name'])) $subject_content->name           = $query['name'];
        if (isset($query['desc'])) $subject_content->description    = $query['desc'];
        if (isset($query['status'])) $subject_content->status       = $query['status'];

        $subject_content->save();

        return $this->adminPrompt("操作成功", $validator->messages()->first(),
            $url = "subject_content?subject_id=".$subject_content->subject_id."&subject_item_id=".$subject_content->subject_item_id);

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
