<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
@if(false)
<meta name="csrf-token" content="{{ csrf_token() }}"> {{-- X-CSRF-TOKENは不要。詳細はVueCurdComponent.vueの130行目参照。 --}}
@endif
<title>掲示板</title>

<!-- Font -->
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
<!-- // Font -->

<!-- CSS -->
<link rel="stylesheet" href="{{ url('css/app.css') }}" type="text/css">
<link rel="stylesheet" href="{{ url('css/modify.css') }}" type="text/css">
<!-- // CSS -->

</head>
<body>

{{-- ヘッダ --}}
<nav class="navbar navbar-expand-md navbar-light bg-primary header">
  <h1 class="navbar-brand">
    <a href="<?= url('/');?>">掲示板</a>
  </h1>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link" href="{{ url('init') }}">初期化</a>
    </li>    
  </ul>
</nav>

<!-- <?php  
  echo '<pre>';
  var_dump($thread);
  echo '</pre>';
?> -->
 
  
{{-- メイン --}}
<div class="post__detail">
  <div class="container">
    <h2 class="post__ttl"><span>DETAIL</span>投稿詳細</h2>
    <div class="card">
      <div class="card-header">
        <p>投稿者：{{ $thread->name }}</p>
        <p>投稿日：{{ $thread->updated_at }}</p>
      </div>
      <div class="card-body">
        <div>{{ $thread->comment }}</div>
      </div>
    </div>
    <h2 class="post__ttl">コメント</h2>
    <form class="mb-4" method="POST" action="{{ route('message.store') }}">
      @csrf
   
      <input name="post_id" type="hidden">
   
      <div class="form-group">
        <label for="subject">名前</label>
        <input
          id="name"
          name="name"
          class="form-control"
          value="{{ old('name') }}"
          type="text"
        >
      </div>
   
      <div class="form-group">
        <label for="body">本文</label>
        <textarea
          id="msg"
          name="msg"
          class="form-control"
          rows="4"
        >{{ old('msg') }}</textarea>
      </div>
   
      <div class="mt-4">
       <button type="submit" class="btn btn-primary">
        コメントする
       </button>
      </div>
    </form>
  </div>

</div>

{{-- フッタ --}}
<nav class="bg-primary p-2 text-center footer">
  <div class="text-center">
    <p>Copyright@2022 All Rights Reserved.</p>
  </div>
</nav>  
    
</body>
</html>