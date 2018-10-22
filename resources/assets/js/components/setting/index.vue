<template>
<div>
<nav class="uk-navbar-container pb-3" uk-navbar>
        <div class="uk-navbar-left">
            <router-link to="/">Trang chủ</router-link> <span uk-icon="icon: chevron-right; "></span>
            <router-link to="/setting">Cài đặt</router-link>  
            
        </div>
        <div class="uk-navbar-right">
        </div>
      </nav>
    
  <div class="sosd-background-white sosd-box-shadow uk-padding sosd-no-margin" uk-grid>
  <h3>Đặt chế độ luyện tập mỗi ngày</h3>
  <h6 class="text-muted">Chào mừng bạn đến với chế độ Huấn luyện! Chọn một mục tiêu mỗi ngày sẽ giúp bạn luôn có động lực khi học tập một ngôn ngữ. Nhưng đừng lo, bạn có thể thay đổi mục tiêu luyện tập bất cứ lúc nào.</h6>
  <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <img src="images/logo.jpg" alt="img">
            </div>
            <div class="col-sm-2">
            <form action="" >
          
                <div class="chonsotu"><input   type="radio"/> cơ bản               </div>
                <div class="chonsotu"><input  type="radio"/> dễ    </div>
                <div class="chonsotu"><input  type="radio"/> vừa   </div>
                <div class="chonsotu"><input  type="radio"/> khó  </div>
                <div class="chonsotu"><input  type="radio"/> rất khó </div>
                 
                
            </form>
            </div>
            <div class="col-sm-4 sotu">
                <p>1 từ mỗi ngày</p>
                <p>3 từ mỗi ngày</p>
                <p>5 từ mỗi ngày</p>
                <p>7 từ mỗi ngày</p>
                <p>10 từ mỗi ngày</p>
            </div>
        </div>    
  </div>
  <button href="#modal-reminder" uk-toggle class="btn btn-success sosd-color-white "> Tạo kế hoạch học tập</button>
    </div>

    
<!-- Modal change password -->
<div id="modal-reminder" class="uk-flex-top" uk-modal>
  <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical formtaokehoach">

    <div class="uk-modal-body">

     <form class="uk-grid-small" uk-grid>
      <div class="uk-width-1-1">
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
    </form>
  </div>
  <div class="uk-modal-footer pb-0">
   <button class="uk-modal-close-default uk-button uk-button-default uk-text-uppercase" type="button">Hủy</button>
    <button class="uk-buttonuk-text-uppercase uk-button-primary">Lưu</button>
</div>

</div>
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
       time: '21:00',

      }
  }
}
</script>
<style lang="scss" scoped>
nav {
  span.uk-icon {
    display: inherit;
    padding: 0 10px;
  }
  a {
    font-weight: bold;
    &:hover {
      text-decoration: none;
      color: tomato;
    }
  }
}
.chonsotu{
    margin-bottom:16px;
    color:green!important;
    font-weight: bold;
    text-transform: capitalize;
    border: 1px solid green;
    border-radius: 7px;
    padding-left: 51px;
    
}

.formtaokehoach{
    width:700px;
}
.sotu p{
    margin-bottom :18px;
}

</style>