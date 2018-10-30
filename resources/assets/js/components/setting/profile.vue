<template>
        <div class="profile-detail uk-card-default">
     <div class="profile-info">
      <h4 class="heading mb-3">Cài đặt cá nhân</h4>
      <form class="uk-grid-small" uk-grid  id="form_edit_user">
      <div class="uk-width-1-1">
          <div class="uk-width-1-2">
          <label>Họ và tên</label>
        <input class="uk-input rounded" type="text" name="fullname" v-model="user.fullname">
      </div>
      </div>
      <div class="uk-width-1-3">
          <label>Ngày sinh</label>
        <input class="uk-input rounded" type="date" name="birthday" v-model="user.birthday">
      </div>
      <div class="uk-width-1-5">
          <label>Giới tính</label>
        <select class="uk-select rounded" name="gender"  v-model="user.gender">
          <option :selected="user.gender == 1 ? true : false" value="nam">Nam</option>
          <option :selected="user.gender == 0 ? true : false" value="nu">Nữ</option>
        </select>
      </div>

      <div class="uk-width-1-1">
          <label>Địa chỉ</label>
        <input class="uk-input rounded" type="text" name="address" v-model="user.address">
      </div>
      <div class="uk-width-1-1">
          <label>Giới thiệu bản thân/ Châm ngôn sống của tôi</label>
        <textarea class="uk-textarea rounded" rows="5" name="description" v-model="user.description"></textarea>
      </div>
      <div class="uk-width-1-1">
          <label>Học tập từ  {{user.created_at}} </label>
      </div>
      <div class="uk-width-1-1">
      <button class="uk-button uk-text-uppercase uk-button-primary px-4 mt-4 rounded font-weight-bold" @click="save">Lưu</button>
      </div>
    </form>
     
    </div>
 
  
</div>
</template>
<script>
export default {
  data: function() {
    return {
      user: {},
      profile: {},
      preview: false
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
      console.log(this.user);
      if (this.user.gender == 'nam') {
        this.user.gender = 0;
      } else {
        this.user.gender = 1;
      }
      var app = this;
      e.preventDefault();
      var f = document.getElementById('form_edit_user');
      var formData = new FormData(f);

      axios
        .post('/users/edit/' + this.user.id, this.user)
        .then(function(res) {
          console.log(res);
          alert('Update thành công !');
        })
        .catch(function(res) {
          console.log(res);
          alert('Không thành công , vui lòng thử lại !');
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