<template>
    <div class="item-structure">
        <div class="row mx-0">
        <div class="col-5">
            <input v-model="post.structure"  class="uk-input mb-3" type="text" name="structure" placeholder="Cấu trúc ngữ pháp" />
             <select class="uk-select" v-model="post.category_id">
                <option disabled >Chọn Danh mục</option>
                <option v-for="v in listCategory" :value="v.name">{{v.name}}</option>
            </select>
        </div>
        <div class="col-6">
            <textarea v-model="post.description"  rows="4" class="uk-textarea w-100 uk-text-emphasis" type="text" name="structure" placeholder="Mô tả"/>
        </div>
        <div class="col-1 text-right">
          <img src="/svg/minus.svg"  v-on:click="$emit('cancelPost')"/>
        </div>
        </div>
    </div>
</template>
<script>
export default {
  props: ['post'],
  data: function() {
    return {
      user: '',
      structure: '',
      category_id: '',
      description: '',
      listCategory: []
    };
  },
  mounted() {
    this.getCategory();
  },
  methods: {
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
    }
  }
};
</script>
<style lang="scss" scoped>
.item-structure {
  background: #f5f5f5;
  padding: 15px 20px;
  border-radius: 10px;
  margin: 15px;
  font-size: 14px;
  input {
    color: #000;
  }
  img {
    width: 25px;
    height: 25px;
  }
}
</style>


