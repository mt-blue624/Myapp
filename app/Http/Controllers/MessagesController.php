<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Message;

class MessagesController extends Controller
{
    // public function store()
    // {
    //     $rules = [
    //         'name' => 'required',
    //         'content'=>'required',
    //     ];

    //     $messages = array(
    //         'name.required' => 'タイトルを正しく入力してください。',
    //         'content.required' => '本文を正しく入力してください。',
    //     );

    //     // $validator = Validator::make(Input::all(), $rules, $messages);

    //     $message = new Message;
    //     $message->name = Input::get('name');
    //     $message->content = Input::get('content');
    //     $message->post_id = Input::get('post_id');
    //     $message->save();
    //     return Redirect::back()
    //         ->with('message', '投稿が完了しました。');
    //     // if ($validator->passes()) {
    //     // }else{
    //     //     return Redirect::back()
    //     //         ->withErrors($validator)
    //     //         ->withInput();
    //     // }
    // }
    public function store(Request $request)
    {
        $savedata = [
            'post_id' => $request->post_id,
            'name' => $request->name,
            'msg' => $request->msg,
        ];

        $message = new Message;
        $message->fill($savedata)->save();

        return redirect('/');
    }
}
