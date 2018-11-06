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
                <img src="/images/logo.jpg" alt="img">
            </div>
            <div class="col-sm-9">
            <form action="" id="form_edit_score" >
              <div class="chonsotu" v-for="(s, index) in list" :key="index">
                <input name="score" v-model="user.target_score" :id="index"  :value="s.score" type="radio"/>
                <label :for="index">{{ s.title }} {{s.score}} điểm mỗi ngày</label>
              </div>
              <button class="btn btn-primary" name="btn-target" @click="save_target"> Lưu</button>
            </form>
            </div>
        </div>    
  </div>

    </div>

</div>
</template>
<script>
export default {
   data: function() {
    return {
      list: 
        [{title: "Dễ", score: 50},{title: "Vừa", score: 100},{title: "Khó", score: 200},{title: "Rất khó", score: 500} ],
      user: {},

    }
  },
  created() {
    this.user = Laravel.user;
    axios
      .get('/setting/plan')
      .then(function(res) {
        console.log(res);
      })
      .catch(function(res) {
        console.log('err');
      });
  },
    methods: {
    save_target(e) {
      var app = this;
        e.preventDefault();
      axios
        .post('/setting/plan', {id: app.user.id, score: app.user.target_score})
        .then(res => {
          app.user.target_score = res.data.target_score
        })
        .catch(res => {
          alert(res.data);
        })
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
  display: flex;
  align-items: center;
}


.sotu p{
  margin-bottom :18px;
}

</style>