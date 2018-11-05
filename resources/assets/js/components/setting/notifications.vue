<template>
       <div class="profile-notification uk-card-default text-center">
           <h4 class="text-left mb-3">Thông báo</h4>
        </div>
</template>
<script>
export default {
  data: function() {
    return {
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
      ]
    };
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