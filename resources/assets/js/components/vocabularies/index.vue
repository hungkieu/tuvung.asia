<template>
  <div>
    <div class="uk-flex">
      <div class="uk-text-left uk-margin-right">
        <router-link to="/">
          <button class="uk-button uk-button-primary sosd-color-white">
            <span uk-icon="icon: arrow-left;"></span> Quay lại
          </button>
        </router-link>
      </div>
      <div class="uk-text-right uk-margin-right">
        <router-link :to="{name: 'newVocab'}"><button class="uk-button uk-button-primary sosd-color-white">Tạo từ vựng</button></router-link>
      </div>
    </div>

    <div class="uk-container sosd-vocabularies">
      <div class="uk-margin">
        <h4>Từ vựng của bạn</h4>
      </div>
      <hr>
      <div v-if="vocabularies_length > 0">
        <div class="uk-child-width-1-4 uk-margin-top uk-animation-slide-bottom" uk-grid="masonry: true">
          <div class="" v-for="v in vocabularies_root" >
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
      <div v-else>
        <div class="uk-margin uk-text-center">
          <b>Chưa có từ vựng nào</b>
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
      vocabularies: [],
    };
  },
  computed: {
    vocabularies_root() {
      return this.vocabularies.filter(e => {
        return e.parent_id == 0;
      });
    },

    vocabularies_length() {
      return this.vocabularies.length;
    }
  },
  methods: {
  },

  mounted() {
    this.user = Laravel.user;
    var app = this;
    axios
      .get('/api/v1/users/' + Laravel.user.id + '/vocabularies')
      .then(function(res) {
        app.vocabularies = res.data;
      })
      .catch(function(res) {
        alert('không load được từ vựng');
      });
  }
};
</script>

<style lang="scss" scoped>
  .sosd-vocabularies {
    background: white;
    padding: 15px;
  }
</style>
