<template>
     <div class="uk-margin-right">
      <div class="row justify-content-between title">
        <div class="col-auto">
           <h4>Thêm danh mục ngữ pháp</h4>
        </div>
       
      </div>
        <div class="row mt-3">
            <div class="col-6 mr-5">
                <p class="mb-2">Tên danh mục <span class="uk-text-danger">*</span></p>
                <input type="text" v-model="newCategory.name" class="uk-input w-100"/>
                <p class="mt-3 mb-0">Thuộc danh mục<span class="uk-text-danger">*</span></p>
                <small class="d-inline-block">
                <i>Nếu danh mục bạn tạo thuộc danh mục nào đó đó đã tồn tại hãy chọn danh mục đó nếu không chọn "NONE"</i>
                </small>
                <select class="uk-select mt-3" v-model="newCategory.parent_id">
                    <option value="">None</option>
                    <option v-for="ca in listCategory" :value="ca.id" v-if="ca.parent_id == null">{{ca.name}}</option>
                </select>
                <p class="mb-2 mt-3">Mô tả</p>
                <textarea  v-model="newCategory.description" class="uk-textarea w-100" rows="4"/>
                 <div class="btn-group w-100 d-inline-block  mt-4">
                <button class="btn-hover color-1" @click="save">
                            Lưu
                </button>
            </div>
            </div> 
                <div class="col-4 list-category">
                <p class="mb-2"><b>Danh sách danh mục hiện tại</b></p>
                <ul uk-accordion="multiple: true">
                  <li class="uk-open" v-for="ca in listCategory">
                      <a class="uk-accordion-title" href="#" v-if="ca.parent_id == null">{{ca.name}}</a>
                      <div v-for="g in listCategory" v-if="ca.id === g.parent_id" class="ml-4 uk-accordion-content">
                          <a>{{g.name}}</a>
                      </div>
                  </li>
                
              </ul>
            </div>
        </div>
       
        <!-- <div class="uk-alert-success" uk-alert uk-toggle=".success">
          <a class="uk-alert-close" uk-close></a>
            <p>Tạo thành công</p>
        </div> -->
    </div>
</template>
<script>
export default {
  data() {
    return {
      user: [],
      newCategory: {
        name: '',
        description: '',
        parent_id: '',
        pedigree: ''
      },
      listCategory: []
    };
  },
  mounted() {
    this.getCategory();
    // UIkit.alert('success').close();
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
    },
    save(e) {
      var app = this;
      e.preventDefault();
      axios
        .post('/admin/category-structure-grammars/' + app.user.id + '/new', app.newCategory)
        .then(function(res) {
          alert('Tạo thành công !');
          // UIkit.alert('success').show();
          console.log(res);
        })
        .catch(function(res) {
          alert('Không thành công , vui lòng thử lại !');
          console.log(res);
        });
    }
  }
};
</script>
<style lang="scss" scoped>
.title {
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
.list-category {
  .uk-accordion-title {
    font-size: 16px;
  }
}
</style>


