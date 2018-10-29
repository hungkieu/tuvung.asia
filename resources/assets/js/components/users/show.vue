<template>

 <div class="user sosd-background-white sosd-box-shadow">
    <div class="clearfix">
<!-- RIGHT COLUMN -->
<div class="profile-right">
  <h4 class="heading">Mức độ thành thạo</h4>
  <!-- AWARDS -->
  <div class="awards">
   <div class="row">
    <div class="col-md-3 col-sm-6">
     <div class="award-item w-100">
      <div class="uk-animation-toggle">
        <div class="uk-card uk-card-default rounded-circle p-3 mb-3 uk-animation-shake uk-alert-success mx-auto">
          <p class="uk-text-center">12</p>
        </div>
      </div>
      <span>Ngữ pháp </span>
    </div>
  </div>
  <div class="col-md-3 col-sm-6">
   <div class="award-item w-100">
    <div class="uk-animation-toggle">
      <div class="uk-card uk-card-default rounded-circle p-3 mb-3 uk-animation-shake uk-alert-success mx-auto">
        <p class="uk-text-center">12</p>
      </div>
    </div>
    <span>Từ vựng</span>
  </div>
</div>
<div class="col-md-3 col-sm-6">
 <div class="award-item w-100">
   <div class="uk-animation-toggle">
    <div class="uk-card uk-card-default rounded-circle p-3 mb-3 uk-animation-shake uk-alert-success mx-auto">
      <p class="uk-text-center">12</p>
    </div>
  </div>
  <span>Problem Solver</span>
</div>
</div>
</div>
</div>
<hr/>
<!-- END AWARDS -->
<!-- TABBED CONTENT -->
<div class="custom-tabs-line tabs-line-bottom left-aligned">

  <ul class="uk-subnav uk-subnav-pill mb-0" uk-switcher="animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium">
    <li><a href="#">Luyện tập </a></li>
    <li><a href="#">Thành tích </a></li>

  </ul>

  <div class="uk-switcher uk-margin">
    <div class="tab">
      <div class="uk-width-1-1  mb-2 d-inline-block" >
        <div class="uk-width-1-4 float-left">
          <h6 class="py-2">Ngôn ngữ</h6>
        </div>
        <div class="uk-width-1-2 float-left">
          <select class="uk-select  uk-form-small">
            <option>Tiếng Anh</option>
          </select>
        </div>
      </div>
      <div class="uk-width-1-1 mb-2 d-inline-block " >
        <div class="uk-width-1-4 float-left">
          <h6 class="">Thông báo </h6>
        </div>
        <div class="uk-width-1-2 float-left">
          <div v-for="item in message" :key="item.key">
            <label class="d-block">
              <input class="uk-checkbox" type="checkbox" name="item.key" id="item.key"
              :checked="item.status ? true : false"  @change="item.status = !item.status">
              <span for="item.key">{{item.name}}</span>
            </label>
          </div>
        </div>
      </div>
      <br/>
      <div class="uk-width-1-1 mb-2 d-inline-block ">
        <h6 class="py-2">Thời gian học tập</h6>
        <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
          <span v-for="item in week" :key="item.key">
            <input class="uk-checkbox" type="checkbox"
            :checked="item.status ? true : false" value="item.key"   @change="item.status = !item.status" > {{item.name}}
          </span>
        </div>
        <p class="w-100">Vào lúc <input type="time" class="uk-input  uk-form-small w-25 mx-2  "  v-model="time"/> hằng ngày</p>

      </div>
    </div>
    <div  class="tab">
      <p>Tuần này: Bạn đã học được 2 ngày ! </p>
    </div>
  </div>
</div>

<!-- END TABBED CONTENT -->
</div>
<!-- END RIGHT COLUMN -->
</div>

</div>

</template>

<script>
export default {
  data: function() {
    return {
      user: {},
      profile: {},
      week: [
        {
          id: 'monday',
          name: 'Thứ 2',
          status: true
        },
        {
          id: 'tuesday',
          name: 'Thứ 3',
          status: false
        },
        {
          id: 'wednesday',
          name: 'Thứ 4',
          status: false
        },
        {
          id: 'thursday',
          name: 'Thứ 5',
          status: false
        },
        {
          id: 'friday	',
          name: 'Thứ 6',
          status: false
        },
        {
          id: 'saturday',
          name: 'Thứ 7',
          status: false
        },
        {
          id: 'sunday',
          name: 'Chủ nhật ',
          status: false
        }
      ],
      message: [
        {
          name: 'Nhận mail',
          key: 'mes-email',
          status: false
        },
        {
          name: 'Gửi tin nhắn điện thoại',
          key: 'mes-phone',
          status: false
        },
        {
          name: 'Thông báo trình duyệt',
          key: 'mes-browser',
          status: true
        }
      ],
      time: '21:00',
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
      var app = this;
      e.preventDefault();
      var f = document.getElementById('form_edit_user');
      var formData = new FormData(f);
      axios
        .post('/users/edit/' + this.user.id, formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(function(res) {
          alert('Sửa thành công !');
          UIkit.modal('#modal-info').hide();
          f.reset();
        })
        .catch(function(res) {
          alert('Không thành công , vui long thử lại !');
        });
    },
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
            alert('Sửa khong thanh cong, vui long thu lai');
          });
      }
    }
  }
};
</script>

<style lang="scss" scoped>
$lightseagreen: lightseagreen;
.color {
  color: $lightseagreen;
}

.user {
  padding: 30px 50px 50px;
}

.navbar + .user {
  padding: 105px 0 28px 5px;
}
@media screen and (max-width: 767px) {
  .navbar + .user {
    padding-top: 155px;
  }
}
.fancy-checkbox {
  display: block;
  font-weight: normal;
}
.fancy-checkbox input[type='checkbox'] {
  display: none;
}
.fancy-checkbox input[type='checkbox'] + span {
  display: inline-block;
  vertical-align: middle;
  *vertical-align: auto;
  *zoom: 1;
  *display: inline;
  cursor: pointer;
  position: relative;
  font-size: 13px;
}
.fancy-checkbox input[type='checkbox'] + span:before {
  display: inline-block;
  vertical-align: middle;
  *vertical-align: auto;
  *zoom: 1;
  *display: inline;
  position: relative;
  bottom: 1px;
  width: 18px;
  height: 18px;
  margin-right: 5px;
  content: '';
  border: 1px solid #ccc;
}
.fancy-checkbox input[type='checkbox']:checked + span:before {
  font-family: FontAwesome;
  content: '\f00c';
  font-size: 12px;
  color: #99a1a7;
  text-align: center;
  line-height: 16px;
  background: #ededed;
  border: 1px solid #ccc;
}
.fancy-checkbox.custom-color-green input[type='checkbox']:checked + span:before {
  color: #53d76a;
  background-color: #fff;
}
.fancy-checkbox.custom-bgcolor-green input[type='checkbox']:checked + span:before {
  color: #fff;
  background-color: #53d76a;
  border-color: #32cf4d;
}
.btn {
  -webkit-border-radius: 2px;
  -moz-border-radius: 2px;
  border-radius: 2px;
  -moz-box-shadow: 0px 1px 2px 0 rgba(0, 0, 0, 0.2);
  -webkit-box-shadow: 0px 1px 2px 0 rgba(0, 0, 0, 0.2);
  box-shadow: 0px 1px 2px 0 rgba(0, 0, 0, 0.2);
  padding: 6px 22px;
}

.btn-group-lg > .btn,
.btn-lg {
  padding: 10px 28px;
}

.btn-group-sm > .btn,
.btn-sm {
  padding: 5px 18px;
}

.btn-group-xs > .btn,
.btn-xs {
  padding: 5px 14px;
}

.btn-primary {
  background-color: #00aaff;
  border-color: #00a0f0;
}
.btn-primary:hover,
.btn-primary:focus {
  background-color: #00a0f0;
  border-color: #00a0f0;
}

.btn-warning {
  background-color: #e4cb10;
  border-color: #d6be0f;
}
.btn-warning:hover,
.btn-warning:focus {
  background-color: #d6be0f;
  border-color: #d6be0f;
}

.btn-default:hover,
.btn-default:focus {
  background-color: #f7f7f7;
}

.btn-success {
  background-color: #41b314;
  border-color: #3ca512;
}
.btn-success:hover,
.btn-success:focus {
  background-color: #3ca512;
  border-color: #3ca512;
}

/* tabs */
.custom-tabs-line ul {
  display: inline-block;
  vertical-align: middle;
  *vertical-align: auto;
  *zoom: 1;
  *display: inline;
}
.custom-tabs-line ul > li {
  float: left;
}
.custom-tabs-line ul > li a {
  color: #8d9093;
  font-weight: normal;
}
.custom-tabs-line ul > li a:hover,
.custom-tabs-line ul > li a:focus {
  color: #676a6d;
  background-color: transparent;
}
.custom-tabs-line ul > li a:focus {
  outline: none;
}
.custom-tabs-line ul.nav-pills a:hover,
.custom-tabs-line ul.nav-pills a:focus {
  color: #fff;
  background-color: #00aaff;
}

.custom-tabs-line.tabs-line-bottom {
  border-bottom: 1px solid #eaeaea;
}
.custom-tabs-line.tabs-line-bottom ul > li {
  margin-bottom: -1px;
}
.custom-tabs-line.tabs-line-bottom a {
  border-bottom: 1px solid transparent;
}
.custom-tabs-line.tabs-line-bottom .active a {
  border-bottom: 2px solid #00aaff;
}

.custom-tabs-line.left-aligned {
  text-align: left;
}

.custom-tabs-line.right-aligned {
  text-align: right;
}

@media screen and (max-width: 768px) {
  .custom-tabs-line ul li.active > a {
    margin-bottom: -1px;
  }
}

.tab-pane {
  padding: 25px 15px;
}

/********************
* PAGE: PROFILE
********************/
.panel-profile {
  position: relative;
}

.profile-left {
  float: left;
  width: 30%;
  height: 100%;
  background-color: #fff;
}

.profile-right {
  .heading {
    margin-top: 0;
  }
}

@media screen and (max-width: 992px) {
  .profile-left,
  .profile-right {
    float: none;
    width: 100%;
  }
  .profile-left {
    position: relative;
    margin-bottom: 30px;
  }
}

.profile-header {
  position: relative;
  text-align: center;
}

.profile-header .profile-main {
  position: relative;
  padding: 30px;
  background-repeat: no-repeat;
  background-size: cover;
  .avatar {
    position: relative;
    .avatar-change {
      position: absolute;
      display: none;
      bottom: 0;
      right: 0;
      background: rgba(0, 0, 0, 0.25);
      width: 100%;
      height: 30px;
      line-height: 30px;
    }
    &:hover {
      .avatar-change {
        display: block;
      }
    }
  }
}
.profile-header .name {
  margin: 25px 0 15px;
  font-size: 22px;
}
.profile-header .online-status {
  font-size: 13px;
  position: relative;
  top: -2px;
}
.profile-header .online-status:before {
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  border-radius: 50%;
  display: inline-block;
  vertical-align: middle;
  *vertical-align: auto;
  *zoom: 1;
  *display: inline;
  content: '';
  width: 8px;
  height: 8px;
  margin-right: 3px;
}
.profile-header .online-status.status-available:before {
  background-color: #41b314;
}
.profile-header .profile-stat {
  position: relative;
  background-color: #00aaff;
}
.profile-header .profile-stat .stat-item {
  padding: 20px;
  position: relative;
}
.profile-header .profile-stat .stat-item:after {
  content: '';
  display: block;
  position: absolute;
  top: 0;
  right: 0;
  width: 1px;
  height: 100%;
  background-color: #33bbff;
}
.profile-header .profile-stat .stat-item:last-child:after {
  display: none;
}
.profile-header .profile-stat .stat-item span {
  display: block;
}
@media screen and (max-width: 1023px) {
  .profile-header .profile-stat .stat-item:after {
    display: none;
  }
}

.profile-detail {
  padding-bottom: 50px;
  a {
    color: #fff;
    &:hover {
      color: #fff;
      text-decoration: none;
    }
  }
}

.profile-info {
  padding: 0 20px;
  margin: 0 0 30px;
}
.profile-info .heading {
  margin: 0 0 15px 0;
  font-weight: 600;
  font-size: 20px;
}
.profile-info ul > li {
  margin-bottom: 8px;
}
.profile-right .heading {
  padding-bottom: 10px;
  margin-bottom: 20px;
  border-bottom: 1px solid #eaeaea;
}

.award-item {
  display: inline-block;
  vertical-align: middle;
  *vertical-align: auto;
  *zoom: 1;
  *display: inline;
  text-align: center;
  margin-bottom: 30px;
  .uk-card {
    width: 100px;
    height: 100px;
    line-height: 65px;
    font-weight: bold;
    font-size: 25px;
  }
}

ul.activity-timeline > li {
  margin-bottom: 45px;
  position: relative;
  z-index: 0;
}
ul.activity-timeline > li .activity-icon {
  display: inline-block;
  vertical-align: middle;
  *vertical-align: auto;
  *zoom: 1;
  *display: inline;
  -webkit-border-radius: 30px;
  -moz-border-radius: 30px;
  border-radius: 30px;
  float: left;
  width: 34px;
  height: 34px;
  background-color: #00aaff;
  font-size: 16px;
  color: #fff;
  line-height: 34px;
  text-align: center;
  margin-right: 10px;
}
ul.activity-timeline > li > p {
  margin-bottom: 0;
  padding-left: 40px;
}
ul.activity-timeline > li .timestamp {
  display: block;
  font-size: 0.85em;
  color: #a3a3a3;
}
ul.activity-timeline > li:after {
  content: '';
  display: block;
  border-left: 1px solid #eaeaea;
  width: 1px;
  height: 100px;
  position: absolute;
  top: 5px;
  left: 16px;
  z-index: -1;
}
ul.activity-timeline > li:last-child:after {
  display: none;
}
.uk-modal-footer {
  button {
    padding: 5px 10px;
    padding: 5px 10px;
    line-height: 20px;
    margin-right: 10px;
    float: right;
    min-width: 70px;
  }
  button.uk-modal-close-default {
    position: static;
  }
}
.uk-active {
  a {
    border-bottom: 1px solid lightseagreen !important;
    background: transparent !important;
    color: black !important;
  }
}
</style>
