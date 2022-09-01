<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  //  protected $guarded = array('id');
  protected $fillable = ['msg', 'name', 'post_id'];

  public function vue_crud_data()
  {
      return $this->belongsTo('App\VueCrudData');
  }
}