<template>
    <div class="profile-detail uk-card-default">
     <div class="profile-info">
      <h4 class="heading mb-3">Tài khoản</h4>

      <form class="uk-grid-small" uk-grid  id="form_edit_user">
      <div class="uk-width-1-1">
          <div class="uk-width-1-2">
          <label>Tên người dùng</label>
        <input class="uk-input rounded" type="text" name="name" v-model="user.name">
      </div>
      </div>
      <div class="uk-width-1-1">
            <div class="uk-width-1-2">
        <label>Email</label>
        <input class="uk-input rounded" type="text" name="email" v-model="user.email">
      </div>
      </div>
       <div class="uk-width-1-1">
      <div class="uk-width-1-2">
          <label for="">Số điện thoại</label>
        <input class="uk-input rounded" type="text" name="phone" v-model="user.phone">
      </div>
      </div>
            
      <div class="uk-width-1-2">
          <label>Mật khẩu mới</label>
        <div class="uk-inline w-100">
            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
            <input class="uk-input rounded" type="text"
            >
        </div>
      </div>
      <div class="uk-width-1-2">
                <label>Mật khẩu cũ</label>
         <div class="uk-inline w-100">
            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
            <input class="uk-input rounded" type="text">
        </div>
      </div>
      <div class="uk-width-1-2">
          <label>Xác nhận mật khẩu mới</label>
        <div class="uk-inline w-100 ">
            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
            <input class="uk-input rounded" type="text">
        </div>
      <div class="uk-width-1-1">
      <button class="uk-button uk-text-uppercase uk-button-primary px-4 mt-4 rounded font-weight-bold" @click="save">Lưu</button>
      </div>
      </div>
    </form>
    </div>    
</div>
</template>
<script>
export default {
  data: function() {
    return {
      user: {}
    };
  },
  mounted() {
    this.user = Laravel.user;
    var id = this.user.id;
    var app = this;
    console.log(this.user);
    axios
      .get('/users/' + id)
      .then(function(res) {
        console.log(res.data);
        app.user = res.data;
      })
      .catch(res => {
        alert('khong load duoc');
      });
  },
  methods: {
    formatDate(date) {
      return moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY');
    },
    save(e) {
      var app = this;
      e.preventDefault();
      var f = document.getElementById('form_edit_user');
      var formData = new FormData(f);
      axios
        .post('/users/edit/' + this.user.id, this.user)
        .then(function(res) {
          alert('Update thành công !');
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
$color-main: #1f8bf0;
.profile-detail {
  padding: 30px 50px 50px;
  color: #252b2f;
  input:valid {
    color: black;
  }
}
</style>
