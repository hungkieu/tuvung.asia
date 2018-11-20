<template>
  <div class="uk-margin-right">
      <div class="row justify-content-between title mx-0">
        <div class="col-auto">
          <h4>Quản lý người dùng</h4>
        </div>
       <div class="col-auto pr-5 py-2">
        <a class="" href="#modal-user" uk-toggle><img src="/svg/plus.svg" title="Tạo danh mục mới" style="width: 35px;"/></a>
        </div>
      </div>
    <div class="sosd-background-white">
      <div class="uk-overflow-auto">
        <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
          <thead>
            <tr class="">
              <th class="uk-table-shrink text-center color-black">Id</th>
              <th class="uk-table-expand text-center color-black">Ảnh đại diện</th>
              <th class="uk-table-expand text-center color-black">Tên người dùng</th>
              <th class="uk-width-expand text-center color-black">Email</th>
              <th class="uk-table-shrink uk-text-nowrap text-center color-black">Vai trò</th>
              <th class="uk-table-shrink uk-text-nowrap text-center color-black">Số từ vựng</th>
              <th class="uk-table-shrink uk-text-nowrap text-center color-black">Số ngữ pháp</th>
              <th class="uk-table-shrink uk-text-nowrap text-center color-black">Điểm</th>
              <th class="uk-table-shrink uk-text-nowrap text-center color-black">Tạo tài khoản</th>
              <th class="uk-table-expand text-center color-black">Hành động</th>
            </tr>
          </thead>
            <paginate
              name="pusers"
              :list="users"
              :per="10"
              tag="tbody"
            >
              <tr v-for="u in paginated('pusers')">
                <td class="text-center">{{ u.id }}</td>
                <td class="text-center">
                  <img class="uk-preserve-width uk-border-circle" :src="u.avatar" style="width: 50px; height: 50px; object-fit: cover;" alt="">
                </td>
                <td class="uk-table-link text-center">
                  <!-- <router-link :to="{ name: action, params: {id: u.id }}" >{{ u.name }}</router-link> -->
                  <a class="uk-link-reset" href="">{{ u.name }}</a>
                </td>
                <td class="uk-text-truncate" :title="u.email">{{ u.email }}</td>
                <td class="uk-text-nowrap text-center"><a href="#modal-role" uk-toggle style="color: #32d296">{{ u.role == 1 ? 'Admin' : 'User' }}</a></td>
                <td class="uk-text-nowrap text-center">{{ u.score }}</td>
                <td class="uk-text-nowrap text-center">{{ grammars.length }}</td>
                <td class="uk-text-nowrap text-center">{{ u.score }}</td>
                <td class="uk-text-nowrap text-center">{{ u.created_at }}</td>
                <td class="text-center">
                  <router-link :to="'/admin/users/profile/' + u.id">
                  <span class="uk-icon-button uk-alert-success" title="Xem hồ sơ"> <i class="fa fa-eye" aria-hidden="true"></i></span>
                  </router-link>
                  <span v-if="nowUser.id != u.id" class="uk-icon-button uk-alert-danger" uk-icon="trash" title="Xóa người dùng này" @click="del(u)"></span>
                </td>
                  <!-- model change role -->
        <div id="modal-role" class="uk-flex-top" uk-modal>
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-modal-header pt-0 ">
                    <h5 class="">Đổi vai trò {{ u.name }}</h5>
                </div>  
                <div class="uk-modal-body">
                  <div uk-grid>
                      <div class="uk-width-1-2">
                        <input :checked="u.role == 1 ? true : false" @click="changeRole(1)" class="uk-radio mr-3" type="radio" id="radioRoleA" name='role'>
                        <label for="radioRoleA">Admin</label>
                      </div>
                      <div class="uk-width-1-2">
                        <input :checked="u.role == 0 ? true : false" @click="changeRole(0)" class="uk-radio mr-3" type="radio" id="radioRoleU" name='role'>
                        <label for="radioRoleU">User</label>
                      </div>
                  </div>
                    
                </div>
                <div class="uk-modal-footer uk-text-right pb-0">
                    <button class="uk-button uk-button-primary uk-modal-close" type="button" @click="saveRole(u)" >Lưu</button>
                    <button class="uk-button uk-button-default uk-modal-close" type="button">Hủy</button>
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

      

      <!-- Thêm người dùng -->
      <div id="modal-user" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

        <button class="uk-modal-close-default" type="button" uk-close></button>

          <div class="uk-modal-header pt-0">
            <h4 class="">Thêm người dùng</h4>
          </div>
          <div class="uk-modal-body py-3">
            <div class="row">
              <div class="col-md-12 col-12">
                   <p class="mb-1">Tên người dùng <span class="uk-text-danger">*</span></p>
                    <input type="text" v-model="newUser.name" class="uk-input w-100"/>
                     <p class="mb-1 mt-3">Email <span class="uk-text-danger">*</span></p>
            <input type="text" v-model="newUser.email" class="uk-input w-100"/>
              </div>
              <div class="col-md-12 col-12">
                  <p class="mb-1 mt-3">Số điện thoại</p>
            <input type="text" v-model="newUser.phone" class="uk-input w-100"/>
              </div>
              <div class="col-md-12 col-12">
                <p class="mb-1 mt-3">Vai trò</p>
           <select class="uk-select rounded" name="gender"  v-model="newUser.role">
                        <option :selected="newUser.role == 1 ? true : false" value="1">Quản trị viên</option>
                        <option :selected="newUser.role == 0 ? true : false" value="0">Người dùng thường</option>
                      </select>
              </div>
            </div>
            </div>
              <div class="uk-modal-footer pb-0 text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                  <button class="uk-button uk-button-primary" type="button" @click="save">Save</button>
              </div>
          
        </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      users: [],
      grammars: [],
      paginate: ['pusers'],
      newRole: '',
      newUser: {},
      nowUser: Laravel.user
    };
  },
  mounted() {
    var app = this;
    this.getGrammarUser();
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
  methods: {
    getGrammarUser() {
      this.user = Laravel.user;
      var app = this;
      axios
        .get('/grammars/' + app.user.id)
        .then(function(res) {
          app.grammars = res.data;
        })
        .catch(function(res) {
          console.log('err');
        });
    },
    changeRole(role) {
      if (role == 1) {
        this.newRole = 1;
      } else {
        this.newRole = 0;
      }
    },
    saveRole(user) {
      const app = this;
      if (this.users.find(u => u.id == user.id) !== undefined) {
        this.users.find(u => u.id == user.id).role = this.newRole;
      }
      axios
        .post('/users/update/' + app.user.id, user)
        .then(function(res) {
          console.log(res);
        })
        .catch(function(res) {
          alert('Không thành công , vui lòng thử lại !');
        });
    },
    save(e) {
      const app = this;
      axios
        .post('/v1/users/create', app.newUser)
        .then(res => {
          console.log(res.data);
          UIkit.modal('#modal-user').hide();
          app.users.push({ ...res.data });
        })
        .catch(res => {
          alert('khong load duoc');
        });
    },
    del(u) {
      const app = this;
      axios
        .delete('/v1/users/' + u.id)
        .then(res => {
          console.log(res.data);
          app.users.splice(app.users.indexOf(u), 1);
        })
        .catch(res => {
          alert('khong load duoc');
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.color-black {
  color: black !important;
  font-weight: 500;
}

a {
  color: black;
  text-decoration: none;
  &:hover {
    text-decoration: none;
  }
}
</style>
