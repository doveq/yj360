<?php namespace Admin;
// use View;
// use Session;
// use Validator;
// use Input;
// use Paginator;
// use Redirect;
// use DB;
// use Request;
// use Str;
// use Config;
use Response;

use Column;
use Sort;
use ExamSort;

class JsonController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    public function index($column)
    {
        return $this->{$column}();
    }

	public function column()
	{
        // $str = '[{"n": "北京市", "s": [{"n": "东城区"}, {"n": "密云县"}, {"n": "延庆县"} ] }, {"n": "天津市", "s": [{"n": "和平区"} ] } ]';
        $lists = $this->columnChild(0);
        return Response::json($lists);

	}

    public function sort()
    {
        $lists = $this->sortChild(0);
        return Response::json($lists);
    }

    public function examSort()
    {
        $lists = $this->examSortChild(0);
        return Response::json($lists);
    }

    public function columnChild($id)
    {
        $res = Column::whereParentId($id)->select('id', 'name')->orderBy('id', 'ASC')->get();
        $data = array();
        // dd($res);
        if (!$res) {
            return $data;
        }
        foreach ($res as $key => $list) {
            $data[] = array('v' => $list->id,
                            'n' => $list->name,
                            's' => $this->columnChild($list->id)
                            );
        }
        return $data;
    }

    public function sortChild($id)
    {
        $res = Sort::whereParentId($id)->select('id', 'name')->orderBy('id', 'ASC')->get();
        $data = array();
        if (!$res) {
            return $data;
        }
        foreach ($res as $key => $list) {
            $data[] = array('v' => $list->id,
                            'n' => $list->name,
                            's' => $this->sortChild($list->id)
                            );
        }
        return $data;
    }


    public function examSortChild($id)
    {
        $res = ExamSort::whereParentId($id)->select('id', 'name')->orderBy('id', 'ASC')->get();
        $data = array();
        if (!$res) {
            return $data;
        }
        foreach ($res as $key => $list) {
            $data[] = array('v' => $list->id,
                            'n' => $list->name,
                            's' => $this->examSortChild($list->id)
                            );
        }
        return $data;
    }

    /*

array(2) {
  [0]=>
  array(2) {
    ["n"]=>
    string(9) "北京市"
    ["s"]=>
    array(3) {
      [0]=>
      array(1) {
        ["n"]=>
        string(9) "东城区"
      }
      [1]=>
      array(1) {
        ["n"]=>
        string(9) "密云县"
      }
      [2]=>
      array(1) {
        ["n"]=>
        string(9) "延庆县"
      }
    }
  }
  [1]=>
  array(2) {
    ["n"]=>
    string(9) "天津市"
    ["s"]=>
    array(1) {
      [0]=>
      array(1) {
        ["n"]=>
        string(9) "和平区"
      }
    }
  }
}

     */


}
