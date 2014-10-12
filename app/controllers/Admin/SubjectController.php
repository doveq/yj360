<?php namespace Admin;
use View;
use Session;
use Subject;
use Validator;
use Input;
use Paginator;
use Redirect;

class SubjectController extends \BaseController {

    public $statusEnum = array('所有状态', '0' => '准备发布', '1' => '已发布', '-1' => '下线');
    public $pageSize = 30;

    public function index()
    {
        $query = Input::only('name', 'desc', 'online_at', 'status', 'page');
        $query['pageSize'] = $this->pageSize;
        //$query = array_filter($query); // 删除空值

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;
        // dd($query);
        $validator = Validator::make($query,
            array(
                'name'      => 'alpha_dash',
                'desc'      => 'alpha_dash',
                'online_at' => 'date',
                'status'    => 'numeric'
            )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("查找失败", $validator->messages()->first(), $url = "subject");
        }

        $subject = new Subject();
        $info = $subject->getList($query);

        // 分页
        $paginator = Paginator::make($info['data'], $info['total'], $this->pageSize);
        $paginator->appends($query);  // 设置分页url参数

        $p = array('list' => $info['data'],
            'statusEnum' => $this->statusEnum,
            'query' => $query,
            'paginator' => $paginator );

        return $this->adminView('subject.index', $p);
    }

    public function create()
    {
        $p = array(
            // 'typeEnum' => $this->typeEnum,
            'statusEnum' => $this->statusEnum,
            );
        return $this->adminView('subject.create', $p);
    }

    public function store()
    {
        $data = Input::all();
        // $data['online_at'] = date("Y-m-d H:i:s");
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['status'] = 0;
        $validator = Validator::make($data ,
            array('name' => 'required'
                )
        );

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "subject/create");
        }
        $subject = new Subject();
        if ($subject->add($data)) {
            return $this->adminPrompt("操作成功", $validator->messages()->first(), $url = "subject");
        }

    }

    public function edit($id)
    {
        $validator = Validator::make(array('id' => $id) ,
            array('id' => 'required|integer',)
        );

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "subject");
        }

        $subject = new Subject();
        $data = $subject->getInfoById($id);
        return $this->adminView('subject.edit', array('subject' => $data, 'statusEnum' => $this->statusEnum));
    }

    public function update($id)
    {
        $query = Input::only('name', 'desc', 'online_at', 'status');

        $validator = Validator::make($query ,
            array('name' => 'alpha_dash',
                // 'desc' => 'alpha_dash',
                // 'online_at' => 'date',
                'status' => 'numeric')
        );

        if($validator->fails())
        {
            return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "subject");
        }

        $subject = Subject::find($id);

        if (isset($query['name'])) $subject->name           = $query['name'];
        if (isset($query['desc'])) $subject->description    = $query['desc'];
        if (isset($query['online_at'])) $subject->online_at = $query['online_at'];
        if (isset($query['status'])) $subject->status       = $query['status'];
        if (isset($query['created_at'])) $subject->created_at       = $query['created_at'];

        $subject->save();

        return $this->adminPrompt("操作成功", $validator->messages()->first(), $url = "subject");

    }

    public function destroy($id)
    {
        Subject::destroy($id);
        return Redirect::to('admin/subject');
    }

}
