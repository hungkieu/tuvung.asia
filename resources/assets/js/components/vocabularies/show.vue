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
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="sosd_background_af"></div>
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

        }
      }
    }
  }
  .sosd_background_af {
    width: 100%;
    height: 100px;
    background: rgb(250, 250, 250);
    border-top: 1px solid rgb(233, 233, 233);
    border-bottom: 1px solid rgb(233, 233, 233);
  }
</style>
