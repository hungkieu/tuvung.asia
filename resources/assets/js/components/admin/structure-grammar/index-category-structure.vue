<template>
     <div class="uk-margin-right">
      <div class="row justify-content-between title">
        <div class="col-auto">
           <h4>Quản lý danh mục ngữ pháp</h4>
        </div>
       <div class="col-auto pr-5">
        <a class="" href="#modal-category" uk-toggle><img src="/svg/plus.svg" title="Tạo cấu trúc mới" style="    width: 35px;"/></a>
          
        </div>
      </div>
        <div class="sosd-background-white">
      <div class="uk-overflow-auto">
        <!-- <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
          <thead>
            <tr class="">
              <th class="uk-table-shrink text-center">Id</th>
              <th class="uk-table-expand text-center">Danh mục</th>
              <th class="uk-table-expand text-center">Thuộc danh mục</th>
              <th class="uk-table-expand text-center">Mô tả</th>
              <th class="uk-table-shrink uk-text-nowrap text-center">Người tạo</th>
              <th class="uk-table-expand text-center">Hành động</th>
            </tr>
          </thead>
            <paginate
              name="pusers"
              :list="listCategory"
              :per="10"
              tag="tbody"
            >
              <tr v-for="g in paginated('pusers')">
                <td class="text-center">{{ g.id }}</td>
                <td class="text-center"> {{ g.name}} </td>
                <td class="uk-text-truncate">
                  <p>{{g.description}}</p>
                </td>
                <td class="text-center">{{ g.parent_id }}</td>
                <td class="uk-text-nowrap text-center">{{ users.find(e => e.id === g.user_id).email }}</td>
                <td class="text-center">
                  <span class="uk-icon-button uk-alert-success" uk-icon="pencil" :href="'#b' + g.id" uk-toggle></span>
                  <span class="uk-icon-button uk-alert-danger" uk-icon="trash" @click="del(g)"></span>
                </td>
                <div :id="'b' + g.id" class="uk-flex-top" uk-modal>
                  <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                      <button class="uk-modal-close-default" type="button" uk-close></button>
                      <div class="uk-modal-header pt-0">
                    <h5 class="">Thay đổi danh mục {{ g.name}}</h5>
                     </div>
                    <div class="uk-modal-body">
                      <p class="mb-2">Tên danh mục <span class="uk-text-danger">*</span></p>
                <input type="text" v-model="g.name" class="uk-input w-100"/>
                <p class="mt-3 mb-0">Thuộc danh mục<span class="uk-text-danger">*</span></p>
                <small class="d-inline-block">
                <i>Nếu danh mục bạn tạo thuộc danh mục nào đó đó đã tồn tại hãy chọn danh mục đó nếu không chọn "NONE"</i>
                </small>
                <select class="uk-select mt-3" v-model="g.parent_id">
                    <option value="">None</option>
                    <option v-for="ca in listCategory" :value="ca.id" v-if="ca.parent_id == null">{{ca.name}}</option>
                </select>
                <p class="mb-2 mt-3">Mô tả</p>
                <textarea  v-model="g.description" class="uk-textarea w-100" rows="4"/>
                    </div>
                    <div class="uk-modal-footer pb-0 text-right">
                      <button class="uk-button uk-button-primary" type="button" @click="edit(g.id)">Save</button>
                      <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                    </div>
                 
                  </div>
              </div>
              </tr>
            </paginate>
        </table> -->
      </div>
    </div>
       

<div id="modal-category" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

        <button class="uk-modal-close-default" type="button" uk-close></button>

          <div class="uk-modal-header pt-0">
            <h5 class="">Thêm danh mục ngữ pháp</h5>
        </div>
        <div class="uk-modal-body">
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
        <div class="uk-modal-footer pb-0 text-right">
           <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
            <button class="uk-button uk-button-primary uk-modal-close" type="button" @click="save">Save</button>
        </div>
    </div>
        </div>
    </div>
</div>
    </div>
</template>
<script>
export default {
  data() {
    return {
      user: [],
      paginate: ['pusers'],
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
      console.log(app.user.id);
      // e.preventDefault();
      // axios
      //   .post('/admin/category-structure-grammars/' + app.user.id + '/new', app.newCategory)
      //   .then(function(res) {
      //     alert('Tạo thành công !');
      //     console.log(res);
      //   })
      //   .catch(function(res) {
      //     alert('Không thành công , vui lòng thử lại !');
      //     console.log(res);
      //   });
    },
    edit(cate) {
      var app = this;
      e.preventDefault();
      axios
        .post('/admin/category-structure-grammars/' + app.user.id + '/new', cate)
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


