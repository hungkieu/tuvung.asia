<template>
  <div class="profile-detail uk-card-default">
    <div class="profile-info">
      <h4 class="heading mb-3">Đặt chế độ luyện tập mỗi ngày</h4>
      <h6
        class="text-muted mb-3"
      >Chọn một mục tiêu mỗi ngày sẽ giúp bạn luôn có động lực khi học tập một ngôn ngữ. Nhưng đừng lo, bạn có thể thay đổi mục tiêu luyện tập bất cứ lúc nào.</h6>
      <div>
        <div class="row">
          <div class="col-sm-12">
            <form action id="form_edit_score">
              <label :for="index" class="chonsotu" v-for="(s, index) in list" :key="index">
                <input
                  name="score"
                  class="uk-radio mr-2"
                  v-model="user.target_score"
                  :id="index"
                  :value="s.score"
                  type="radio"
                >
                <span>{{ s.title }} {{s.score}} điểm mỗi ngày</span>
              </label>
              <button class="btn btn-primary" name="btn-target" @click="save_target">Lưu</button>
              <router-link to="/">
                <button
                  class="btn btn-success uk-animation-slide-bottom"
                  v-if="redirect"
                >Quay về trang chủ</button>
              </router-link>
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
      redirect: false,
      list: [
        { title: "Dễ", score: 100 },
        { title: "Vừa", score: 200 },
        { title: "Khó", score: 500 },
        { title: "Rất khó", score: 1000 }
      ],
      user: {}
    };
  },
  created() {
    this.user = Laravel.user;
    axios
      .get("/setting/plan")
      .then(function(res) {
        console.log(res);
      })
      .catch(function(res) {
        console.log("err");
      });
  },
  methods: {
    save_target(e) {
      var app = this;
      e.preventDefault();
      axios
        .post("/setting/plan", {
          id: app.user.id,
          score: app.user.target_score
        })
        .then(res => {
          app.redirect = true;
          app.user.target_score = res.data.target_score;
          flash("Lưu mục tiêu luyện tập thành công", "success");
        })
        .catch(res => {
          flash("Lưu không thành công, vui lòng thử lại", "error");
        });
    }
  }
};
</script>
<style lang="scss" scoped>
.profile-detail {
  padding: 30px 50px 50px;
  color: #252b2f;
  input:valid {
    color: black;
  }
}
.chonsotu {
  display: block;
  padding: 5px;
  border-bottom: 2px solid transparent;
  cursor: pointer;
  &:hover {
    color: blue;
  }
}

#form_edit_score {
  button {
    margin-top: 10px;
  }
}

.sotu p {
  margin-bottom: 18px;
}
</style>
