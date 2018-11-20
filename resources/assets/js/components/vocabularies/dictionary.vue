<template>
  <div>
    <div class="sosd_nav">
      <div class="uk-container">
        <router-link to="/">Trang chủ</router-link> <span uk-icon="icon: chevron-right; "></span>
        <span>Từ điển của bạn</span>
      </div>
    </div>

    <div v-if="loading">
      <Loading></Loading>
    </div>

    <div v-if="error">
      <b>Vui lòng thử lại</b>
    </div>

    <div v-if="success">
      <div class="uk-container uk-margin-top">
        <div class="row justify-content-between">
            <div class="col-auto">
             <h3>Từ điển của bạn</h3>
            </div>
            <!-- <div class="col-auto">
                 <div id="formSearch">
                      <button v-on:click="show = !show" class="btn-hover color-3 mr-3"><span uk-icon="icon: search; ratio: 1.2"></span></button>
                      <transition name="fade">
                        <input v-if="show" v-model="search" class="sosd-input" id="search" name="search" type="text" placeholder="Bạn muốn tìm từ nào ?">
                      </transition>
                  </div>
            </div> -->
        </div>
        <hr>
        <div v-if="dictionary.length == 0">
          <b>Bạn chưa có từ vựng nào, </b>
          <router-link to="/vocabularies/new">Thêm từ vựng mới</router-link>
        </div>
        <div v-else>
          <div class="uk-child-width-1-3" uk-grid="masonry: true">
            <div v-for="d in dictionary">
              <h3>{{ d.title }}</h3>
              <hr>
              <ul>
                <li class="uk-column-1-2" v-for="v in d.vocabularies">
                  <div>
                      <router-link :to="{name: 'showVocab', params: {id: v.id}}" >
                        {{ v.en }}
                      </router-link>
                  </div>
                  <div>{{ v.vi }}</div>
                </li>
              </ul>
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
  data: function() {
    return {
      error: false,
      success: false,
      loading: true,
      grid: true,
      list: false,
      show: false,
      user: {},
      dictionary: [],
      search: ''
    };
  },
  mounted() {
    this.user = Laravel.user;
    this.get_vocabularies();
  },
  computed: {

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
    },
    grid() {
      if (this.grid) {
        this.list = false;
      }
    },
    list() {
      if (this.list) {
        this.grid = false;
      }
    }
  },
  methods: {
    get_vocabularies() {
      var app = this;
      $.ajax({
        url: '/api/v1/users/' + app.user.id + '/vocabularies/dictionary',
        method: 'get'
      })
        .done(res => {
          let arr = [];
          let has = [];
          res.forEach((item, index) => {
            if (has.includes(item.en[0])) {
              arr.forEach((obj, index2) => {
                if (obj.title == item.en[0]) obj.vocabularies.push(item);
              });
            } else {
              let obj = {
                title: item.en[0],
                vocabularies: [item]
              };
              has.push(item.en[0]);
              arr.push(obj);
            }
          });
          app.dictionary = arr;
          setTimeout(function() {
            app.success = true;
          }, 500);
        })
        .fail(res => {
          setTimeout(function() {
            app.error = true;
          }, 500);
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.sosd_nav {
  box-sizing: border-box;
  background: rgb(247, 247, 247);
  border-bottom: 1px solid rgb(233, 233, 233);
  width: 100%;
  height: 50px;
  line-height: 50px;
}

.sosd_nav_filter {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  .sosd_inline {
    display: inline-block;
    padding: 5px;
    &:hover {
      background: rgb(247, 247, 247);
      color: #1f8bf0;
      cursor: pointer;
    }
  }
}

.sosd_vocabularies {
  .vocab {
    position: relative;
    display: inline-block;
    text-decoration: none;
    .uk-card-body {
      padding: 10px 30px;
      h3,
      p {
        margin: 8px 0;
        padding: 0;
      }
    }
    img {
      width: 100%;
    }
    .ticket {
      position: absolute;
      top: 10px;
      right: 10px;
      padding: 2px 5px;
      color: #eeeeee;
      border: 1px solid #eeeeee;
      i {
        transition: all ease 1s;
      }
      &:hover i {
        transform: rotate(360deg);
      }
    }
  }
}

.sosd_none {
  a {
    text-transform: none;
  }
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
  background-image: linear-gradient(to right, #25aae1, #40e495, #30dd8a, #2bb673);
  box-shadow: 0 4px 15px 0 rgba(49, 196, 190, 0.75);
}
.btn-hover.color-3 {
  background-image: linear-gradient(to right, #667eea, #764ba2, #6b8dd6, #8e37d7);
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
