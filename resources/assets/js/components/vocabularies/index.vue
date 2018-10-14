<template>
  <div>
      <nav class="" uk-navbar>
        <div class="uk-navbar-left">
            <router-link to="/">Trang chủ</router-link> <span uk-icon="icon: chevron-right; "></span>
            <router-link to="/vocabularies">Từ vựng</router-link>
        </div>
        <div class="uk-navbar-right">
            <router-link :to="{name: 'newVocab'}"><button class="uk-button uk-button-primary sosd-color-white">Tạo từ vựng</button></router-link>
        </div>
      </nav>

    <div class="uk-child-width-1-4 uk-margin-top" uk-grid="masonry: true">
      <div class="" v-for="v in vocabularies" >
        <router-link :to="{name: 'showVocab', params: {id: v.id}}">
          <div class="uk-card sosd-background-white uk-card-hover">
            <div class="uk-card-media-top">
              <img :src="v.image" alt="">
            </div>
            <div class="uk-card-body uk-padding-small text-center">
              <h3 class="uk-card-title">{{ v.en }}</h3>
              <p>{{ v.vi }}</p>
            </div>
          </div>
        </router-link>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  data: function() {
    return {
      user: {},
      vocabularies: []
    };
  },
  mounted() {
    this.user = Laravel.user;
    var app = this;
    axios
      .get('/api/v1/users/' + Laravel.user.id + '/vocabularies')
      .then(function(res) {
        app.vocabularies = res.data;
        app.vocabularies = app.vocabularies.filter(e => {
          return e.parent_id == 0;
        });
      })
      .catch(function(res) {
        console.log(res.data);
      });
  }
};
</script>

<style lang="scss" scoped>
nav {
  span.uk-icon {
    display: inherit;
    padding: 0 10px;
  }
  a {
    font-weight: bold;
    &:hover {
      text-decoration: none;
      color: tomato;
    }
  }
}
</style>
