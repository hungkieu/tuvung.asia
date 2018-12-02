<template>
     <div class="uk-margin-right">
      <div class="row justify-content-between title mx-0">
        <div class="col-auto">
           <h4>Danh mục ngữ pháp</h4>
        </div>
       <div class="col-auto pr-5 py-2">
        <a class="" href="#modal-category" uk-toggle><img src="/svg/plus.svg" title="Tạo danh mục mới" style="width: 35px;"/></a>
        </div>
      </div>
        <div class="sosd-background-white">
      <div class="uk-overflow-auto">
        <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
          <thead>
            <tr class="">
              <th class="uk-table-shrink text-center color-black">Id</th>
              <th class="uk-table-expand text-center color-black">Danh mục</th>
              <th class="uk-table-expand text-center color-black">Thuộc danh mục</th>
              <th class="uk-table-expand text-center color-black">Mô tả</th>
              <th class="uk-table-shrink uk-text-nowrap text-center color-black">Người tạo</th>
              <th class="uk-table-expand text-center color-black">Hành động</th>
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
                <td class="uk-text-truncate text-center">{{ g.parent_id ? listCategory.find(e => e.id == g.parent_id).name : 'None' }}</td>
                <td class="text-left">
                  <span class="des-3">{{g.description}}</span></td>
                <td class="uk-text-nowrap text-center">{{ users.length > 0 ? users.find(e => e.id === g.user_id).email : ''}}</td>
                <td class="text-center">
                  <span class="uk-icon-button uk-alert-success" uk-icon="pencil" :href="'#b' + g.id" uk-toggle></span>
                  <span class="uk-icon-button uk-alert-danger" uk-icon="trash" @click="del(g)"></span>
                </td>
                <div :id="'b' + g.id" class="uk-flex-top" uk-modal>
                  <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical ">
                      <button class="uk-modal-close-default" type="button" uk-close></button>
                      <div class="uk-modal-header pt-0">
                    <h4 class="">Thay đổi danh mục {{ g.name}}</h4>
                     </div>
                    <div class="uk-modal-body py-3">
                      <p class="mb-1">Tên danh mục <span class="uk-text-danger">*</span></p>
                <input type="text" v-model="g.name" class="uk-input w-100"/>
                <p class="mt-3 mb-0">Thuộc danh mục
                <small class="d-inline-block">
                <i>Nếu danh mục bạn tạo thuộc danh mục nào đó đó đã tồn tại hãy chọn danh mục đó nếu không chọn "NONE"</i>
                </small>
                <select class="uk-select mt-2" v-model="g.parent_id">
                    <option value="">None</option>
                    <option v-for="ca in listCategory" :value="ca.id" v-if="ca.parent_id == null  && g.id != ca.id">{{ca.name}}</option>
                </select>
                <p class="mb-1 mt-3">Mô tả</p>
                <textarea  v-model="g.description" class="uk-textarea w-100" rows="4"/>
                    </div>
                    <div class="uk-modal-footer pb-0 text-right">
                      <button class="uk-button uk-button-primary" type="button" @click="edit(g)">Save</button>
                      <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                    </div>
                 
                  </div>
              </div>
              </tr>
            </paginate>
        </table>
      </div>
    </div>
       <!-- Thêm danh mục -->
<div id="modal-category" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

        <button class="uk-modal-close-default" type="button" uk-close></button>

          <div class="uk-modal-header pt-0">
            <h4 class="">Thêm danh mục ngữ pháp</h4>
          </div>
          <div class="uk-modal-body py-3">
            <p class="mb-1">Tên danh mục <span class="uk-text-danger">*</span></p>
                  <input type="text" v-model="newCategory.name" class="uk-input w-100"/>
                  <p class="mt-3 mb-0">Thuộc danh mục
                  <small class="d-inline-block">
                  <i>Nếu danh mục bạn tạo thuộc danh mục nào đó đó đã tồn tại hãy chọn danh mục đó nếu không chọn "NONE"</i>
                  </small>
                  <select class="uk-select mt-2" v-model="newCategory.parent_id">
                      <option value="">None</option>
                      <option v-for="ca in listCategory" :value="ca.id" v-if="ca.parent_id == null">{{ca.name}}</option>
                  </select>
                  <p class="mb-1 mt-3">Mô tả</p>
                  <textarea  v-model="newCategory.description" class="uk-textarea w-100" rows="4"/>
              <div class="uk-modal-footer pb-0 text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                  <button class="uk-button uk-button-primary" type="button" @click="save">Save</button>
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
      users: [],
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
    this.getUser();
  },
  methods: {
    getUser() {
      var app = this;
      axios
        .get('/api/v1/users')
        .then(res => {
          app.users = res.data;
        })
        .catch(res => {
          flash("Không load được dữ liệu", "error");
        });
    },
    getCategory() {
      var app = this;
      axios
        .get('/admin/category-structure-grammars/index')
        .then(function(res) {
          // console.log(res);
          app.listCategory = res.data;
        })
        .catch(function(res) {
          console.log(res);
        });
    },
    sortedArr(arr, key, type) {
      if (type == 'asc') {
        return arr.sort((a, b) => a[key] - b[key]);
      }
      return arr.sort((a, b) => b[key] - a[key]);
    },
    save(e) {
      var app = this;
      if (app.newCategory.name != '') {
        axios
          .post('/admin/category-structure-grammars/' + app.users.id + '/new', app.newCategory)
          .then(function(res) {
            UIkit.modal('#modal-category').hide();
            flash('Tạo thành công !', 'success');
            app.listCategory.push({ ...res.data });
            app.newCategory = {
              name: '',
              description: '',
              parent_id: '',
              pedigree: ''
            };
          })
          .catch(function(res) {
            flash('Không thành công , vui lòng thử lại !', 'error');
          });
      } else {
        alert('Bạn phải nhập tên danh mục !');
      }
    },
    edit(cate) {
      console.log(cate);
      var app = this;
      if (cate.name != '') {
        axios
          .post('/admin/category-structure-grammars/' + cate.id + '/edit', cate)
          .then(function(res) {
            alert('Sửa thành công !');
            UIkit.modal('#b' + cate.id).hide();
          })
          .catch(function(res) {
            alert('Không thành công , vui lòng thử lại !');
            console.log(res);
          });
      } else {
        alert('Bạn phải nhập tên danh mục !');
      }
    },
    del(cate) {
      var app = this;
      axios
        .delete('/admin/category-structure-grammars/' + cate.id)
        .then(function(res) {
          app.listCategory.splice(app.listCategory.indexOf(cate), 1);
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
.color-black {
  color: black !important;
  font-weight: 500;
}
.des-3 {
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
}
</style>


