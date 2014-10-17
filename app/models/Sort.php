<?php

class Sort extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sort';

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

    public function child()
    {
        return $this->hasMany('Sort', 'parent_id');
    }

    public function questions()
    {
        return $this->belongsToMany('Question', 'sort_question_relation', 'sort_id', 'question_id');
    }


    /* 根据子分类id获取父分类路径 */
    public function getPath($sortId, &$data = array())
    {
        $info = $this->where('id', '=', $sortId)->first();

        if($info)
        {
            $data[] = $info->toArray();

            if($info->parent_id != 0)
                $this->getPath($info->parent_id, $data);
        }
        
        return $data;
    }

    public function paths()
    {

    }

    static public function parent($id)
    {
        $sort = parent::find($id);
        $data = array();
        if ($sort->parent_id <= 0) {
            return $data;
        }
        $parent = parent::find($sort->parent_id);
        $data[] = array(
            'id' => $parent->id,
            'name' => $parent->name,
            'parent' => self::parent($parent->id)
        );
        return $data;

    }
}
