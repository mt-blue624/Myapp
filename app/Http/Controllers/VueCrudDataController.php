<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 追加分
use App\VueCrudData;
use Illuminate\Support\Facades\DB;

class VueCrudDataController extends Controller
{
    // 全て初期化
    public function init()
    {
        // 高速削除
        DB::statement('TRUNCATE TABLE vue_crud_data;');
        // 高速挿入
        DB::statement('INSERT INTO vue_crud_data SELECT * FROM vue_crud_data_bk;');

        return redirect(url('/'));
    }
    
    public function index(Request $request)
    {   
        // JSON
        if ($request->format == 'json'){

            $items = VueCrudData::orderBy('updated_at', 'DESC')->get();
            
            // JSONを返す
            return $items->toArray();
           
            // JSONは次のような形式となる
            //
            //  [
            //    {"id": 1, "name": "プチモンテ"}
            //    {"id": 2, "name": "プチラボ"  }
            //    {"id": 3, "name": "@ゲーム"   }        
            //  ]    
            
        // HTML        
        }else{
            return view('index');
        }       
    }

    public function store(Request $request)
    {
        // パラメータ
        $param = [
            'name'     => $request->name,  
            'comment'  => $request->comment,  
        ];
        
        // トランザクション
        DB::beginTransaction();
        try { 
            // 成功
            $vuecruddata = new VueCrudData;
            if ($vuecruddata->fill($param)->save()){
                DB::commit();
                return response()->json(['msg'  => 'Ajaxによるデータの登録が成功しました。', 
                                         'id'   => $vuecruddata->id,
                                         'name' => $vuecruddata->name,
                                         'comment'    => $vuecruddata->comment,
                                         'updated_at' => $vuecruddata->updated_at,
                                         ]);                
            }
        } catch (\Exception $e) {
        }  
        
        // エラー時
        DB::rollback();
        return response()->json(['msg' => 'Ajaxによるデータの登録が失敗しました。', 
                                 'id'  => 'error',
                                ]);        
    }

    public function update(Request $request, $id)
    {
        // パラメータ
        $param = [
            'name'     => $request->name,  
            'comment'  => $request->comment,  
        ];

        // トランザクション
        DB::beginTransaction();
        try {    
            // 成功
            if (VueCrudData::where('id', $id)->update($param) === 1){
                DB::commit();
                return response()->json(['msg' => 'Ajaxによるデータの更新が成功しました。']);                
            }
        } catch (\Exception $e) {
        }  
        
        // エラー時
        DB::rollback();
        return response()->json(['msg' => 'Ajaxによるデータの更新が失敗しました。']);      
    }

    public function destroy($id)
    {        
        // トランザクション
        DB::beginTransaction();
        try {            
            // 成功
            if (VueCrudData::where('id', $id)->delete() === 1){
                DB::commit();
                return response()->json(['msg' => 'Ajaxによるデータの削除が成功しました。']);                
            }
        } catch (\Exception $e) {
        }  
        
        // エラー時
        DB::rollback();
        return response()->json(['msg' => 'Ajaxによるデータの削除が失敗しました。']);  
    }
}