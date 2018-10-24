<template>
    <div>
      <nav class="uk-navbar-container pb-3" uk-navbar>
            <div class="uk-navbar-left">
                <router-link to="/">Trang chủ</router-link> <span uk-icon="icon: chevron-right; "></span>
                <router-link to="">Ngữ pháp</router-link>
            </div>
            <div class="uk-navbar-right">
            </div>
      </nav>
      <div class="sosd-background-white sosd-box-shadow uk-padding sosd-no-margin" uk-grid>
        <form class="uk-width-1-1 px-0" id="form_create_gram">
            <textarea name="name" id="input-grammar-user" class="uk-textarea uk-form-success" rows="3" placeholder="Hãy nhập các câu bạn nghĩ tới ..."></textarea>
            <button class="uk-button uk-button-primary  sosd-color-white float-right mt-2" @click="save">Lưu</button>
        </form>
        <div class="suggest mt-0 uk-width-1-1  px-0">
            <label>Gợi ý</label> <button class="uk-button-danger ml-3" @click="grammarArticleRandom">Đổi gợi ý</button>
            <div class="pl-5" v-if="grammars_articles">
                <h5 class="text-center pb-3"><b v-html="grammars_articles.name"></b></h5>
                <p v-html="grammars_articles.description"></p>
            </div>
            <ul class="uk-thumbnav" uk-margin>
                <li class="uk-active px-5"><img src="https://cdn.mgift.vn/news/2018/03/22/314f81ec92557a9470a106a970f45a065ab32eb6173bc_500x543.jpeg" width="200" alt=""></li>
                <li class="uk-active px-5"><img src="https://media1.tenor.com/images/1800a8296d46374a3a0c6d1e1f375325/tenor.gif?itemid=11410221" width="200" alt=""></li>
            </ul>  
             <!-- <div class=" pt-4" uk-grid v-if="grammars_articles.description_suggest">
                    <div class="uk-width-auto">
                        <button href="#toggle-animation"  uk-toggle="target: #toggle-animation; animation: uk-animation-fade" class="uk-button-primary">Ví dụ</button>
                    </div>
                    <div class="uk-width-expand">
                        <div id="toggle-animation" aria-hidden="true" hidden  v-html="grammars_articles.description_suggest" > </div>
                    </div>
              </div>    -->
        </div>
        <div class="grammar-old  px-0">
          <h5>Lịch sử</h5>
          <p  class="pl-5" v-for="(item, i) in grammars" :key="i" v-if="i<10">
            {{item.name}}
            </p>
        </div>
        <div class="guide uk-width-1-1">
            <ul class="uk-subnav uk-subnav-divider" uk-margin>
                <li class="uk-active"><a href="#modal-guide" uk-toggle>Hướng dẫn</a></li>
                <li><router-link :to="{name: 'grammarArticle'}">Bộ ngữ pháp cơ bản</router-link></li>
            </ul>
        </div>
      </div>

      <!-- modal hướng dẫn sử dụng -->
      <div id="modal-guide" class="uk-modal-container" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h3 class="">Hướng dẫn sử dụng</h3>
            <p><b>Phương pháp học ngữ pháp tự nhiên !</b> <br/>
                Bạn sẽ viết những câu <b>ngẫu nhiên</b> mà bạn nghĩ tới.  <br/>
                Nếu bạn không nghĩ ra Mèo Ú  đã gợi ý cho bạn những cú pháp và những hình ảnh để bạn có thể tự <b>sáng tạo</b>  những câu thật hay. <br/>
                Bấm <button class="uk-button-danger" >Đổi gợi ý</button> để thay đổi gợi ý khác <br/>
                Bạn bế tắc không nghĩ ra câu viết như nào cho đúng Mèo Ú đã viết tại <button  class="uk-button-primary">Ví dụ</button>
                để cho bạn tham khảo <br/>
                Bạn sẽ được học một cách ngẫu nhiên các ngữ pháp giúp <b>não bộ cũng tiếp nhận một cách tự nhiên</b>. <br/>
                Chúc bạn học tập vui vẻ ^^</p>
        </div>
    </div>
    </div>
</template>
<script>
export default {
  data: function() {
    return {
      grammars: [],
      user: [],
      grammars_articles: [],
      get_grammars_articles: []
    };
  },
  computed: function() {
    this.grammarArticleRandom();
  },
  created() {
    this.user = Laravel.user;
    var app = this;
    axios
      .get('/grammars-articles')
      .then(function(res) {
        app.get_grammars_articles = res.data;
        app.grammarArticleRandom();
        axios
          .get('/grammars/' + app.user.id + '/history')
          .then(function(res) {
            app.grammars = res.data;
            console.log('res' + JSON.stringify(app.grammars));
          })
          .catch(function(res) {
            console.log('err');
          });
      })
      .catch(function(res) {
        console.log('err');
      });
  },
  methods: {
    save(e) {
      var app = this;
      e.preventDefault();
      var f = document.getElementById('form_create_gram');
      var formData = new FormData(f);
      let input_grammar_user = document.getElementById('input-grammar-user');

      if (input_grammar_user.value != '') {
        axios
          .post('/grammars/create', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
          .then(function(res) {
            axios
              .get('/grammars/' + app.user.id + '/history')
              .then(function(res) {
                app.grammars = res.data;
              })
              .catch(function(res) {
                console.log('err');
              });
            f.reset();
          })
          .catch(function(res) {
            console.log(res);
            alert('Them khong thanh cong, vui long thu lai');
          });
      } else {
        alert('Bạn phải nhập câu tiếng Anh của mình');
      }
    },
    grammarArticleRandom() {
      var len = this.get_grammars_articles.length;
      this.grammars_articles = this.get_grammars_articles[Math.floor(Math.random() * len)];
    }
  }
};
</script>
<style lang="scss" scoped>
nav {
  text-transform: uppercase;
  span.uk-icon {
    display: inherit;
    padding: 0 10px;
  }
  a {
    font-weight: bold;
    &:hover {
      text-decoration: none;
      color: tomato;
    }
  }
}
.suggest {
  .uk-button-danger,
  .uk-button-primary {
    outline: none;
    border: none;
    cursor: pointer;
    color: white !important;
    &:focus {
      outline: none;
      border: none;
    }
  }
}
.guide {
  .uk-subnav > * > :first-child {
    font-weight: bold;
  }
}
</style>


