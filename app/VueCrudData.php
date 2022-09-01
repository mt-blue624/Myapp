<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VueCrudData extends Model
{
   protected $guarded = array('id');

   public function messages(){
		// 投稿はたくさんのコメントを持つ
		return $this->hasMany('App\Message');
	}
}