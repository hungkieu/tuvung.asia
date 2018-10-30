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
            <div class="uk-width-4-5">
             <h3>Từ vựng của bạn</h3>
            </div>
            <div class="uk-width-1-5 sosd_nav_filter">
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
                  <router-link :to="{ name: 'showVocab', params: {id: v.id} }" class="vocab uk-card uk-card-default">
                    <div class="uk-card-media-top">
                      <img :src="v.image" alt="">
                    </div>
                    <div class="uk-card-body">
                      <div>
                        <h3 class="uk-card-title">{{ v.en }}</h3>
                        <p>{{ v.vi }}</p>
                      </div>
                    </div>
                    <div class="ticket" uk-tooltip="title: Ưa thích">
                      <i class="fa fa-star" aria-hidden="true"></i>
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
    Loading: Loading,
  },
  data: function() {
    return {
      error: false,
      success: false,
      loading: true,
      grid: true,
      list: false,
      user: {},
      vocabularies: [],
    };
  },
  mounted() {
    this.user = Laravel.user;
    this.get_vocabularies();
  },
  watch: {
    error() {
      if(this.error) {
        this.success = false;
        this.loading = false;
      }
    },
    success() {
      if(this.success) {
        this.error = false;
        this.loading = false;
      }
    },
    loading() {
      if(this.loading) {
        this.error = false;
        this.success = false;
      }
    },
    grid() {
      if(this.grid) {
        this.list = false;
      }
    },
    list() {
      if(this.list) {
        this.grid = false;
      }
    }
  },
  methods: {
    get_vocabularies() {
      var app = this;
      $.ajax({
        url: "/api/v1/users/" + app.user.id + "/vocabularies",
        method: 'get',
      })
      .done(res => {
        app.vocabularies = res;
        setTimeout(function() {
          app.success = true;
        },500);
      })
      .fail(res => {
        setTimeout(function() {
          app.error = true;
        },500);
      })
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
        h3, p {
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
</style>
