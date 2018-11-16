<template>
  <div class="uk-margin-right">
    <div class="row">
      <div class="col-12">
        <h4 class="text-left d-inline-block">Danh sách ngữ pháp</h4>
      <span class="float-right">
        <router-link :to="{ name: 'newStructure' }" >
                  <img src="/svg/plus.svg" title="Tạo cấu trúc mới" style="    width: 35px;"/>
                </router-link>
      </span>
      </div>
      
    </div>
    
    <div class="sosd-background-white">
      <div class="uk-overflow-auto">
        <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
          <thead>
            <tr class="">
              <th class="uk-table-shrink text-center">Id</th>
              <th class="uk-table-expand text-center">Cấu trúc</th>
              <th class="uk-table-expand text-center">Mô tả</th>
              <th class="text-center">Thuộc danh mục</th>
              <th class="uk-table-shrink uk-text-nowrap text-center">Người tạo</th>
              <th class="uk-table-expand text-center">Hành động</th>
            </tr>
          </thead>
            <paginate
              name="pusers"
              :list="grammars"
              :per="10"
              tag="tbody"
            >
              <tr v-for="g in paginated('pusers')">
                <td class="text-center">{{ g.id }}</td>
                <td class="text-center"> {{ g.structure}} </td>
                <td class="uk-text-truncate">
                  <p>{{g.description}}</p>
                </td>
                <td class="text-center">{{ g.category_id }}</td>
                <td class="uk-text-nowrap text-center">{{ users.find(e => e.id === g.user_id).email }}</td>
                <td class="text-center">
                  <span class="uk-icon-button uk-alert-success" uk-icon="pencil" :href="'#a' + g.id" uk-toggle></span>
                  <span class="uk-icon-button uk-alert-danger" uk-icon="trash" @click="del(g)"></span>
                </td>
                <div :id="'a' + g.id" class="uk-flex-top" uk-modal>
                  <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                      <button class="uk-modal-close-default" type="button" uk-close></button>
                      <div class="uk-modal-header pt-0">
                    <h5 class="">Thay đổi cấu trúc {{ g.structure}}</h5>
                     </div>
                    <div class="uk-modal-body">
                      <p>Cấu trúc ngữ pháp</p>
                      <input type="text" v-model="g.structure" class="uk-input"/>
                      <p>Danh mục</p>
                      <select v-model="g.category_id" class="uk-select my-3">
                        <option v-for="ca in listCategory" :selected="ca.name == g.category_id ? true : false" :value="ca.name" :key="ca.id">{{ca.name}}</option>
                      </select>
                      <p>Mô tả</p>
                      <textarea v-model="g.description" class="uk-textarea" rows="4" />
                    </div>
                    <div class="uk-modal-footer pb-0 text-right">
                      <button class="uk-button uk-button-primary" type="button" @click="edit(g.id)">Save</button>
                      <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                    </div>
                 
                  </div>
              </div>
              </tr>
            </paginate>
        </table>
      </div>
    </div>
        <paginate-links for="pusers" :async="true"
          :show-step-links="true"
          :step-links="{
            next: '>',
            prev: '<'
          }"
          :classes="{
            'ul' : 'uk-pagination'
          }"
        ></paginate-links>

      
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      users: [],
      grammars: [],
      listCategory: [],
      paginate: ['pusers'],
      newRole: ''
    };
  },
  mounted() {
    this.getUser();
    this.getCategory();
    this.getStructureSentences();
    console.log(this.users);
  },
  computed: {},
  methods: {
    getUser() {
      var app = this;
      axios
        .get('/api/v1/users')
        .then(res => {
          console.log(res.data);
          app.users = res.data;
        })
        .catch(res => {
          alert('khong load duoc');
        });
    },
    getStructureSentences() {
      var app = this;
      axios
        .get('/admin/structure-sentences')
        .then(function(res) {
          app.grammars = res.data;
        })
        .catch(function(res) {
          console.log(res);
        });
    },
    getCategory() {
      var app = this;
      axios
        .get('/admin/category-structure-grammars')
        .then(function(res) {
          app.listCategory = res.data;
        })
        .catch(function(res) {
          console.log(res);
        });
    },
    edit(g) {
      var app = this;
      axios
        .post('/admin/structure-sentences/update/' + g.id, g)
        .then(function(res) {})
        .catch(function(res) {
          console.log(res);
          alert('Sửa khong thanh cong, vui long thu lai');
        });
    },
    del(gram) {
      var app = this;
      axios
        .delete('/admin/structure-sentences/' + gram.id)
        .then(function(res) {
          app.grammars.splice(app.grammars.indexOf(gram), 1);
          console.log('Xóa thành công ');
        })
        .catch(function(res) {
          console.log('err' + res);
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.color-black {
  color: black !important;
}
.uk-icon-button {
  cursor: pointer;
}
.uk-alert-danger {
  color: #ff5050;
  &:hover {
    color: red;
  }
}
.uk-alert-success {
  &:hover {
    color: #01f398;
  }
}
</style>
