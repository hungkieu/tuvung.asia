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
</style>
