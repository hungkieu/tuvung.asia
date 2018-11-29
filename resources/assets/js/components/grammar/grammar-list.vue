<template>
  <div>
    <div class="sosd_nav">
      <div class="uk-container">
        <router-link to="/">Trang chủ</router-link>
        <span uk-icon="icon: chevron-right; "></span>
        <span>Ngữ pháp của bạn</span>
      </div>
    </div>

    <div v-if="loading">
      <Loading></Loading>
    </div>

    <div v-if="error">
      <b>Vui lòng thử lại</b>
    </div>

    <div v-if="success">
      <div class="uk-container pt-3 pb-5">
        <div class="pb-4 row justify-content-between">
          <div class="col-auto">
            <h4 class="title">Ngữ pháp của bạn</h4>
          </div>
          <div class="col-auto">
            <div class="row">
              <div class="col-md-12 d-flex">
                <div class="mr-3" title="Luyện ngữ pháp">
                  <router-link to="/grammars">
                    <button class="btn-hover color-1">
                      <span
                        class="uk-icon-button"
                        uk-icon="icon: plus; ratio: 1.2"
                        title="Luyện ngữ pháp"
                      ></span>
                    </button>
                  </router-link>
                </div>
                <div id="formSearch">
                  <button v-on:click="show = !show" class="btn-hover color-3 mr-3">
                    <span uk-icon="icon: search; ratio: 1.2" title="Tìm kiếm câu của bạn"></span>
                  </button>
                  <transition name="fade">
                    <input
                      v-if="show"
                      v-model="search"
                      class="sosd-input"
                      id="search"
                      name="search"
                      type="text"
                      placeholder="What're we looking for ?"
                    >
                  </transition>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-if="grammars">
          <div v-if=" grammars.length == 0">
            <b>Bạn chưa có câu hay bài viết tiếng anh nào.</b>
            <router-link to="/grammars">Cùng luyện ngữ pháp nào ^^</router-link>
          </div>
          <div v-else>
            <div class uk-grid>
              <div
                v-for="g in filteredList"
                v-bind:class="[g.name.length < 1000 ? 'uk-width-1-2' : 'uk-width-1-1']"
              >
                <div class="grammar-item">
                  <p class="w-100 my-3">
                    <b class="mt-2 d-inline-block">{{g.name}}</b>
                    <span title="Xóa bài viết" class="float-right" v-on:click="del(g)">
                      <span class="uk-icon-button" uk-icon="icon: trash; ratio: 1"></span>
                    </span>
                    <router-link
                      :to="'/grammars/edit/' + g.id"
                      title="Cải thiện bài viết"
                      class="float-right mr-3"
                    >
                      <span class="uk-icon-button" uk-icon="icon: pencil; ratio: 1"></span>
                    </router-link>
                  </p>
                  {{g.structure_name}}
                  <p class="text-right w-100 my-3">{{g.updated_at}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
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
  data() {
    return {
      error: false,
      success: false,
      loading: true,
      grammars: [],
      search: "",
      show: false
    };
  },
  computed: {
    filteredList() {
      return this.grammars.filter(post => {
        return post.name.toLowerCase().includes(this.search.toLowerCase());
      });
    }
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
    this.getGrammarUser();
  },
  methods: {
    getGrammarUser() {
      this.user = Laravel.user;
      var app = this;
      axios
        .get("/grammars/" + app.user.id)
        .then(function(res) {
          app.grammars = res.data;
          console.log("app.grammars");
          console.log(app.grammars);
          app.success = true;
        })
        .catch(function(res) {
          app.error = true;
        });
    },
    del(gram) {
      var app = this;
      axios
        .delete("/grammars/" + gram.id)
        .then(function(res) {
          app.grammars.splice(app.grammars.indexOf(gram), 1);
          console.log("Xóa thành công ");
        })
        .catch(function(res) {
          console.log("err" + res);
        });
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
.title {
  line-height: 50px;
}
.uk-first-column {
  .grammar-item {
    background: url("/images/book1.jpg");
    background-position: center;
    background-size: cover;
    padding: 1px 20px;
    color: #000;
    border-radius: 5px;
    overflow: hidden;
  }
}
.grammar-item {
  background: url("/images/book.jpg");
  background-position: center;
  background-size: cover;
  padding: 1px 20px;
  color: #fff;
  border-radius: 5px;
  overflow: hidden;
}
.btn-hover {
  padding: 0;
  width: 40px;
  height: 40px;
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
  span {
    background: transparent;
    color: #fff;
  }
}
.btn-hover.color-1 {
  background-image: linear-gradient(
    to right,
    #25aae1,
    #40e495,
    #30dd8a,
    #2bb673
  );
  box-shadow: 0 4px 15px 0 rgba(49, 196, 190, 0.75);
}
.btn-hover.color-3 {
  background-image: linear-gradient(
    to right,
    #667eea,
    #764ba2,
    #6b8dd6,
    #8e37d7
  );
  box-shadow: 0 4px 15px 0 rgba(116, 79, 168, 0.75);
}
#formSearch {
  .fade-enter-active,
  .fade-leave-active {
    transition: all 1s ease;
    width: 200px;
    visibility: visible;
  }
  .fade-enter,
  .fade-leave-to {
    width: 0;
    visibility: hidden;
    transition: all 1s ease;
  }
  .sosd-input {
    padding: 5px 10px;
    border: 1px solid #1f8bf0;
  }
}
</style>


