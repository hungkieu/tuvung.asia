<template>
<div class="setting">
<div class="uk-container">
<div class="row">
    <div class="col-3">
        <div class="uk-card uk-card-default uk-card-body uk-width-1-1">
          <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
              <li><router-link to='/setting/account'><img src="/images/icon_account.png"/>Tài khoản</router-link></li>
              <li><router-link to='/setting/photos'><img src="/images/icon_photos.png"/>Ảnh</router-link></li>
              <li><router-link to='/setting/profile'><img src="/images/icon_setting1.png"/>Hồ sơ</router-link></li>
              <li><router-link to='/setting/notifications'><img src="/images/icon_notification.png"/>Thông báo</router-link></li>
              <li><router-link to='/setting/study-plan'><img src="/images/icon_plan1.png"/>Kế hoạch học tập</router-link></li>
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
  &:hover {
    color: #fff !important;
  }
}
.setting {
  background: #f2f5f8;
  padding: 30px 0;
}
.uk-card {
  a {
    font-size: 18px;
    display: block;
    color: #252b2f;
    padding: 0.625rem 1.25rem 0.625rem 0;
    cursor: pointer;
    img {
      width: 40px;
      height: 40px;
      object-fit: cover;
      margin-right: 10px;
    }
    &:hover {
      text-decoration: none;
      background: $color-main;
      color: #fff;
      transform: scale(1.05, 1.2);
      font-size: 18px;
    }
  }
}
</style>