<template>
       <div class="profile-notification uk-card-default text-center">
           <h4 class="text-left mb-3">Thông báo</h4>
        </div>
</template>
<script>
export default {
  data: function() {
    return {};
  }
};
</script>
<style lang="scss" scoped>
$color-main: #1f8bf0;
.profile-notification {
  padding: 30px 50px 50px;
  color: #252b2f;
  input:valid {
    color: black;
  }
}
</style>