<template>
       <div class="profile-avatar uk-card-default text-center">
           <h4 class="text-left mb-3">Ảnh đại diện</h4>
         <div class="avatar mx-auto">
            <a  :href="user.avatar">
              <img :src="user.avatar" id="avatar-show" />
            </a>
          </div>
          <label class="btn btn-primary rounded  avatar-change" for="file">Thay đổi avatar</label>
          <input type="file" id="file" name="avatar" style="display: none" @change="preview_image">
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
    preview_image(e) {
      var files = e.target.files;
      if (files && files[0]) {
        var f = new FormData();
        f.append('avatar', files[0]);
        var app = this;
        axios
          .post('/users/edit/' + this.user.id, f, {
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
    }
  }
};
</script>
<style lang="scss" scoped>
$color-main: #1f8bf0;
.profile-avatar {
  padding: 30px 50px 50px;
  color: #252b2f;
  input:valid {
    color: black;
  }
  .avatar {
    width: 13.75rem;
    height: 13.75rem;
    margin: 0px auto 30px;
    border-radius: 100%;
    overflow: hidden;
    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }
  .avatar-change {
  }
}
</style>