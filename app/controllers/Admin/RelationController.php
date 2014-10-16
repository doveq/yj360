<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;
use Request;
use Response;

// use Sort;
// use Question;
use SortQuestionRelation;
use ColumnQuestionRelation;
use Question;

class RelationController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	}


	/**
	 * 题目批量加入到科目
	 *
	 * @return Response
	 */
	public function postColumn()
	{
		$query = Input::only('question_id', 'column_id');
        $validator = Validator::make($query,
            array(
                'question_id'   => 'required',
                'column_id' => 'required',
            )
        );
        if($validator->fails())
        {
            // return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "classes");
            $tmp = array('info' => '操作失败,请刷新重试');
            return Response::json($tmp);
        }
        if (!is_array($query['question_id'])) {
            $query['question_id'] = explode(",", $query['question_id']);
        }
        foreach ($query['question_id'] as $key => $qid) {
            $relation = ColumnQuestionRelation::firstOrCreate(array('question_id' => $qid));
            $relation->column_id = $query['column_id'];
            $relation->question_id = $qid;
            $relation->save();
        }
        $tmp = array('info' => '操作成功');
        return $response = Response::json($tmp);
        // return Redirect::to('/admin/classmate?class_id=' . $query['class_id']);
	}


	/**
	 * 题目批量加入到分类
	 *
	 * @return Response
	 */
	public function postSort()
	{
        $query = Input::only('question_id', 'sort_id');
        $validator = Validator::make($query,
            array(
                'question_id'   => 'required',
                'sort_id' => 'required',
            )
        );
        if($validator->fails())
        {
            // return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "classes");
            $tmp = array('error' => '操作失败,请刷新重试');
            return Response::json($tmp);
        }
        if (!is_array($query['question_id'])) {
            $query['question_id'] = explode(",", $query['question_id']);
        }
        foreach ($query['question_id'] as $key => $qid) {
            $relation = SortQuestionRelation::firstOrCreate(array('question_id' => $qid));
            $relation->sort_id = $query['sort_id'];
            $relation->question_id = $qid;
            $relation->save();
        }
        $tmp = array('info' => '操作成功');
        return $response = Response::json($tmp);
        // return Redirect::to('/admin/classmate?class_id=' . $query['class_id']);
	}

    /**
     * 题目批量下架
     *
     * @return Response
     */
    public function postDoQuestion()
    {
        $query = Input::only('question_id', 'status');
        $validator = Validator::make($query,
            array(
                'question_id'   => 'required',
                'status' => 'required',
            )
        );
        if($validator->fails())
        {
            // return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "classes");
            $tmp = array('error' => '操作失败,请刷新重试');
            return Response::json($tmp);
        }
        if (!is_array($query['question_id'])) {
            $query['question_id'] = explode(",", $query['question_id']);
        }
        Question::whereIn('id', $query['question_id'])->update(array('status' => $query['status']));
        $tmp = array('info' => '操作成功');
        return $response = Response::json($tmp);
    }


}
