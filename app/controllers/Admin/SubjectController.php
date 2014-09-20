<?php namespace Admin;
use View;
use Session;
use Subject;
use Validator;
use Input;
use Paginator;
use Redirect;

class SubjectController extends \BaseController {

    public $statusEnum = array('0' => '准备发布', '1' => '已发布', '-1' => '下线');

    public function index()
    {
        $pageSize = 20;  // 每页显示条数

        $query = Input::only('name', 'desc', 'online_at', 'status', 'page');
        $query['pageSize'] = $pageSize;
        //$query = array_filter($query); // 删除空值

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

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
        $paginator = Paginator::make($info['data'], $info['total'], $pageSize);
        unset($query['pageSize']); // 减少分页url无用参数
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
        $data = Input::only('name', 'desc', 'online_at', 'status');

        $validator = Validator::make($data ,
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

        if (isset($data['name'])) $subject->name           = $data['name'];
        if (isset($data['desc'])) $subject->description    = $data['desc'];
        if (isset($data['online_at'])) $subject->online_at = $data['online_at'];
        if (isset($data['status'])) $subject->status       = $data['status'];
        if (isset($data['created_at'])) $subject->created_at       = $data['created_at'];

        $subject->save();

        return $this->adminPrompt("操作成功", $validator->messages()->first(), $url = "subject");

    }

    public function destroy($id)
    {
        Subject::destroy($id);
        return Redirect::to('admin/subject');
    }

}
