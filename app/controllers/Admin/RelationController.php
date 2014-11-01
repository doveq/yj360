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
use SortQuestionRelation;
use ColumnQuestionRelation;
use Question;
use ExamQuestionRelation;

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
            // $relation = new ColumnQuestionRelation();
            $relation = ColumnQuestionRelation::firstOrCreate(array('question_id' => $qid, 'column_id' => $query['column_id']));
            $relation->column_id = $query['column_id'];
            $relation->question_id = $qid;
            $relation->created_at = date("Y-m-d H:i:s");
            $relation->save();
        }
        $tmp = array('info' => '操作成功');
        return $response = Response::json($tmp);
        // return Redirect::to('/admin/classmate?class_id=' . $query['class_id']);
	}

    /**
     * 科目里批量删除题目(删除关联)
     *
     * @return Response
     */
    public function deleteColumn()
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
            $tmp = array('info' => '操作失败,请刷新重试', 'status' => 0);
            return Response::json($tmp);
        }
        if (!is_array($query['question_id'])) {
            $query['question_id'] = explode(",", $query['question_id']);
        }
        foreach ($query['question_id'] as $key => $qid) {
            // $relation = new ColumnQuestionRelation();
            ColumnQuestionRelation::whereQuestionId($qid)->whereColumnId($query['column_id'])->delete();
        }
        $tmp = array('info' => '操作成功', 'status' => 1);
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
        $query = Input::only('question_id', 'status', 'cause');

        $cause = empty($query['cause']) ? "" : $query['cause'];

        $validator = Validator::make($query,
            array(
                'question_id'   => 'required',
                'status' => 'required',
            )
        );
        if($validator->fails())
        {
            // return $this->adminPrompt("参数错误", $validator->messages()->first(), $url = "classes");
            $tmp = array('error' => '操作失败,请刷新重试', 'status' => 0);
            return Response::json($tmp);
        }
        if (!is_array($query['question_id'])) {
            $query['question_id'] = explode(",", $query['question_id']);
        }
        Question::whereIn('id', $query['question_id'])->update(array('status' => $query['status'], 'cause' => $cause));
        $tmp = array('info' => '操作成功', 'status' => 1);
        return $response = Response::json($tmp);
    }


    /* 批量添加题目到试卷 */
    public function doExam()
    {
        $query = Input::only('question_id', 'id');
        $validator = Validator::make($query,
            array(
                'question_id'   => 'required',
                'id' => 'required',
            )
        );
        if($validator->fails())
        {
            $tmp = array('error' => '操作失败,请刷新重试');
            return Response::json($tmp);
        }
        if (!is_array($query['question_id'])) {
            $query['question_id'] = explode(",", $query['question_id']);
        }
        foreach ($query['question_id'] as $key => $qid) {
            $relation = ExamQuestionRelation::firstOrCreate(array('question_id' => $qid, 'exam_id' => $query['id']));
            $relation->exam_id = $query['id'];
            $relation->question_id = $qid;
            $relation->save();
        }
        $tmp = array('info' => '操作成功');
        return $response = Response::json($tmp);
    }


    public function delExam()
    {
        $query = Input::only('question_id', 'id');
        $validator = Validator::make($query,
            array(
                'question_id'   => 'required',
                'id' => 'required',
            )
        );
        if($validator->fails())
        {
            $tmp = array('info' => '操作失败,请刷新重试', 'status' => 0);
            return Response::json($tmp);
        }
        if (!is_array($query['question_id'])) {
            $query['question_id'] = explode(",", $query['question_id']);
        }
        foreach ($query['question_id'] as $key => $qid) {
            ExamQuestionRelation::whereQuestionId($qid)->whereExamId($query['id'])->delete();
        }
        $tmp = array('info' => '操作成功', 'status' => 1);
        return $response = Response::json($tmp);
    }

}
