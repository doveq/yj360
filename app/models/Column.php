<?php

class Column extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'column';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = array('password', 'remember_token');


    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    // public function getAuthIdentifier()
    // {
    //  return $this->getKey();
    // }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    // public function getAuthPassword()
    // {
    //  return $this->password;
    // }

    public function child() {
        return $this->hasMany('Column', 'parent_id');
    }

    public function questions() {
        return $this->belongsToMany('Question', 'column_question_relation', 'column_id', 'question_id');
    }
    public function products() {
        return $this->hasMany('Product');
    }

    /* 根据子分类id获取父分类路径 */
    public function getPath($sortId, &$data = array())
    {
        $info = $this->where('id', '=', $sortId)->first();

        $data[] = $info->toArray();

        if($info->parent_id != 0)
            $this->getPath($info->parent_id, $data);

        return $data;
    }

    //返回所有子科目id
    public function allchild($columnid, &$data = array())
    {

        $info = $this->whereParentId($columnid)->whereStatus(1)->select('id')->get();
        if ($info) {
            $i = array_flatten($info->toArray());
            $data = array_merge($data, $i);
            foreach ($i as $key => $value) {
                $this->allchild($value, $data);
            }
        }
        return $data;


    }
}
