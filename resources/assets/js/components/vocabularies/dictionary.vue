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
        <div>
            <div>
             <h3>Từ điển của bạn</h3>
            </div>
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
      dictionary: [],
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
        let arr = [];
        let has = [];
        res.forEach((item, index) => {
          if(has.includes(item.en[0])) {
            arr.forEach((obj, index2) => {
              if(obj.title == item.en[0])
                obj.vocabularies.push(item);
            })
          } else {
            let obj = {
              title: item.en[0],
              vocabularies: [item],
            }
            has.push(item.en[0]);
            arr.push(obj);
          }

        })
        app.dictionary = arr;
        setTimeout(function() {
          app.success = true;
        },500);
      })
      .fail(res => {
        setTimeout(function() {
          app.error = true;
        },500);
      })
    },
  },
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
