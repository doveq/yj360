<?php

class SortQuestionRelation extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sort_question_relation';
    protected $guarded = array('id');

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

    /* 添加关系数据 */
    public function addMap($data)
    {
        $this->sort_id = $data['sort'];
        $this->question_id = $data['qid'];
        $this->save();
    }

    /* 跟新关系数据 */
    public function updateMap($data)
    {
        $this->where('question_id', '=', $data['qid'])->update(array('sort_id' => $data['sort']));
    }

    public function getMap($qid)
    {
        $info = $this->where('question_id', '=', $qid)->first();
        if($info)
            return $info->toArray();
        else
            return 0;
    }

    public function question()
    {
        return $this->belongsTo('Question');
    }
}