<template>
  <div>
    <div v-if="loading">
      <Loading></Loading>
    </div>

    <div v-if="error">
      <h3>Không tải được dữ liệu</h3>
    </div>


    <div v-if="success">
      <div class="sosd-profile">
        <div class="user-profile" uk-gird>
          <div class="avatar">
            <img :src="user.avatar" alt="Ảnh đại diện" v-if="user.avatar" />
          </div>
          <div class="profile">
            <h3>{{ user.name }}</h3>
            <p><span id="score">1000</span> Điểm</p>
          </div>
        </div>
      </div>

      <div class="sosd-nav">
        <span @click="nav_active(nav.id)" v-for="nav in sosd_nav" v-bind:class="{active: nav.active, 'nav' : true}">
          {{ nav.text }}
        </span>
      </div>

      <div v-if="sosd_nav[0].active" class="uk-container uk-margin-top">
        <div uk-grid>
          <div class="sosd_feature uk-width-1-3" v-for="s in sosd_features">
            <div class="title">
              <h3>{{ s.title }}</h3>
            </div>
            <hr>
            <div v-for="f in s.features">
              <router-link :to="f.link" class="sosd_card uk-animation-slide-bottom">
                <div class="icon">
                  <img :src="f.icon" alt="" width="32" height="32">
                </div>
                <div class="name">
                    {{ f.name }}
                </div>
              </router-link>
            </div>

          </div>
        </div>
      </div>


      <div v-if="sosd_nav[1].active">
        Thong ke
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
      user: {},
      sosd_nav: [
        {
          id: 1,
          text: 'Chức năng',
          active: true
        },
        {
          id: 2,
          text: 'Thống kê',
          active: false
        }
      ],
      sosd_features: [
        {
          title: 'Từ vựng',
          features: [
            {
              icon: '/svg/plus.svg',
              link: '/vocabularies/new',
              name: 'Thêm từ mới'
            },
            {
              icon: '/svg/list.svg',
              link: '/vocabularies',
              name: 'Danh sách từ vựng'
            },
            {
              icon: '/svg/favourite.svg',
              link: '/vocabularies',
              name: 'Từ ưa thích của bạn'
            },
            {
              icon: '/svg/dictionary.svg',
              link: '/vocabularies/dictionary',
              name: 'Từ điển của bạn'
            },
            {
              icon: '/svg/review.svg',
              link: '/vocabularies',
              name: 'Ôn tập'
            }
          ]
        }
      ]
    };
  },
  computed: {
    loading() {
      return !this.success && !this.error;
    }
  },
  mounted() {
    var app = this;
    this.get_infomation();
  },
  methods: {
    get_infomation() {
      if (Laravel.user) {
        this.user = Laravel.user;
        this.success = true;
      } else {
        this.success = false;
        this.error = true;
      }
    },

    nav_active(id) {
      for (let i = 0; i < this.sosd_nav.length; i++) {
        if (this.sosd_nav[i].id == id) {
          this.sosd_nav[i].active = true;
        } else {
          this.sosd_nav[i].active = false;
        }
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.sosd-profile {
  box-sizing: border-box;
  width: 100%;
  height: 150px;
  background: white url('/svg/Flat-Mountains.svg') no-repeat bottom right;
  background-size: 500px 250px;
  position: relative;
  .user-profile {
    box-sizing: border-box;
    width: 60%;
    height: 100%;
    display: flex;
    align-items: center;
    padding: 0 50px;
    .avatar {
      float: left;
      img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
      }
    }
    .profile {
      padding: 0 10px;
      #score {
        color: #1f8bf0;
      }
    }
  }
}

.sosd-nav {
  box-sizing: border-box;
  background: rgb(247, 247, 247);
  width: 100%;
  height: 60px;
  border-bottom: 1px solid rgb(235, 235, 235);
  display: flex;
  align-items: center;
  justify-content: center;
  .nav {
    display: inline-block;
    height: 60px;
    line-height: 60px;
    padding: 0 20px;
    transition: color ease 0.5s;
    &:hover {
      border-bottom: 2px solid #1f8bf0;
      color: #1f8bf0;
      cursor: pointer;
    }
  }
  .active {
    font-weight: bold;
    color: #1f8bf0;
    border-bottom: 2px solid #1f8bf0;
  }
}

.sosd_feature {
  .sosd_card {
    box-sizing: border-box;
    width: 100%;
    height: 50px;
    display: block;
    line-height: 50px;
    transition: ease all 1s;
    .icon {
      float: left;
      img {
        transition: ease all 1s;
      }
    }
    .name {
      float: left;
      margin-left: 20px;
    }
  }
  .sosd_card:hover {
    background: aliceblue;
    padding: 0 20px;
  }
  .sosd_card:hover img {
    transform: rotate(360deg);
  }
}
</style>
