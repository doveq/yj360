<?php

class CoursewareController extends BaseController
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
        $query = Input::only('column_id', 'd1', 'id', 'q', 'type');

        //type : 区分多媒体教材还是多媒体课件, 多媒体课件以后可能会加
        //科目
        if ($query['column_id'] == 3) {
            $config_path = "/data/music_basic/";
            $column_name = '多媒体教材';
            $back_url = "/courseware?id=".$query['id']."&column_id=". $query['column_id'] . "&type=" . $query['type'];
        } elseif ($query['column_id'] == 4) {
            $config_path = "/data/primary_school/";
            $column_name = '多媒体教材';
            $back_url = "/courseware?id=".$query['id']."&column_id=". $query['column_id'] . "&type=" . $query['type'];
        } elseif ($query['column_id'] == 5) {
            $config_path = "/data/middle_school/";
            $column_name = '多媒体教材';
            $back_url = "/courseware?id=".$query['id']."&column_id=". $query['column_id'] . "&type=" . $query['type'];
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
                foreach ($d['files'] as $key => $f) {
                    if (stristr($f['name'],$query['q']) !== false) {
                        $lists['files'][] = array('name' => $f['name'], 'path' => $f['path'], 'pinyin' => $py->get_pinyin($f['name']), 'pic' => $f['pic']);
                    }
                }
            }
        } else {
            if (!isset($query['d1'])) {
                $lists = $dir_info;
            } else {
                foreach ($dir_info[$query['d1']]['files'] as $key => $value) {
                    $value['pinyin'] = $py->get_pinyin($value['name']);
                    // $lists[$key] = $value;
                    $dir_info[$query['d1']]['files'][$key] = $value;
                }
                $lists = $dir_info[$query['d1']];
            }
        }
        // 获取父类名页面显示
        $cn = new Column();
        $arr = $cn->getPath($query['column_id']);
        $columnHead = $arr[0];
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        return $this->indexView('courseware.index', compact('columns', 'query', 'lists', 'config_path', 'back_url', 'column_name', 'columnHead'));
	}

    public function show()
    {
        $query = Input::only('path', 'type', 'column_id', 'filename', 'id');
        //科目
        if ($query['column_id'] == 3) {
            $config_path = "/data/music_basic/";
            $column_name = '多媒体教材';
            $back_url = "/courseware?id=".$query['id']."&column_id=". $query['column_id'] . "&type=" . $query['type'];
        } elseif ($query['column_id'] == 4) {
            $config_path = "/data/primary_school/";
            $column_name = '多媒体教材';
            $back_url = "/courseware?id=".$query['id']."&column_id=". $query['column_id'] . "&type=" . $query['type'];
        } elseif ($query['column_id'] == 5) {
            $config_path = "/data/middle_school/";
            $column_name = '多媒体教材';
            $back_url = "/courseware?id=".$query['id']."&column_id=". $query['column_id'] . "&type=" . $query['type'];
        }
        // 获取父类名页面显示
        $cn = new Column();
        $arr = $cn->getPath($query['column_id']);
        $columnHead = $arr[0];
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        return $this->indexView('courseware.show', compact('columns', 'query', 'config_path', 'back_url', 'column_name', 'columnHead'));

    }

    // public function zip()
    // {
    //     $query = Input::only('dir', 'type', 'filename', 'column_id');
    //     if ($query['column_id'] == 3) {
    //         $config_path = "/data/music_basic/";
    //         $column_name = '多媒体教材';
    //         $back_url = "/courseware?id=".$query['id']."&column_id=". $query['column_id'] . "&type=" . $query['type'];
    //     } elseif ($query['column_id'] == 4) {
    //         $config_path = "/data/primary_school/";
    //         $column_name = '多媒体教材';
    //         $back_url = "/courseware?id=".$query['id']."&column_id=". $query['column_id'] . "&type=" . $query['type'];
    //     } elseif ($query['column_id'] == 5) {
    //         $config_path = "/data/primary_school/";
    //         $column_name = '多媒体教材';
    //         $back_url = "/courseware?id=".$query['id']."&column_id=". $query['column_id'] . "&type=" . $query['type'];
    //     }
    //     //解释ＸＭＬ文件；

    //     $dom = new DOMDocument('1.0', 'utf-8');
    //     $dom->load("./link/link.xml");
    //     $x=$dom->documentElement;
    //     getArray($x);


    // }


    // function getArray($node) {
    //     if ($node->hasAttributes()) {
    //         foreach ($node->attributes as $attr) {
    //             if($attr->nodeName=="link")
    //             {
    //                 array_push($this->xmlArray,$attr->nodeValue);
    //             }
    //         }
    //     }
    //     if ($node->hasChildNodes()) {
    //         if ($node->childNodes->length == 1) {
    //             getArray($node->firstChild);
    //         } else {
    //             foreach ($node->childNodes as $childNode) {
    //                 if ($childNode->nodeType != XML_TEXT_NODE) {
    //                     getArray($childNode);
    //                 }
    //             }
    //         }
    //     }
    //     // return $array;
    // }

}
