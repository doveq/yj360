<?php

class ExamPaper extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'exam_paper';
    protected $guarded = array('id');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = array('password', 'remember_token');


    public function add($data)
    {
        $this->column_id = $data['column_id'];
        $this->title = $data['title'];
        $this->price = $data['price'];
        $this->status = $data['status'];
        $this->desc = $data['desc'];
        return $this->save();
    }

}
