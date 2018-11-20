<template>
  <div class="mb-5">
      <div class="sosd-profile">
        <div class="user-profile" uk-gird>
          <div class="avatar">
            <img :src="user.avatar" alt="Ảnh đại diện" v-if="user.avatar" />
          </div>
          <div class="profile">
            <h3>{{ user.name }}</h3>
            <p><span id="score">{{ !!user.score ? user.score : 0 }}</span> Điểm</p>
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
          <div class="sosd_feature uk-width-1-2" v-for="s in sosd_features">
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
        <div class="container mt-2 uk-animation-slide-bottom">
          <div class="row">
            <div class="col-md-4">
              <div class="streak">
                <h4>Mục tiêu mỗi ngày</h4>
              </div>
              <div>
                <div v-if="user.target_score > 0">
                  <div class="progress" v-if="score_today">
                    <div class="progress-bar bg-success" role="progressbar" :style="{width: progress + '%'}" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                      {{ score_today.score >= user.target_score ? "Hoàn thành" : "" }}
                    </div>
                  </div>
                  <div class="text-center" v-if="score_today">
                    {{ score_today.score }} / {{ user.target_score }}
                  </div>
                </div>
                <div class="sosd_feature" v-else>
                  <router-link to="/setting/study-goal" class="sosd_card uk-animation-slide-bottom">
                    <div class="icon">
                      <img src="/svg/radar.svg" alt="" width="32" height="32">
                    </div>
                    <div class="name">
                      Đặt mục tiêu học tập của bạn
                    </div>
                  </router-link>
                </div>
              </div>
            </div>
            <div class="col-md-4 text-center">
              <div class="streak_count">
                <h4>Số ngày học liên tục</h4>
              </div>
              <div class="count">
                <span>{{ streak_count }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

  </div>
</template>

<script>
export default {
  data: function() {
    return {
      user: {},
      sosd_nav: [
        {
          id: 1,
          text: 'Chức năng',
          active: true
        },
        {
          id: 2,
          text: 'Thành tích của bạn',
          active: false
        },
        {
          id: 3,
          text: 'Bài viết',
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
              icon: '/svg/dictionary.svg',
              link: '/vocabularies/dictionary',
              name: 'Từ điển của bạn'
            },
            {
              icon: '/svg/review.svg',
              link: '/vocabularies/practice',
              name: 'Ôn tập'
            }
          ]
        },
        {
          title: 'Ngữ pháp',
          features: [
            {
              icon: '/svg/plus.svg',
              link: '/grammars',
              name: 'Luyện học ngữ pháp'
            },
            {
              icon: '/svg/notebook1.svg',
              link: '/grammars-list',
              name: 'Ngữ pháp của bạn'
            },
            // {
            //   icon: '/svg/list.svg',
            //   link: '/grammars-article',
            //   name: 'Bộ ngữ pháp cơ bản'
            // }
          ]
        }
      ],
      history_scores: [
      ],
    };
  },
  computed: {
    score_today() {
      return this.history_scores.filter(val => {
        var today = new Date();
        return val.day == today.getFullYear() + '-' + parseInt(today.getMonth() + 1) + '-' + today.getDate();
      })[0] || {score: 0}
    },
    progress() {
      return Math.round(this.score_today.score / this.user.target_score * 100);
    },
    streak_count() {
      var count = 0;
      for(let i = 0; i < this.history_scores.length; i++) {
        let val = this.history_scores[i];
        if(!!val.streak) {
          count += 1
        }
        else {
          break
        }
      }
      return count;
    },
  },
  mounted() {
    var app = this;
    this.get_infomation();
    this.get_history_scores();
  },
  methods: {
    get_infomation() {
      var app = this;
      axios.get('/users/' + Laravel.user.id, {
        responseType: 'json',
      })
      .then(res => {
        app.user = res.data;
      })
      .catch(res => {
        app.user = Laravel.user;
      })
    },

    get_history_scores() {
      var app = this;
      axios.get('/c/history-scores/', {
        responseType: 'json',
      })
      .then(res => {
        app.history_scores = res.data
      })
      .catch(res => {

      })
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

.count {
  span {
    font-size: 40px;
    color: #00C35C;
  }
}
</style>
