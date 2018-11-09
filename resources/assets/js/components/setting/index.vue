<template>
<div class="setting">
<div class="uk-container">
  <div class="row">
      <div class="col-3">
          <div class="uk-card uk-card-default uk-card-body uk-width-1-1">
            <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
                <li><router-link to='/setting/account'><img src="/svg/user.svg"/>Tài khoản</router-link></li>
                <li><router-link to='/setting/photos'><img src="/svg/image.svg"/>Ảnh</router-link></li>
                <li><router-link to='/setting/profile'><img src="/svg/pass.svg"/>Hồ sơ</router-link></li>
                <!-- <li><router-link to='/setting/notifications'><img src="/svg/bell.svg"/>Thông báo</router-link></li> -->
                <li><router-link to='/setting/reminder'><img src="/svg/notebook1.svg"/>Kế hoạch học tập</router-link></li>
                <li><router-link to='/setting/study-goal'><img src="/svg/radar.svg"/>Mục tiêu học tập</router-link></li>
            </ul>
        </div>
      </div>
      <div class="col-8">
          <router-view></router-view>
      </div>
  </div>
</div>

</div>
</template>
<script>
export default {};
</script>
<style lang="scss" scoped>
$color-main: #1f8bf0;
.router-link-active {
  color: $color-main !important;
  font-weight: 500;
  &:hover {
    color: #fff !important;
  }
}
.setting {
  background: #eeeeee;
  padding: 30px 0 50px;
  font-size: 16px;
}
.uk-card {
  a {
    font-size: 16px;
    display: block;
    color: #252b2f;
    padding: 0.625rem 1.25rem 0.625rem 0;
    cursor: pointer;
    img {
      width: 30px;
      height: 30px;
      object-fit: cover;
      margin-right: 10px;
    }
    &:hover {
      text-decoration: none;
      background: $color-main;
      color: #fff;
      transform: scale(1.05, 1.2);
      font-size: 15px;
    }
  }
}
</style>