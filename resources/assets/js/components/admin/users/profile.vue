<template>
  <div class="uk-margin-right">
    <div class="row mx-0">
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
            <span>Vai trò</span>
            </div>
          <div class="col-8">
            <span>{{user.role == 1 ? 'Quản trị viên' : 'Người dùng thường'}}</span>
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
        <div class="row">
          <div class="col-12 text-right">
            <button class="btn btn-primary rounded avatar-change" href="#modal-edit-user" uk-toggle> Sửa thông tin</button>
          </div>
        </div>
        <hr/>
      </div>
      <div class="col-5 text-center">
        <div class="avatar mx-auto">
            <a  :href="user.avatar" target="_blank">
              <img :src="user.avatar" id="avatar-show" />
            </a>

        </div>
          <label class="btn btn-primary rounded avatar-change" for="file">Thay đổi avatar</label>
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

         <!-- Sửa người dùng -->
  <div id="modal-edit-user" class="uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
          <div class="uk-modal-header pt-0">
            <h4 class="">Sửa thông tin</h4>
          </div>
          <div class="uk-modal-body py-3 fontSize-15">
            <div class="row">
              <div class="col-md-6 col-12">
                   <p class="mb-1">Tên người dùng <span class="uk-text-danger">*</span></p>
                    <input type="text" v-model="user.name" class="uk-input w-100 rounded"/>
                    <p class="mb-1 mt-3">Email<span class="uk-text-danger">*</span></p>
                    <input type="text" v-model="user.email" class="uk-input w-100"/>
                     <p class="mb-1 mt-3">Số điện thoại <span class="uk-text-danger">*</span></p>
            <input type="text" v-model="user.phone" class="uk-input w-100 rounded"/>
              </div>
              <div class="col-md-6 col-12">
                <p class="mb-1">Tên đầy đủ ( Tên khác )</p>
            <input type="text" v-model="user.fullname" class="uk-input w-100 rounded"/>
                  <div class="row">
                    <div class="col-8">
                        <p class="mb-1 mt-3">Ngày sinh</p>
                        <input type="date" v-model="user.birthday" class="uk-input w-100 rounded"/>
                    </div>
                    <div class="col-4">
                        <p class="mb-1 mt-3">Giới tính</p>
                        <select class="uk-select rounded" name="gender"  v-model="user.gender">
                        <option :selected="user.gender == 1 ? true : false" value="nam">Nam</option>
                        <option :selected="user.gender == 0 ? true : false" value="nu">Nữ</option>
                      </select>
                    </div>
                  </div>
              </div>
            </div>
             <p class="mb-1 mt-3">Địa chỉ</p>
            <input type="text" v-model="user.address" class="uk-input w-100 rounded"/>
            <p class="mb-1 mt-3">Thông tin khác</p>
            <input type="text" v-model="user.description" class="uk-input w-100 rounded"/>
          </div>
              <div class="uk-modal-footer pb-0 text-right ontSize-15">
                  <button class="uk-button uk-button-primary" type="button" @click="save">Save</button>
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
      user: [],
      grammars: [],
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
        .get('/api/v1/users/profile/' + app.$route.params.id)
        .then(res => {
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
    preview_image(e) {
      var files = e.target.files;
      if (files && files[0]) {
        var f = new FormData();
        f.append('avatar', files[0]);
        var app = this;
        axios
          .post('/users/update/' + this.user.id, f, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
          .then(function(res) {
            app.user.avatar = res.data;
          })
          .catch(function(res) {
            alert('Không thành công, vui lòng thử lại !');
          });
      }
    },
    save() {
      const app = this;
      if (this.user.gender == 'nam') {
        this.user.gender = 1;
      } else {
        this.user.gender = 0;
      }
      axios
        .post('/users/update/' + app.user.id, app.user)
        .then(function(res) {
          UIkit.modal('#modal-edit-user').hide();
          flash('Update thành công !', 'success');
        })
        .catch(function(res) {
          flash('Không thành công , vui lòng thử lại !', 'error');
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.color-black {
  color: black !important;
}

.avatar {
  border-radius: 5px;
  overflow: hidden;
  width: 200px;
  height: 200px;
  margin: 20px auto 30px;

  img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .avatar-change {
    margin: auto;
  }
}
.fontSize-15 {
  font-size: 15px;
}
</style>
