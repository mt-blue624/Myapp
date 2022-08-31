<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
@if(false)
<meta name="csrf-token" content="{{ csrf_token() }}"> {{-- X-CSRF-TOKENは不要。詳細はVueCurdComponent.vueの130行目参照。 --}}
@endif
<title>Laravel + Vue.js + AxiosでCRUDのサンプルプロジェクト</title>
<link rel="stylesheet" href="{{ url('css/app.css') }}" type="text/css">
</head>
<body>

{{-- ヘッダ --}}
<nav class="navbar navbar-expand-md navbar-light bg-primary">
  <div class="navbar-brand text-white">
    Laravel + Vue.js + AxiosでCRUDのサンプルプロジェクト
  </div>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link" style="color:#fff;" href="{{ url('init') }}">初期化</a>
    </li>    
  </ul>
</nav>

<div class="container">  
  
  {{-- メイン --}}
  <p>これは不特定多数の方が使う「テスト用」なので、最初と最後に<a href="{{ url('init') }}">「全て初期化」</a>をクリックして下さい<br>※他に誰かが操作している場合はエラーが出る場合があります。</p> 
  <div id="app">
    <vue-curd-component></vue-curd-component>
  </div>
  <script src="{{ url('js/app.js') }}"></script> 
  
  {{-- フッタ --}}
  <nav class="container bg-primary p-2 text-center">
    <div class="text-center text-white">
      Vue "CRUD" Sample<br>
      Takeshi Okamoto wrote the code.<br>
      <p></p>
    </div>
  </nav>  
    
</div>  
</body>
</html>