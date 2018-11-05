<template>
  <div class="uk-margin-right">
    <h3>Quản lý người dùng</h3>

    <div class="sosd-background-white">
      <div class="uk-overflow-auto">
        <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
          <thead>
            <tr class="">
              <th class="uk-table-shrink text-center">Id</th>
              <th class="uk-table-expand text-center">Ảnh đại diện</th>
              <th class="uk-table-expand text-center">Tên người dùng</th>
              <th class="uk-width-expand text-center">Email</th>
              <th class="uk-table-shrink uk-text-nowrap text-center">Vai trò</th>
              <th class="uk-table-shrink uk-text-nowrap text-center">Số từ vựng</th>
              <th class="uk-table-shrink uk-text-nowrap text-center">Số ngữ pháp</th>
              <th class="uk-table-shrink uk-text-nowrap text-center">Điểm</th>
              <th class="uk-table-expand text-center">Hành động</th>
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
                  <a class="uk-link-reset" href="">{{ u.name }}</a>
                </td>
                <td class="uk-text-truncate">{{ u.email }}</td>
                <td class="uk-text-nowrap text-center"><a href="#modal-role" uk-toggle>{{ u.role == 1 ? 'Admin' : 'User' }}</a></td>
                <td class="uk-text-nowrap text-center">{{ u.score }}</td>
                <td class="uk-text-nowrap text-center">{{ grammars.length }}</td>
                <td class="uk-text-nowrap text-center">{{ u.score }}</td>
                <td class="text-center">
                  <span class="uk-icon-button color-black" uk-icon="pencil"></span>
                  <span class="uk-icon-button color-black" uk-icon="trash"></span>
                </td>
                  <!-- model change role -->
        <div id="modal-role" class="uk-flex-top" uk-modal>
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-modal-header pt-0 ">
                    <h4 class="">Đổi vai trò {{ u.name }}</h4>
                </div>  
                <div class="uk-modal-body">
                  <div uk-grid>
                      <div class="uk-width-1-2">
                        <input :checked="u.role == 1 ? true : false" v-model="role" class="uk-radio mr-3" type="radio" id="radioRoleA" name='role'>
                        <label for="radioRoleA">Admin</label>
                      </div>
                      <div class="uk-width-1-2">
                        <input :checked="u.role == 0 ? true : false" v-model="role" class="uk-radio mr-3" type="radio" id="radioRoleU" name='role'>
                        <label for="radioRoleU">User</label>
                      </div>
                  </div>
                    
                </div>
                <div class="uk-modal-footer uk-text-right pb-0">
                    <button class="uk-button uk-button-primary" type="button">Lưu</button>
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

      
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      users: [],
      grammars: [],
      paginate: ['pusers']
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
    }
  }
};
</script>

<style lang="scss" scoped>
.color-black {
  color: black !important;
}
</style>
