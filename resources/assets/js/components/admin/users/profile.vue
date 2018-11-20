<template>
  <div class="uk-margin-right">
    <div class="row">
      <div class="col-7">
        <h5 class="mb-3"><b>Thông tin cơ bản</b></h5>
        <div class="row mb-2">
          <div class="col-4">
            <span>Tên người dùng</span>
            </div>
          <div class="col-8">
            <span>{{user.name}} <span v-if="user.fullname">( {{user.fullname}} )</span></span>
          </div>
        </div>
         <div class="row mb-2">
          <div class="col-4">
            <span>Số điện thoại</span>
            </div>
          <div class="col-8">
            <span>{{user.phone}}</span>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-4">
            <span>Email</span>
            </div>
          <div class="col-8">
            <span>{{user.email}}</span>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-4">
            <span>Ngày sinh</span>
            </div>
          <div class="col-8">
            <span>{{user.birthday}}</span>
          </div>
        </div>
         <div class="row mb-2">
          <div class="col-4">
            <span>Giới tính</span>
            </div>
          <div class="col-8">
            <span>{{user.gender == 1 ? 'Nam' : 'Nữ'}}</span>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-4">
            <span>Địa chỉ</span>
            </div>
          <div class="col-8">
            <span>{{user.address}}</span>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-4">
            <span>Thông tin khác</span>
            </div>
          <div class="col-8">
            <span>{{user.description}}</span>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-4">
            <span>Tham gia từ</span>
            </div>
          <div class="col-8">
            <span>{{user.created_at}}</span>
          </div>
        </div>
        <hr/>
      </div>
      <div class="col-5 text-center">
        <div class="avatar mx-auto">
            <a  :href="user.avatar">
              <img :src="user.avatar" id="avatar-show" />
            </a>

        </div>
          <label class="btn btn-primary rounded  avatar-change" for="file">Thay đổi avatar</label>
          <input type="file" id="file" name="avatar" style="display: none" @change="preview_image">
      </div>
    </div>
    
    <div class="row">
      <div class="col-12">
        <h5 class="mb-3"><b>Hoạt động</b></h5>
        <div class="row">
          <div class="col-7">
            <div class="row">
              <div class="col-4 text-center">
              <p>Số từ vựng</p>
<span>{{vocabularies ? vocabularies.length : '0'}}</span>
              </div>
              <div class="col-4 text-center">
                <p>Số ngữ pháp</p>
                <span>{{grammars ? grammars.length : '0' }}</span>
              </div>
              <div class="col-4 text-center">
                <p>Điểm</p>
                <span>{{user.score}}</span>
              </div>
            </div>
            <div class="row">
              <div class="col-6"><span>Lần đăng nhập cuối</span></div>
              <div class="col-6"></div>
            </div>
          </div>
          <div class="col-5">
            
          </div>
        </div>
        
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      user: [],
      grammars: [],
      newRole: '',
      preview: false,
      vocabularies: []
    };
  },
  mounted() {
    this.getUser();
    this.getGrammarUser();
    this.get_vocabularies();
  },
  methods: {
    getUser() {
      var app = this;
      axios
        .get('/api/v1/users/profile/' + Laravel.user.id)
        .then(res => {
          console.log(res.data);
          app.user = res.data;
        })
        .catch(res => {
          alert('khong load duoc');
        });
    },
    get_vocabularies() {
      var app = this;
      $.ajax({
        url: '/api/v1/users/' + app.user.id + '/vocabularies',
        method: 'get'
      })
        .done(res => {
          app.vocabularies = res;
          setTimeout(function() {
            app.success = true;
          }, 500);
        })
        .fail(res => {
          setTimeout(function() {
            app.error = true;
          }, 500);
        });
    },
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
      // console.log(user);
      if (this.users.find(u => u.id == user.id) !== undefined) {
        this.users.find(u => u.id == user.id).role = this.newRole;
      }
    },
    preview_image(e) {
      var files = e.target.files;
      if (files && files[0]) {
        var app = this;
        axios
          .post('/users/update/' + this.user.id, app.user.avatar)
          .then(function(res) {
            app.user.avatar = res.data;
          })
          .catch(function(res) {
            alert('Không thành công, vui lòng thử lại !');
          });
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.color-black {
  color: black !important;
}

.avatar {
  width: 150px;
  height: 150px;
  margin: 0px auto 30px;
  overflow: hidden;
  img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .avatar-change {
    margin: auto;
  }
}
</style>
