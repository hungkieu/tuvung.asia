<template>
  <div>
    <div class="sosd_nav">
      <div class="uk-container">
        <router-link to="/">Trang chủ</router-link> <span uk-icon="icon: chevron-right; "></span>
        <span>Danh sách từ vựng</span>
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
        <div uk-grid>
            <div class="uk-width-3-4">
             <h3>Từ vựng của bạn</h3>
            </div>
            <div class="uk-width-1-4 sosd_nav_filter">
               <div class=" mr-3" title="Thêm từ vựng mới">
                 <!-- <button class="uk-button uk-button-primary"><router-link to="/vocabularies/new">Thêm</router-link></button> -->
                <router-link to="/vocabularies/new">
                <button class="btn-hover color-1">
                  <span class="uk-icon-button" uk-icon="icon: plus; ratio: 1"></span>
                  </button>
                  </router-link>
              </div>
              <div class="sosd_inline">
                <span uk-icon="grid"></span>
              </div>
              <div class="sosd_inline">
                <span uk-icon="list"></span>
              </div>
              <div class="sosd_inline">
                Lọc từ <span uk-icon="settings"></span>
              </div>
            </div>
        </div>
        <hr>
        <div v-if="vocabularies.length == 0">
          <b>Bạn chưa có từ vựng nào, </b>
          <router-link to="/vocabularies/new">Thêm từ vựng mới</router-link>
        </div>
        <div v-else>
          <div class="" uk-grid>
            <div class="uk-width-4-5">
              <div class="sosd_vocabularies uk-padding-small uk-child-width-1-4" uk-grid="masonry: true;" v-if="grid">
                <div v-for="v in vocabularies">
                  <router-link :to="{ name: 'showVocab', params: {id: v.id} }" class="vocab uk-card uk-card-default" uk-tooltip="Xem">
                    <div class="uk-card-media-top">
                      <img :src="v.image" alt="">
                    </div>
                    <div class="uk-card-body">
                      <div>
                        <h3 class="uk-card-title">{{ v.en }}</h3>
                        <p>{{ v.vi }}</p>
                      </div>
                    </div>
                  </router-link>
                </div>
              </div>

              <div class="sosd_vocabularies uk-padding-small" v-if="list">
                <div v-for="v in vocabularies">
                  <router-link :to="{ name: 'showVocab', params: {id: v.id} }">

                  </router-link>
                </div>
              </div>

            </div>
            <div class="uk-width-1-5">
              <ul class="uk-nav-default uk-nav-parent-icon sosd_none" uk-nav="multiple: true">
                <li class="uk-nav-header uk-parent">
                  <a href="#" style="text-transform: none;">Loại từ</a>
                  <ul class="uk-nav-sub">
                    <li>
                      <a href="#">
                        <label><input type="checkbox" class="uk-checkbox"> Danh từ</label>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <label><input type="checkbox" class="uk-checkbox"> Động từ</label>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <label><input type="checkbox" class="uk-checkbox"> Tính từ</label>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <label><input type="checkbox" class="uk-checkbox"> Trạng từ</label>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <label><input type="checkbox" class="uk-checkbox"> Giới từ</label>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <label><input type="checkbox" class="uk-checkbox"> Từ nối</label>
                      </a>
                    </li>
                  </ul>
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
      user: {},
      vocabularies: []
    };
  },
  mounted() {
    this.user = Laravel.user;
    this.get_vocabularies();
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
        url: '/api/v1/users/' + app.user.id + '/vocabularies',
        method: 'get'
      })
        .done(res => {
          app.vocabularies = res;
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
  button {
    a {
      color: #fff;
      font-weight: 500;
      &:hover {
        text-decoration: none;
      }
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
  }
}

.sosd_none {
  a {
    text-transform: none;
  }
}
.btn-hover {
  padding: 0;
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
