<?php namespace Admin;
use View;
use Session;
use User;
use Validator;
use Input;
use Paginator;

class SubjectController extends \BaseController {

    public $statusEnum = array('0' => '准备发布', '1' => '已发布', '-1' => '下线');

    public function showList()
    {
        $pageSize = 2;  // 每页显示条数

        $query = Input::only('name', 'desc', 'online_at', 'status', 'page');
        $query['pageSize'] = $pageSize;
        //$query = array_filter($query); // 删除空值

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $validator = Validator::make($query,
            array('name' => 'alpha_dash',
                'desc' => 'alpha_dash',
                'online_at' => 'numeric',
                'status' => 'numeric')
        );

        if($validator->fails())
        {
            return $this->adminPrompt("查找失败", $validator->messages()->first(), $url = "subjectList");
        }

        // $user = new User();
        // $info = $user->getList($query);
        $info = array(
            'data' => array(
                    array(
                        'id' => '1',
                        'name'=>'音基初级考试',
                        'desc' => '初级的考试,很简单哦',
                        'online_at' => '2014-09-15',
                        'status'=> 0
                        ),
                    array(
                        'id' => '2',
                        'name'=>'音基中级考试',
                        'desc' => '中级的考试,也很简单哦',
                        'online_at' => '2014-09-15',
                        'status'=> 1
                        ),
                    array(
                        'id' => '3',
                        'name'=>'音基高级考试',
                        'desc' => '高级的考试,很难哦',
                        'online_at' => '2014-09-13',
                        'status'=> -1
                        ),
            ),
            'total' => 3
        );


        // 分页
        $paginator = Paginator::make($info['data'], $info['total'], $pageSize);
        unset($query['pageSize']); // 减少分页url无用参数
        $paginator->appends($query);  // 设置分页url参数

        $p = array('list' => $info['data'],
            // 'typeEnum' => $this->typeEnum,
            'statusEnum' => $this->statusEnum,
            'query' => $query,
            'paginator' => $paginator );

        return $this->adminView('subjectList', $p);
    }

    public function showAdd()
    {
        $p = array(
            // 'typeEnum' => $this->typeEnum,
            'statusEnum' => $this->statusEnum,
            );
        return $this->adminView('subjectAdd', $p);
    }

    public function doEdit()
    {
        $data = Input::all();
        $validator = Validator::make($data ,
            array('id' => 'required|integer',
                'type' => 'required|numeric',
                'status' => 'required|numeric')
        );

        if($validator->fails())
        {
            dd( $validator->messages()->all() );
        }

        $user = new User();
        $user->setInfo($data['id'], array('type' => $data['type'], 'status' => $data['status']) );

        echo "跟新成功！";
    }

    public function doDel()
    {
        $data = Input::all();
        $validator = Validator::make($data , array('id' => 'required|integer') );

        if($validator->fails())
        {
            dd( $validator->messages()->all() );
        }

        $user = new User();
        $user->del($data['id']);

        echo "删除成功！";
    }

}
