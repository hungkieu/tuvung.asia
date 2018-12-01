<template>
  <div class="grammars">
    <div class="sosd_nav">
      <div class="uk-container">
        <router-link to="/">Trang chủ</router-link>
        <span uk-icon="icon: chevron-right; "></span>
        <span>Luyện học ngữ pháp</span>
      </div>
    </div>
    <hr class="m-0">
    <div class="uk-container pb-5">
      <div class="guide uk-width-1-1 d-inline-block pt-2">
        <h4 class="float-left">Luyện học ngữ pháp</h4>
        <ul class="uk-subnav uk-subnav-divider float-right" uk-margin>
          <li>
            <a href="#modal-guide" uk-toggle>Hướng dẫn</a>
          </li>
          <li>
            <router-link :to="{name: 'grammarList'}">Ngữ pháp của bạn</router-link>
          </li>
          <li>
            <router-link :to="{name: 'grammarArticle'}">Bộ ngữ pháp cơ bản</router-link>
          </li>
        </ul>
      </div>
      <div uk-grid>
        <div class="uk-width-3-4">
          <div class="w-100 px-0 d-inline-block">
            <div class="suggest uk-width-1-1">
              <p v-if="this.$route.params.id != undefined">
                <router-link :to="{name: 'indexGrammar'}">Quay lại luyện tập</router-link>
              </p>
              <p v-else>
                <i>Gợi ý</i>
                <button class="btn-hover color-4 mx-3 mb-3" @click="grammarRandom">Đổi gợi ý</button>
              </p>
              <p>Cấu trúc ngữ pháp</p>
              <h5
                class="text-center"
              >{{ listCategory ? listCategory.find(e => (e.id == showGrammar.category_id)).name : '122'}}</h5>
              <h4 class="text-center">
                <b>{{showGrammar ? showGrammar.structure : '' }}</b>
              </h4>
              <p class="mb-1">Mô tả</p>
              <pre style="background: transparent; border: none;">{{showGrammar ? showGrammar.description : ''}}</pre>
            </div>
            <label>Câu của bạn</label>
            <textarea name="name" v-model="obj.name" class="uk-textarea" rows="2"></textarea>
            <button class="btn-hover color-9 float-right mt-2" @click="save">Lưu</button>
          </div>
        </div>
        <div class="uk-width-1-4 history py-3" v-if="grammarsUser.length > 0">
          <h5>Lịch sử</h5>
          <p class="mb-0" v-for="(item, i) in grammarsUser " :key="i" v-if="i<10">
            <router-link :to="'/grammars/edit/' + item.id">
              <span class="des-1" :title="item.name">{{item.name}}</span>
            </router-link>
          </p>
        </div>
      </div>
    </div>

    <!-- modal hướng dẫn sử dụng -->
    <div id="modal-guide" class="uk-modal-container" uk-modal>
      <div class="uk-modal-dialog uk-modal-body">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h3 class>Hướng dẫn sử dụng</h3>
        <p>
          <b>Phương pháp học ngữ pháp tự nhiên !</b>
          <br>Bạn sẽ viết những câu
          <b>ngẫu nhiên</b> mà bạn nghĩ tới.
          <br>Nếu bạn không nghĩ ra Mèo Ú đã gợi ý cho bạn những cú pháp và những hình ảnh để bạn có thể tự
          <b>sáng tạo</b> những câu thật hay.
          <br>Bấm
          <button class="btn-hover color-4">Đổi gợi ý</button> để thay đổi gợi ý khác
          <br>Bạn sẽ được học một cách ngẫu nhiên các ngữ pháp giúp
          <b>não bộ cũng tiếp nhận một cách tự nhiên</b>.
          <br>Chúc bạn học tập vui vẻ ^^
        </p>
      </div>
    </div>
  </div>
</template>
<script>
import Loading from "./../shared/loading";

export default {
  components: {
    Loading: Loading
  },
  data: function() {
    return {
      obj: {
        name: "",
        category_id: "",
        structure_name: "",
        structure_description: ""
      },
      grammarsUser: [],
      grammars: [],
      user: [],
      searches: [],
      showGrammar: [],
      listCategory: []
    };
  },
  computed: function() {
    this.grammarRandom();
  },
  created() {
    this.getUser();
    this.getStructureSentences();
    this.getCategory();
    this.getGrammarUser();
  },
  methods: {
    getUser() {
      var app = this;
      this.user = Laravel.user;
      // axios
      //   .get('/api/v1/users')
      //   .then(res => {
      //     app.user = res.data;
      //   })
      //   .catch(res => {
      //     console.log(res);
      //   });
    },
    getStructureSentences() {
      var app = this;
      axios
        .get("/admin/structure-sentences")
        .then(function(res) {
          console.log(res);
          app.grammars = res.data;
          app.grammarRandom();
        })
        .catch(function(res) {
          console.log(res);
        });
    },
    getCategory() {
      var app = this;
      axios
        .get("/admin/category-structure-grammars")
        .then(function(res) {
          app.listCategory = res.data;
        })
        .catch(function(res) {
          console.log(res);
        });
    },
    getGrammarUser() {
      var app = this;
      if (app.user) {
        axios
          .get("/grammars/" + app.user.id)
          .then(function(res) {
            app.grammarsUser = res.data;
            console.log(app.grammarsUser);
            if (app.$route.params.id != undefined) {
              let g = app.grammarsUser.find(e => e.id == app.$route.params.id);
              app.obj.name = g.name;
              app.obj.category_id = g.category_id;
              app.obj.structure_name = g.structure_name;
              app.obj.structure_description = g.structure_description;
              app.grammarRandom();
            }
          })
          .catch(function(res) {
            console.log(err);
          });
      }
    },
    search() {
      var app = this;
      app.loading = true;
      var url = "/api/v1/vocabularies/search/all";
      axios
        .get(url)
        .then(res => {
          app.searches = res.data;
        })
        .catch(res => {});
    },
    save(e) {
      var app = this;
      e.preventDefault();

      // if (this.name != '') {

      if (app.$route.params.id != undefined) {
        axios
          .post("/grammars/update/" + app.$route.params.id, app.obj)
          .then(function(res) {
            flash("Sửa thành công !", "success");
            axios
              .get("/grammars/" + app.user.id)
              .then(function(res) {
                app.grammarsUser = res.data;
              })
              .catch(function(res) {
                console.log(res);
              });
          })
          .catch(function(res) {
            flash("Không thành công , vui lòng thử lại !", "error");
          });
      } else {
        if (app.showGrammar !== undefined) {
          console.log(app.showGrammar);
          app.obj.structure_name = app.showGrammar.structure;
          app.obj.category_id = app.showGrammar.category_id;
          app.obj.structure_description = app.showGrammar.description;
        }

        axios
          .post("/grammars/create", app.obj)
          .then(function(res) {
            console.log(res);
            flash("Thêm thành công", "success");
            axios
              .get("/grammars/" + app.user.id)
              .then(function(res) {
                app.grammarsUser = res.data;
              })
              .catch(function(res) {
                console.log(res);
              });
            app.obj.name = "";
          })
          .catch(function(res) {
            flash("Thêm không thành công , vui lòng thử lại !", "error");
          });
      }
    },
    grammarRandom() {
      if (this.$route.params.id != undefined) {
        this.showGrammar = {
          category_id: this.obj.category_id,
          structure: this.obj.structure_name,
          description: this.obj.structure_description
        };
        console.log("this.showGrammar");
        console.log(this.showGrammar);
      } else {
        var len = this.grammars.length;
        console.log(this.grammars);
        this.showGrammar = this.grammars[Math.floor(Math.random() * len)];
      }
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
  background: url("/images/bg9.jpg");
  background-position: center bottom;
  background-size: cover;
  min-height: 85vh;
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
    background-image: linear-gradient(
      to right,
      #25aae1,
      #4481eb,
      #04befe,
      #3f86ed
    );
    box-shadow: 0 4px 15px 0 rgba(65, 132, 234, 0.75);
  }
  .btn-hover.color-4 {
    padding: 5px 25px;
    background-image: linear-gradient(
      to right,
      #fc6076,
      #ff9a44,
      #ef9d43,
      #e75516
    );
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
  .des-1 {
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
  }
}
</style>


