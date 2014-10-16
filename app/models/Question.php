<?php

class Question extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'questions';

    public function sort() {
        return $this->belongsToMany('Sort', 'sort_question_relation', 'question_id', 'sort_id');
    }

    public function column() {
        return $this->belongsToMany('Column', 'column_question_relation', 'question_id', 'column_id');
    }
}