<template>
<div>
    <div class="sosd_nav">
      <div class="uk-container">
        <router-link to="/">Trang chủ</router-link> <span uk-icon="icon: chevron-right; "></span>
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
        <div uk-grid class="pb-4">
            <div class="uk-width-3-4">
             <h4 class="title">Ngữ pháp của bạn</h4>
            </div>
            <div class="uk-width-1-4 sosd_nav_filter text-right">
               <div class=" mr-3" title="Luyện ngữ pháp">
                <router-link to="/grammar">
                <button class="btn-hover color-1">
                <span class="uk-icon-button" uk-icon="icon: pencil; ratio: 1.5"></span>
                </button>
                </router-link>
            </div>
                <!-- <div class="sosd_inline">
                <span uk-icon="grid"></span>
              </div>
              <div class="sosd_inline">
                <span uk-icon="list"></span>
              </div>
              <div class="sosd_inline">
                Lọc từ <span uk-icon="settings"></span>
              </div> -->
            </div>
        </div>
        <div v-if="grammars.length == 0">
          <b>Bạn chưa có câu hay bài viết tiếng anh nào. </b>
          <router-link to="/grammar"> Cùng luyện ngữ pháp nào ^^ </router-link>
        </div>
        <div v-else>
          <div class="" uk-grid>
            <div v-for="g in grammars"  v-bind:class="[g.description.length < 1000 ? 'uk-width-1-2' : 'uk-width-1-1']">
                <div class="grammar-item">
                  <p class="w-100 my-3">
                    <b class="mt-2 d-inline-block">
                     {{g.name}}
                     </b>
                    <span title="Xóa bài viết" class="float-right" v-on:click="del(g)" ><span class="uk-icon-button" uk-icon="icon: trash; ratio: 1"></span></span>  
                    <router-link :to="'/grammar/update/' + g.id" title="Cải thiện bài viết" class="float-right mr-3"><span class="uk-icon-button" uk-icon="icon: pencil; ratio: 1"></span></router-link>  
                  </p>
                 {{g.description}}
                  <p class="text-right w-100 my-3">
                    {{g.updated_at}}
                  </p>
              </div>
            </div>
          </div>
        </div>
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
  data() {
    return {
      error: false,
      success: false,
      loading: true,
      grammars: []
    };
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
        .get('/grammar/' + app.user.id)
        .then(function(res) {
          app.grammars = res.data;
          app.success = true;
          console.log('res' + JSON.stringify(app.grammars));
        })
        .catch(function(res) {
          app.error = true;
          console.log('err' + res);
        });
    },
    del(gram) {
      var app = this;
      axios
        .delete('/grammar/delete/' + gram.id)
        .then(function(res) {
          app.grammars.splice(app.grammars.indexOf(gram), 1);
          console.log('Xóa thành công ');
        })
        .catch(function(res) {
          console.log('err' + res);
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
    background: url('/images/book1.jpg');
    background-position: center;
    background-size: cover;
    padding: 1px 20px;
    color: #000;
    border-radius: 5px;
    overflow: hidden;
  }
}
.grammar-item {
  background: url('/images/book.jpg');
  background-position: center;
  background-size: cover;
  padding: 1px 20px;
  color: #fff;
  border-radius: 5px;
  overflow: hidden;
}
.btn-hover {
  padding: 10px;
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
  background-image: linear-gradient(to right, #25aae1, #40e495, #30dd8a, #2bb673);
  box-shadow: 0 4px 15px 0 rgba(49, 196, 190, 0.75);
}
</style>


