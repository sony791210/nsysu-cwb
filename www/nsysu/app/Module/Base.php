<?php

namespace App\Module;

//use Illuminate\Database\Eloquent\Model;
use Hoyvoy\CrossDatabase\Eloquent\Model;

abstract class Base extends Model
{
    public function scopeSearchColumn($q, $column, $val, $operator = '=')
    {
        return $q->when($val !== false, function($q) use ($column, $val, $operator){
            return $q->where($column, $operator, $val);
        });
    }
    
    public function modelUpdate($id, $data)
    {
        $model = $this->find($id);
        foreach ($data as $key => $val) {
            $model->$key = $val;
        }
        return $model->save();
    }
}
