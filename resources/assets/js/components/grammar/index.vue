<template>
    <div class="grammars">
       <div class="sosd_nav">
        <div class="uk-container">
          <router-link to="/">Trang chủ</router-link> <span uk-icon="icon: chevron-right; "></span>
          <span>Luyện học ngữ pháp</span>
        </div>
      </div>
      <hr class="m-0"/>
      <div class="uk-container pb-5 ">
        <div class="guide uk-width-1-1 d-inline-block py-2">
            <h4 class="float-left">Luyện học ngữ pháp</h4>
            <ul class="uk-subnav uk-subnav-divider float-right" uk-margin>
                <li><a href="#modal-guide" uk-toggle>Hướng dẫn</a></li>
                <li><router-link :to="{name: 'grammarList'}">Ngữ pháp của bạn</router-link></li>
                <li><router-link :to="{name: 'grammarArticle'}">Bộ ngữ pháp cơ bản</router-link></li>
            </ul>
        </div>
        <div uk-grid>
          <div class="uk-width-3-4">
          <form class="w-75 px-0 d-inline-block" id="form_create_gram">
          <div class="suggest uk-width-1-1">
            <i>Gợi ý</i> <button class="btn-hover color-4 m-3" @click="grammarArticleRandom">Đổi gợi ý</button>
             <p>Cấu trúc ngữ pháp</p>
            <input name="name" v-model="name" class="uk-input mb-3" id="name-grammar" placeholder="VD: S + to be + adj + er + than + Noun/ Pronoun / in on at ... "/>
            <div v-if="loading">
              <Loading></Loading>
            </div>
            <div v-if="error">
              <b>Vui lòng thử lại</b>
            </div>

            <div v-if="success">
              <div uk-grid="mansonry: true" v-if="searches.length > 0">
                <div class="sosd_images uk-animation-slide-bottom" v-for="(v, i) in searches" v-if="i<5">
                <img :src="searches[Math.floor(Math.random() * searches.length)].image" width="150px" class="">
                </div>
              </div>
            </div>  
        </div>
          <label>Câu của bạn </label>  
          <textarea name="description" v-model="description" id="description-grammar" class="uk-textarea" rows="2" ></textarea>
          <button class="btn-hover color-9 float-right mt-2" @click="save">Lưu</button>
        </form>
        </div>
        <div class="uk-width-1-4 history py-3" v-if="grammars.length > 0">
          <h5>Lịch sử</h5>
          <p  class="pl-5" v-for="(item, i) in grammars" :key="i" v-if="i<10">
            <router-link :to="'/grammars/edit/' + item.id">
            {{item.name}}
            </router-link>  
            </p>
        </div>
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
                Bấm <button class="btn-hover color-4" >Đổi gợi ý</button> để thay đổi gợi ý khác <br/>
                Bạn sẽ được học một cách ngẫu nhiên các ngữ pháp giúp <b>não bộ cũng tiếp nhận một cách tự nhiên</b>. <br/>
                Chúc bạn học tập vui vẻ ^^</p>
        </div>
    </div>
    </div>
</template>
<script>
import Loading from './../shared/loading';

export default {
  components: {
    Loading: Loading
  },
  data: function() {
    return {
      name: '',
      description: '',
      grammars: [],
      user: [],
      error: false,
      success: false,
      loading: true,
      searches: [],
      grammars_articles: [],
      get_grammars_articles: []
    };
  },
  computed: function() {
    this.grammarArticleRandom();
  },
  watch: {
    error() {
      if (this.error) {
        this.success = false;
        this.loading = false;
      }
    },
    success() {
      if (this.success) {
        this.error = false;
        this.loading = false;
      }
    },
    loading() {
      if (this.loading) {
        this.error = false;
        this.success = false;
      }
    }
  },
  created() {
    this.search();
    this.getGrammarUser();
    this.getGrammarArticle();
  },
  methods: {
    getGrammarUser() {
      this.user = Laravel.user;
      var app = this;
      axios
        .get('/grammars/' + app.user.id)
        .then(function(res) {
          app.grammars = res.data;
          console.log('res' + JSON.stringify(app.grammars));
          if (app.$route.params.id != undefined) {
            let g = app.grammars.find(e => e.id == app.$route.params.id);
            app.name = g.name;
            app.description = g.description;
          }
        })
        .catch(function(res) {
          console.log('err');
        });
    },
    getGrammarArticle() {
      var app = this;
      axios
        .get('/grammars-articles')
        .then(function(res) {
          app.get_grammars_articles = res.data;
          app.grammarArticleRandom();
        })
        .catch(function(res) {
          console.log('err');
        });
    },
    search() {
      var app = this;
      app.loading = true;
      var url = '/api/v1/vocabularies/search/all';
      axios
        .get(url)
        .then(res => {
          app.searches = res.data;
          app.success = true;
        })
        .catch(res => {
          app.error = true;
        });
    },
    save(e) {
      var app = this;
      e.preventDefault();
      var f = document.getElementById('form_create_gram');
      var formData = new FormData(f);
      let description_grammar = document.getElementById('description-grammar');
      let name_grammar = document.getElementById('name-grammar');

      if (name_grammar.value != '' || description_grammar.value != '') {
        if (app.$route.params.id != undefined) {
          axios
            .post('/grammars/update/' + app.$route.params.id, formData, {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            })
            .then(function(res) {
              alert('Sửa bài viết thành công !');
              axios
                .get('/grammars/' + app.user.id)
                .then(function(res) {
                  console.log(res);
                  app.grammars = res.data;
                })
                .catch(function(res) {
                  console.log(res);
                });
            })
            .catch(function(res) {
              console.log(res);
              alert('Sửa khong thanh cong, vui long thu lai');
            });
        } else {
          axios
            .post('/grammars/create', formData, {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            })
            .then(function(res) {
              axios
                .get('/grammars/' + app.user.id)
                .then(function(res) {
                  console.log(res);
                  app.grammars = res.data;
                })
                .catch(function(res) {
                  console.log(res);
                });
              f.reset();
              app.name = '';
              app.description = '';
            })
            .catch(function(res) {
              console.log(res);
              alert('Them khong thanh cong, vui long thu lai');
            });
        }
      } else {
        alert('Bạn phải nhập đủ thông tin !');
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
.sosd_nav {
  box-sizing: border-box;
  background: rgba(247, 247, 247, 0.6);
  width: 100%;
  height: 50px;
  line-height: 50px;
}
.uk-subnav {
  a {
    color: #444;
    &:hover {
      color: #000;
    }
  }
}
.grammars {
  background: url('/images/bg9.jpg');
  background-position: right center;
  background-size: cover;
  input,
  textarea {
    color: #000;
    border-radius: 5px;
  }
  .btn-hover {
    padding: 10px 25px;
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    cursor: pointer;
    text-transform: uppercase;
    text-align: center;
    border: none;
    background-size: 300% 100%;
    border-radius: 50px;
    moz-transition: all 0.4s ease-in-out;
    -o-transition: all 0.4s ease-in-out;
    -webkit-transition: all 0.4s ease-in-out;
    transition: all 0.4s ease-in-out;
    &:hover {
      background-position: 100% 0;
      moz-transition: all 0.4s ease-in-out;
      -o-transition: all 0.4s ease-in-out;
      -webkit-transition: all 0.4s ease-in-out;
      transition: all 0.4s ease-in-out;
    }
    &:focus {
      outline: none;
    }
  }
  .btn-hover.color-9 {
    background-image: linear-gradient(to right, #25aae1, #4481eb, #04befe, #3f86ed);
    box-shadow: 0 4px 15px 0 rgba(65, 132, 234, 0.75);
  }
  .btn-hover.color-4 {
    padding: 5px 25px;
    background-image: linear-gradient(to right, #fc6076, #ff9a44, #ef9d43, #e75516);
    box-shadow: 0 4px 15px 0 rgba(252, 104, 110, 0.75);
  }
  .guide {
    .uk-subnav > * > :first-child {
      font-weight: 500;
    }
  }
}
.history {
  a {
    color: #000;
    &:hover {
      color: #1f8bf0;
      text-decoration: none;
    }
  }
}
</style>


