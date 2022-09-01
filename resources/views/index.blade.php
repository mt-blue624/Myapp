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
 
  
{{-- メイン --}}
<!-- <p>これは不特定多数の方が使う「テスト用」なので、最初と最後に<a href="{{ url('init') }}">「全て初期化」</a>をクリックして下さい<br>※他に誰かが操作している場合はエラーが出る場合があります。</p>  -->
<div id="app">
  <vue-curd-component></vue-curd-component>
</div>
<script src="{{ url('js/app.js') }}"></script> 

{{-- フッタ --}}
<nav class="bg-primary p-2 text-center footer">
  <div class="text-center">
    <p>Copyright@2022 All Rights Reserved.</p>
  </div>
</nav>  
    
</body>
</html>