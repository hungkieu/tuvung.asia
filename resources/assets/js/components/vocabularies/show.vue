<template>
  <div>
    <div class="uk-flex">
      <div class="uk-text-left uk-margin-right">
        <button @click="back" class="uk-button uk-button-primary sosd-color-white">
          <span uk-icon="icon: arrow-left;"></span> Quay lại
        </button>
      </div>
    </div>
    <div class="sosd-background-white uk-padding sosd-no-margin" uk-grid>
      <div class="uk-width-1-4" v-if="vocabulary.image">
        <img :src="vocabulary.image" :alt="vocabulary.en">
      </div>
      <div class="uk-width-1-2">
        <h3>{{ vocabulary.en }}</h3>
        <p>{{ vocabulary.vi }}</p>
        <p v-if="vocabulary.type !== 'null'" >
          <i>{{ vocabulary.type }}</i>
        </p>
      </div>
      <div class="uk-width-1-4 uk-text-right" v-if="vocabulary.id">
        <router-link :to="{name: 'newChildVocab', params: {id: vocabulary.id}}" class="uk-button uk-margin-small uk-button-default">Thêm từ liên kết</router-link>
        <router-link :to="{name: 'editVocab', params: {id: vocabulary.id}}" class="uk-button uk-margin-small uk-button-default">Sửa từ này</router-link>
        <button class="uk-button uk-margin-small uk-button-danger" style="color: #fff !important" href="#modal-del" uk-toggle>Xóa từ này</button>
      </div>
    </div>

    <div class="uk-child-width-1-4 uk-margin-top" uk-grid="masonry: true" v-if="childrens">
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

    <div id="modal-del" class="uk-flex-top" uk-modal>
      <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical  p-0  ">

        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-body text-center">
         <span uk-icon="icon: warning; ratio: 2" style="color: red"></span>
         <p class="pt-3">Bạn có chắc chắn muốn xóa từ này ?</p>
       </div>
       <div class="uk-modal-footer uk-text-right">
        <button class="uk-button uk-button-primary  uk-modal-close" type="button" @click="deleteVocabulary">Xóa</button>
        <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
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
      vocabulary: {}
    };
  },
  computed: {
    childrens() {
      let id = this.vocabulary.id;
      return this.vocabularies.filter(e => {
        return e.parent_id == id;
      });
    }
  },
  created() {
    this.user = Laravel.user;
    var app = this;
    axios
      .get('/api/v1/users/' + Laravel.user.id + '/vocabularies')
      .then(function(res) {
        app.vocabularies = res.data;
        Laravel.vocabularies = res.data;
        for (let i = 0; i < app.vocabularies.length; i++) {
          if (app.$route.params.id == app.vocabularies[i].id) app.vocabulary = app.vocabularies[i];
        }
        app.vocabulary.type = JSON.parse(app.vocabulary.type).join(', ');
      })
      .catch(function(res) {
        console.log('1' + res.data);
      });
  },
  methods: {
    back() {
      this.$router.go(-1);
    },

    deleteVocabulary() {
      this.user = Laravel.user;
      var app = this;

      axios
        .post('/vocabularies/' + app.$route.params.id + '/delete')
        .then(function(res) {
          app.$router.push('/vocabularies');
        })
        .catch(function(res) {
          alert('Bạn không thể xóa từ đã có từ liên kết');
        });
    }
  }
};
</script>

<style lang="scss" scoped>
nav {
  text-transform: uppercase;
  background: transparent;
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
a {
  text-decoration: none;
  &:hover {
    text-decoration: none;
    color: lightseagreen !important ;
  }
}
</style>
