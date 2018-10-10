<template>
  <div>
    <div class="sosd-background-white sosd-box-shadow uk-padding sosd-no-margin" uk-grid>
      <div class="uk-width-1-4">
        <img :src="vocabulary.image" :alt="vocabulary.en">
      </div>
      <div class="uk-width-1-2">
        <h3>{{ vocabulary.en }}</h3>
        <p>{{ vocabulary.vi }}</p>
        <p>
          <i>{{ vocabulary.type }}</i>
        </p>
      </div>
      <div class="uk-width-1-4">
        <router-link :to="{name: 'newChildVocab', params: {id: vocabulary.id}}" class="uk-button uk-margin-small uk-button-default">Thêm từ liên kết</router-link>
        <router-link :to="{name: 'editVocab', params: {id: vocabulary.id}}" class="uk-button uk-margin-small uk-button-default">Sửa từ này</router-link>
        <button class="uk-button uk-margin-small uk-button-danger">Xóa từ này</button>
      </div>
    </div>

    <div class="uk-child-width-1-4 uk-margin-top" uk-grid="masonry: true">
      <div class="" v-for="v in childrens">
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
        user: {

        },
        vocabularies: [],
        vocabulary: {},
      }
    },
    computed: {
      childrens() {
        let id = this.vocabulary.id;
        return  this.vocabularies.filter((e) => { return e.parent_id == id});
      }
    },
    created() {
      this.user = Laravel.user;
      var app = this;
      axios.get('/api/v1/users/'+ Laravel.user.id +'/vocabularies')
      .then(function(res) {
        app.vocabularies = res.data;
        Laravel.vocabularies = res.data;
        for(let i = 0; i < app.vocabularies.length; i++) {
          if(app.$route.params.id == app.vocabularies[i].id)
            app.vocabulary = app.vocabularies[i];
        }
        app.vocabulary.type = JSON.parse(app.vocabulary.type).join(", ");
      })
      .catch(function(res) {
        console.log(res.data);
      })
    }
  }
</script>

<style lang="scss" scoped>

</style>
