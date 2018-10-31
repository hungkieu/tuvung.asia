<template>
  <div>
    <div v-if="loading">
      <Loading></Loading>
    </div>

    <div v-if="error">
      <b>Vui lòng thử lại</b>
    </div>

    <div v-if="success">
      <div class="sosd_nav">
        <div class="uk-container">
          <router-link to="/">Trang chủ</router-link> <span uk-icon="icon: chevron-right; "></span>
          <router-link to="/vocabularies">Từ vựng của bạn</router-link> <span uk-icon="icon: chevron-right; "></span>
          <span v-if="vocabulary">{{ vocabulary.en }}</span>
        </div>
      </div>

      <div class="sosd_background" v-bind:style="{background: bgR}">
        <div class="sosd_card">
          <div class="sosd_image">
            <div v-if="vocabulary.image">
              <img :src="vocabulary.image" alt="image">
            </div>
            <div v-else>
              <p class="char">{{ vocabulary.en[0] }}</p>
            </div>
          </div>
          <div class="body" uk-grid>
            <div>
              <p><h4>{{ vocabulary.en }}</h4></p>
              <p><span>{{ vocabulary.vi }}</span></p>
              <p><i>{{ type }}</i></p>
            </div>
            <div class="uk-width-expand tool">
              <div class="icon text-right px-3">
                <span uk-icon="more"></span>
                <div class="uk-width-expand tool uk-inline">

                  <div class="icon" uk-tooltip="Xem thêm" uk-toggle="target: #m_tool">
                    <span uk-icon="more"></span>
                  </div>

                  <div id="m_tool" class="sosd_dialog" uk-dropdown="mode: click; pos: bottom-right">
                    <div>
                      <ul>
                        <li>
                          <router-link :to="{name: 'newChildVocab', params: { id: vocabulary.id }}" >
                            Thêm từ liên kết
                          </router-link>
                        </li>
                        <li>
                          <router-link :to="{name: 'editVocab', params: { id: vocabulary.id }}" >
                            Sửa
                          </router-link>
                        </li>
                        <li>
                          <a href="javascript:void(0);">
                            Xóa
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
          <div class="sosd_background_af"></div>
          <div v-if="pedigree.length == 0">
            <div class="uk-margin-top text-center">
              <b>Từ này chưa có từ liên kết đến, <router-link :to="{name: 'newChildVocab', params: { id: vocabulary.id }}" >Thêm ngay</router-link></b>
            </div>
          </div>
          <div class="uk-container" v-else>
            <div class="sosd_vocabularies uk-padding-small uk-child-width-1-5" uk-grid="masonry: true;">
              <div v-for="v in pedigree">
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
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script src="">
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
        vocabulary: {},
        pedigree: [],
        user: {},
        bg: [
        "url('/svg/showVocab/bg1.svg')",
        "url('/svg/showVocab/bg2.svg')",
        "url('/svg/showVocab/bg3.svg')",
        "url('/svg/showVocab/bg4.svg')",
        "url('/svg/showVocab/bg5.svg')",
        ],
      }
    },
    computed: {
      bgR() {
        return this.bg[Math.round(Math.random() * 4)];
      },

      type() {
        let types = ["Danh từ", "Động từ", "Tính từ", "Trạng từ", "Giới từ", "Từ nối"];
        return this.vocabulary.type.split(",").map(v => {
          return types[v];
        }).join(",");
      }
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
    },
    mounted() {
      this.user = Laravel.user;
      this.get_vocabularies();
    },
    methods: {
      get_vocabularies() {
        var app = this;
        $.ajax({
          url: "/api/v1/vocabularies/" + app.$route.params.id + "/pedigree",
          method: 'get',
        })
        .done(res => {
          app.vocabulary = res.vocabulary;
          app.pedigree = res.vocabularies;
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
    }
  }
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

.sosd_background{
  box-sizing: border-box;
  background-repeat: no-repeat;
  background-size: cover;
  width: 100%;
  height: 200px;
  position: relative;
  display: flex;
  justify-content: center;
  top: 0;
  .sosd_card {
    position: absolute;
    top: 60%;
    box-sizing: border-box;
    width: 50%;
    height: 150px;
    background: white;
    box-shadow: 0 0px 1px 1px rgba(33, 33, 33, 0.2);
    .sosd_image {
      box-sizing: border-box;
      float: left;
      img {
        width: 150px;
        height: 150px;
      }
      .char {
        color: white;
        width: 150px;
        height: 150px;
        box-sizing: border-box;
        line-height: 150px;
        text-align: center;
        background: #f38c81;
        font-size: 36px;
        text-transform: uppercase;
      }
    }
    .body {
      .tool {
        display: flex;
        justify-content: flex-end;
        .icon {
          display: flex;
          width: 32px;
          height: 32px;
          margin-top: 5px;
          margin-right: 10px;
          justify-content: center;
          align-items: center;
          background: white;
          border: none;
          outline: none;
          border-radius: 50%;
          cursor: pointer;
          &:hover {
            background: rgb(233, 233, 233);
          }
        }
      }
    }
  }
}
.sosd_background_af {
  width: 100%;
  height: 150px;
  background: rgb(250, 250, 250);
  border-top: 1px solid rgb(233, 233, 233);
  border-bottom: 1px solid rgb(233, 233, 233);
}
.sosd_dialog {
  padding: 0;
  width: auto;
  ul {
    margin: 0;
    padding: 0;
    list-style: none;
    li {
      a {
        text-decoration: none;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 200px;
        height: 50px;
        color: #333333;
        &:hover {
          background: #03B1E8;
          color: white;
        }
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
      h3, p {
        margin: 8px 0;
        padding: 0;
      }
    }
    img {
      width: 100%;
    }
  }
}
</style>
