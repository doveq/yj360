<?php

use Illuminate\Support\Facades\Input;
// 题目收藏夹

class FavoriteController extends BaseController
{
	public $pageSize = 20;
	public $typeEnum = array('1' => '单选择题', '2' => '多选择题',  '3' => '判断题', '4' => '填空题', '5' => '写作题', '6' => '模唱', '7' => '视唱', '8' => '视频', '9' => '教材', '10' => '游戏');

    public function __construct()
    {
    }

    public function index()
    {
        $query = Input::only('id', 'column_id', 'sort');

        $info = array();
        // 收藏列表
        $f = new Favorite();
        $list = $f->getList( array('uid' => Session::get('uid'), 'column_id' => $query['column_id'], 'sort' => $query['sort'], 'limit' => $this->pageSize ) );

        // 收藏总条数
        $favcount = $f->getFavCount(Session::get('uid'), $query['column_id']);
        
        // 收藏分类列表
        $fs = new FavoriteSort();
        $slist = $fs->getList( array('uid' => Session::get('uid') ) );

        if(empty($query['column_id']))
            return $this->indexView('profile.favorite', array('list' => $list) );
        else
        {
            // 分类页面显示

            $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();

            // 获取父类名页面显示
            $cn = new Column();
            $arr = $cn->getPath($query['column_id']);
            $columnHead = $arr[0];
            
            // 记录sortid与sortname对应关系
            $sinfo = array();
            foreach($slist as $v) {
            	$sinfo[$v->id] = $v->name;
            }
            
            $typeEnum = $this->typeEnum;

            return $this->indexView('column.favorite', compact('list', 'columns', 'columnHead', 'query', 'slist', 'sinfo', 'favcount', 'typeEnum') );

        }
    }


     /* 显示添加分类页面 */
    public function sort()
    {
        $query = Input::only('id', 'column_id');

        // 分类页面显示
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();

        // 获取父类名页面显示
        $cn = new Column();
        $arr = $cn->getPath($query['column_id']);
        $columnHead = $arr[0];
        
        // 收藏总条数
        $f = new Favorite();
        $favcount = $f->getFavCount(Session::get('uid'), $query['column_id']);
        
        // 收藏分类列表
        $fs = new FavoriteSort();
        $slist = $fs->getListPage( array('uid' => Session::get('uid') ), $this->pageSize );

        return $this->indexView('favorite.sort', compact('columns', 'columnHead', 'query', 'slist', 'favcount') );
    }


    public function doDel()
    {
    	$ids = Input::get('ids');
    	$column_id = Input::get('column_id');
    	if(!empty($ids)) {
    		// 根据id直接删除
    		$idarr = explode(',', $ids);
    		$f = new Favorite();
    		$f->delByIds(Session::get('uid'), $idarr);
    	} else {
    		$id = Input::get('qid');
    		
    		if(!is_numeric($id))
    		{
    			if(empty($column_id))
    				return $this->indexPrompt("", "错误的ID号", $url = "/favorite");
    			else
    				return $this->indexPrompt("", "错误的ID号", $url = "/favorite?column_id=". $column_id);
    		}
    		
    		$f = new Favorite();
    		$f->del( array('uid' => Session::get('uid'), 'qid' => $id ) );
    	}
    	
        if(empty($column_id))
        {
            //return $this->indexPrompt("", "删除收藏成功", $url = "/favorite");
            return Redirect::to('/favorite');
        }
        else
        {
            //return $this->indexPrompt("", "删除收藏成功", $url = "/favorite?column_id=". $column_id);
            return Redirect::to("/favorite?column_id=". $column_id);
        }
    }

    public function ajax()
    {
        $inputs = Input::all();
        if(!is_numeric($inputs['qid']) || !is_numeric($inputs['column']))
            return Response::json(array('act' => $inputs['act'], 'state' => '0'));

        $info['uid'] = Session::get('uid');
        $info['qid'] = $inputs['qid'];
        $info['column_id'] = $inputs['column'];
        if(!empty($inputs['msort'])) {
	        $info['sort'] = $inputs['msort']; // 所属分类
        } else {
        	$info['sort'] = 0; // 默认分类
        }

        if($inputs['act'] == 'add')
        {
            $f = new Favorite();
            $f->add($info);
        }
        else if($inputs['act'] == 'del')
        {
            $f = new Favorite();
            $f->del($info);
        }

        return Response::json(array('act' => $inputs['act'], 'state' => '1'));
    }

    public function choose()
    {
        $query = Input::only('training_id', 'column_id');
        $info = array();
        $f = new Favorite();
        $lists = $f->getList( array('uid' => Session::get('uid'), 'limit' => 30 ) );

        return $this->indexView('favorite.choose', compact('lists', 'query') );
    }

    public function dochoose()
    {
        $query = Input::only('training_id', 'column_id', 'question_id');
        $insert_values = array();
        $created_at = date("Y-m-d H:i:s");
        foreach ($query['question_id'] as $key => $qid) {
            $insert_values[] = array('training_id' => $query['training_id'], 'question_id' => $qid, 'created_at' => $created_at);
        }
        TrainingQuestionRelation::insert($insert_values);
        if (Request::ajax()) {
            return Response::json('ok');
        }
    }


    /* 添加收藏分类 */
    public function sortDoAdd()
    {
         $query = Input::only('column_id', 'name');

         $fs = new FavoriteSort();

         $query['uid'] = Session::get('uid');
         $query['created_at'] = date("Y-m-d H:i:s");
         $fs->addInfo($query);
         
         $tag = Input::get('tag');
         if($tag && $tag == 'sort') {
         	return Redirect::to("/favorite/sort?column_id=". $query['column_id']);
         } else {
         	return Redirect::to("/favorite?column_id=". $query['column_id']);
         }
    }

    public function sortDoEdit()
    {
        $query = Input::only('column_id', 'name', 'id');
        $fs = new FavoriteSort();

        $query['uid'] = Session::get('uid');
        $fs->editInfo($query);

        return Redirect::to("/favorite/sort?column_id=". $query['column_id']);
    }

    public function sortDoDel()
    {
        $query = Input::only('id', 'column_id');
        $query['uid'] = Session::get('uid');

        $fs = new FavoriteSort();
        $fs->delInfo($query);

        $f = new Favorite();
        $f->updateDefaultSort($query['uid'], $query['id']);

        return Redirect::to("/favorite/sort?column_id=". $query['column_id']);
    }

    /**
     * 批量移动
     */
    public function move() {
    	$ids = Input::get('ids');
    	$column_id = Input::get('column_id');
    	$msort = Input::get('msort');
    	if(!empty($ids)) {
    		$idarr = explode(',', $ids);
    		$f = new Favorite();
    		$f->updateSort(Session::get('uid'), $idarr, $msort);
    	}
    	if(empty($column_id))
    	{
    		//return $this->indexPrompt("", "删除收藏成功", $url = "/favorite");
    		return Redirect::to('/favorite');
    	}
    	else
    	{
    		//return $this->indexPrompt("", "删除收藏成功", $url = "/favorite?column_id=". $column_id);
    		return Redirect::to("/favorite?column_id=". $column_id);
    	}
    }
}
