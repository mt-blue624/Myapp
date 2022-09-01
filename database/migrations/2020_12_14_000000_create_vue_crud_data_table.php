<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVueCrudDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        // CRUDテーブル
        Schema::create('vue_crud_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            // 名前
            $table->string('name');
            // コメント
            $table->text('comment');

            // $table->unsignedInteger('reply_count');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vue_crud_data');
    }
}