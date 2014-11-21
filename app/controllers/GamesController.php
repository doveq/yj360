<?php

class GamesController extends BaseController
{

	public function __construct()
    {
        $query = Input::only('column_id');

        if ((!isset($query['column_id']) || !is_numeric($query['column_id'])) && Request::path() != 'column/static') {
            echo ("<script>window.location.href='/column/static';</script>");
        }
    }

	/* 登录处理 */
	public function index()
	{
        $query = Input::only('column_id', 'id', 'q');

        //科目
        if ($query['column_id'] == 3) {
            $config_path = "/data/games/music_basic/";
            $column_name = '趣味练习';
            $back_url = "/games?id=".$query['id']."&column_id=". $query['column_id'] . "&type=" . $query['type'];
        } elseif ($query['column_id'] == 4) {
            $config_path = "/data/games/primary_school/";
            $column_name = '趣味练习';
            $back_url = "/games?id=".$query['id']."&column_id=". $query['column_id'] . "&type=" . $query['type'];
        } elseif ($query['column_id'] == 5) {
            $config_path = "/data/games/middle_school/";
            $column_name = '趣味练习';
            $back_url = "/games?id=".$query['id']."&column_id=". $query['column_id'] . "&type=" . $query['type'];
        }
        if (!file_exists(public_path() . $config_path . "info.php")) {
            $dir_info = array();
        } else {
            include_once public_path() . $config_path . "info.php";     //返回 $dir_info
        }
        $py = new pinyin();
        $lists = array();
        //检索
        if ($query['q'] != '') {
            foreach ($dir_info as $key => $d) {
                if (stristr($d['name'],$query['q']) !== false) {
                    $d['pinyin'] = $py->get_pinyin($d['name']);
                    $lists[$key] = $d;
                }
            }
        } else {
            $lists = $dir_info;
            foreach ($dir_info as $key => $value) {
                $value['pinyin'] = $py->get_pinyin($value['name']);
                $lists[$key] = $value;
            }
        }
        // 获取父类名页面显示
        $cn = new Column();
        $arr = $cn->getPath($query['column_id']);
        $columnHead = $arr[0];
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        return $this->indexView('games.index', compact('columns', 'query', 'lists', 'config_path', 'back_url', 'column_name', 'columnHead'));
	}

    public function show()
    {
        $query = Input::only('path', 'column_id', 'filename', 'id');
        //科目
        if ($query['column_id'] == 3) {
            $config_path = "/data/games/music_basic/";
            $column_name = '趣味练习';
            $back_url = "/games?id=".$query['id']."&column_id=". $query['column_id'];
        } elseif ($query['column_id'] == 4) {
            $config_path = "/data/games/primary_school/";
            $column_name = '趣味练习';
            $back_url = "/games?id=".$query['id']."&column_id=". $query['column_id'];
        } elseif ($query['column_id'] == 5) {
            $config_path = "/data/games/middle_school/";
            $column_name = '趣味练习';
            $back_url = "/games?id=".$query['id']."&column_id=". $query['column_id'];
        }
        // 获取父类名页面显示
        $cn = new Column();
        $arr = $cn->getPath($query['column_id']);
        $columnHead = $arr[0];
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        return $this->indexView('games.show', compact('columns', 'query', 'config_path', 'back_url', 'column_name', 'columnHead'));

    }

}
