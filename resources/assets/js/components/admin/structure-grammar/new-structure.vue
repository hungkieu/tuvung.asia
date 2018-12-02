<template>
    <div class="uk-margin-right">
      <div class="row justify-content-between title mx-0">
        <div class="col-auto">
           <h4>Thêm ngữ pháp</h4>
        </div>
        
      </div>
        <ItemStructure  
        v-for="(post, index) in sentence"
        v-bind:key="post.id"
        v-bind:post="post"
        v-on:cancelPost="cancelPost(index)" />
        <div class="btn-group w-100 d-inline-block px-3">
            <img src="/svg/plus.svg" @click="addItem()" title="Thêm cấu trúc mới"/>
            <button class="btn-hover color-1 float-right" @click="save()">
                Lưu
            </button>
        </div>
    </div>
</template>
<script>
import ItemStructure from './item-structure.vue';
export default {
  components: {
    ItemStructure: ItemStructure
  },
  data: function() {
    return {
      user: '',
      item: {
        structure: '',
        description: '',
        examples: '',
        image: '',
        category_id: ''
      },
      sentence: [],
      listCategory: []
    };
  },
  mounted() {
    this.getCategory();
    this.sentence.push({ ...this.item });
  },
  methods: {
    addItem() {
      this.sentence.push({ ...this.item });
    },
    getCategory() {
      this.user = Laravel.user;
      var app = this;
      axios
        .get('/admin/category-structure-grammars')
        .then(function(res) {
          console.log(res);
          app.listCategory = res.data;
        })
        .catch(function(res) {
          console.log(res);
        });
    },
    save() {
      var app = this;
      if (
        app.sentence.find(e => e.structure == '') ||
        app.sentence.find(e => e.category_id == '')
      ) {
        alert('Bạn phải nhập đầy đủ thông tin !');
        return;
      }
      axios
        .post('/admin/structure-grammars/' + app.user.id + '/new', { list: app.sentence })
        .then(function(res) {
          app.$router.push('/admin/structure-grammars');
        })
        .catch(function(res) {
          console.log(res);
        });
    },
    cancelPost(index) {
      this.sentence.splice(index, 1);
    }
  }
};
</script>
<style lang="scss" scoped>
.title {
  a {
    &:hover {
      text-decoration: none;
    }
  }
  img {
    width: 35px;
    height: 35px;
    cursor: pointer;
    margin: 0 5px;
  }
}
.btn-group {
  img {
    width: 35px;
    height: 35px;
    cursor: pointer;
  }
  .btn-hover {
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 600;
    color: #fff;
    cursor: pointer;
    text-transform: uppercase;
    text-align: center;
    border: none;
    background-size: 300% 100%;
    border-radius: 10px;
    moz-transition: all 0.4s ease-in-out;
    -o-transition: all 0.4s ease-in-out;
    -webkit-transition: all 0.4s ease-in-out;
    transition: all 0.4s ease-in-out;
    &:hover {
      background-position: 100% 0;
      moz-transition: all 0.4s ease-in-out;
      -o-transition: all 0.4s ease-in-out;
      -webkit-transition: all 0.4s ease-in-out;
      transition: all 0.4s ease-in-out;
    }
    &:focus {
      outline: none;
    }
    span {
      background: transparent;
      color: #fff;
    }
  }
  .btn-hover.color-1 {
    background-image: linear-gradient(to right, #25aae1, #40e495, #30dd8a, #2bb673);
    box-shadow: 0 4px 15px 0 rgba(49, 196, 190, 0.75);
  }
}
</style>


