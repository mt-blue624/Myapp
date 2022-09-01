<template>
    <div>
      <div class="fixed-bottom bg-dark text-white" v-bind:style="{ opacity: 0.75 }">
        {{ status }}
      </div>
      
      <div class="post__box">
        <div class="container">
          <h2 class="post__ttl"><span>NEW THREAD</span>投稿</h2>
          <p></p>
          <form v-on:submit.prevent="handleInsert">
            
            <input type="text" class="form-control" placeholder="名前" v-model="name" />
            <textarea class="form-control" rows="5" placeholder="コメントを入力します。" v-model="comment" />
            <input type="submit" value="登録" class="btn btn-primary" />
          </form>        
          <p />
        </div>
      </div>
      
      <div class="post__archive">
        <div class="container">
          <h2 class="post__ttl"><span>ARCHIVE</span>投稿一覧</h2>
          <p></p>
          <div class="post__card-wrap">
            <div v-for="(item, index) in items" class="post__card">    
            
              <!-- 表示モード -->
              <template v-if="!mode[index]">
                <div v-bind:key="item.id" class="card"> 
                  <div class="card-header">
                    <a v-bind:href="`/${item.id}`">{{ item.name }} </a>
                    <br />{{ formatConversion(item.updated_at) }}
                  </div>
                  <div class="card-body">
                    <div>{{ item.comment }}</div>
                    <div>{{ item.message }}</div>
                    <br />
                    <form>
                      <div v-bind:style="{ textAlign: 'right' }" class="btn-box"> 
                        <input type="submit" value="編集" class="btn btn-primary" v-on:click.prevent="$root.$set(mode, index, !mode[index])" />&nbsp;
                        <input type="submit" value="削除" class="btn btn-danger" v-on:click.prevent="handleDelete(index, item.id, $event)" />&nbsp;&nbsp;
                      </div> 
                    </form>
                  </div>    
                </div>
              </template>  
              
              <!-- 編集モード -->
              <template v-else>
                <div v-bind:key="item.id" class="card">  
                  <form v-on:submit.prevent="handleUpdate(index, item.id, $event)">
                    <div class="card-header">
                      <input type="text" v-bind:value="item.name" name="txt_name" class="form-control" />
                    </div>
                    <div class="card-body">
                      <textarea v-bind:value="item.comment" name="txt_comment" class="form-control" rows="5" />                      
                    </div>
                    <div v-bind:style="{ textAlign: 'right' }">
                      <input type="submit" value="キャンセル" class="btn btn-secondary" v-on:click.prevent="$root.$set(mode,index,!mode[index])" />&nbsp;
                      <input type="submit" value="更新" class="btn btn-primary" />&nbsp;&nbsp;
                    </div>
                    <p />
                  </form>
                </div> 
              </template>   
                
            </div>  
          </div>
        </div>
      </div>
    </div>
    </template>
    
    <script>
    
    // 日時操作
    import {format} from 'date-fns'
    import ja from 'date-fns/locale/ja'
    
    // IEのFormData対策用
    import 'formdata-polyfill'
    
    // Ajax
    import axios from 'axios';

    // axios.defaults.headers.common = {
    //   'X-Requested-With': 'XMLHttpRequest',
    //   'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    // };
    
    export default {
      
      // ---------------------
      //  データ定義
      // ---------------------    
      data: function () {
        return {
          items   : [],  // アイテム
          mode    : [],  // アイテムのモード(表示 = false, 編集 = true)
          name    : '',  // 投稿 - 名前
          comment : '',  // 投稿 - コメント       
          status  : 'ここに「Ajax」に関するメッセージが表示されます。' 
        }
      },
      
      // ---------------------
      //  マウント
      // ---------------------  
      mounted: function(){
        
        const params = { format : 'json' };
        axios.get('http://localhost:8000/', { params })
          .then(response  => {
              if (response.status == 200){
                // リストデータ                          
                this.items = response.data;
                // モードの初期化(全て表示モード)
                this.mode = Array(response.data.length).fill(false);     
              }else{
                this.status = '初期情報が読み込めませんでした。';
              }
          }) 
          .catch(err => {
              this.status = err.message;
          });
      },
      
      methods: {
        
        // ---------------------
        //  Ajax通信(送信用)
        // ---------------------  
        run_ajax: function(method, url, data) {
          
          axios({
            method  : method,
            baseURL : url,
            data    : data,
            headers : {
              // JSON
              'Content-Type': 'application/json',
              // CSRFトークン
              // ※AxiosはCookie(Laravelが自動生成)に「X-XSRF-TOKEN」があると、そのヘッダを自動的に送信するので以下は不要
              // https://readouble.com/laravel/6.x/ja/csrf.html 
              // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') ,
              // 'X-Requested-With': 'XMLHttpRequest'
              // 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
          })
          .then(response  => {
            this.status = "サーバーからのメッセージ(" + 
                          this.formatConversion(new Date())  + ") ：" + response.data.msg;
                          
            // 新規登録時のみIDなどが返却される
            if(response.data.id){
              
              // 失敗
              if(response.data.id == "error"){
                
                // エラー制御は行っていないので各自で。
                
              // 成功  
              }else{
                // 先頭にアイテムを追加する 
                this.items.unshift({id        : response.data.id,
                                    name      : response.data.name,
                                    comment   : response.data.comment,
                                    updated_at: response.data.updated_at}
                                   );    
                this.mode.unshift(false);
              }
              
            // 更新/削除
            }else{
              // エラー制御は行っていないので各自で。
            }      
          }) 
          .catch(err => {
              this.status = err.message;
          });
        },      
        
        // ---------------------
        //  日付操作 
        // ---------------------
        formatConversion: function(updated_at) {
          
          // IE11対策で日付形式をISO 8601に変換する
          // 変換前： 2019-01-01 00:00:00
          // 変換後： 2019-01-01T00:00:00.000Z
          if (typeof updated_at !== 'object' && updated_at.indexOf('T') === -1){
            const a = updated_at.slice(0,10);
            const b = 'T'
            const c = updated_at.slice(11);   
            const d = '.000Z'; 
            updated_at =  a + b + c + d;
          }
          
          return format(new Date(Date.parse(updated_at)), 'yyyy年MM月dd日(iiiii) HH:mm:ss', { locale: ja });
        },
        
        // ---------------------
        //  データの登録
        // ---------------------
        handleInsert: function(event) {    
          
          if (this.name && this.comment){
            
            // Ajax
            this.run_ajax("POST",
                          "http://localhost:8000/" ,
                          { name: this.name, comment: this.comment }
                         );
      
            this.name = '';
            this.comment = '';
          }   
        },
          
        // ---------------------
        //  データの更新
        // ---------------------
        handleUpdate: function (index, id, event) {
          const form_data = new FormData(event.target);
          
          const txt_name = form_data.get('txt_name');
          const txt_comment = form_data.get('txt_comment');
          
          // 空または前回と同じ値でなければ
          if (
              (txt_name && txt_comment) &&
              (!(this.items[index].name == txt_name && 
                 this.items[index].comment == txt_comment))
             ){      
            
            this.$root.$set(this.items[index], "name", txt_name);
            this.$root.$set(this.items[index], "comment", txt_comment);
            this.$root.$set(this.items[index], "updated_at", new Date());
            
            // Ajax
            this.run_ajax("PUT",
                          "http://localhost:8000/"  + id ,
                          { name: txt_name, comment: txt_comment }
                         );
          }
          
          // 表示モードに変更する
          this.$root.$set(this.mode, index, !this.mode[index])
        },   
        
        // ---------------------       
        //  データの削除
        // ---------------------       
        handleDelete: function (index, id, event) {
          
          this.items.splice(index, 1);
          this.mode.splice(index, 1);
          
          // Ajax
          this.run_ajax("DELETE",
                        "http://localhost:8000/"  + id ,
                        {}
                       );
        }     
      },    
      
      computed: {  
        // none
      }
    }
    </script>
    
    <style>
    /* none */
    </style>