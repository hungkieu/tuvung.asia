<template>
  <div class="reminder uk-card-default">
    <form>
      <h4 class="heading mb-3">Thời gian học tập</h4>
      <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
        <span v-for="item in week" :key="item.key">
          <input
            class="uk-checkbox"
            type="checkbox"
            name="days"
            v-model="checkedDaysWeek"
            :value="item.key"
          >
          {{item.name}}
        </span>
      </div>

      <p class="w-100">
        Vào lúc
        <input
          name="time"
          type="time"
          class="uk-input uk-form-small w-25 mx-2"
          v-model="time"
        > hằng ngày
      </p>
      <button class="btn btn-primary" name="btn-plan" @click="save_plan">Lưu</button>
    </form>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      time: {},
      checkedDaysWeek: [],
      user: {},
      week: [
        {
          id: "monday",
          name: "Thứ 2",
          status: true,
          key: 0
        },
        {
          id: "tuesday",
          name: "Thứ 3",
          status: false,
          key: 1
        },
        {
          id: "wednesday",
          name: "Thứ 4",
          status: false,
          key: 2
        },
        {
          id: "thursday",
          name: "Thứ 5",
          status: false,
          key: 3
        },
        {
          id: "friday	",
          name: "Thứ 6",
          status: false,
          key: 4
        },
        {
          id: "saturday",
          name: "Thứ 7",
          status: false,
          key: 5
        },
        {
          id: "sunday",
          name: "Chủ nhật ",
          status: false,
          key: 6
        }
      ],
      time: "21:00"
    };
  },
  created() {
    this.user = Laravel.user;
    axios
      .get("/setting/reminder")
      .then(function(res) {
        console.log(res);
      })
      .catch(function(res) {
        console.log("err");
      });
  },
  methods: {
    save_plan(e) {
      var app = this;
      e.preventDefault();
      axios
        .post("/setting/reminder", {
          user_id: app.user.id,
          weekday: app.checkedDaysWeek,
          time: app.time
        })
        .then(res => {
          app.weekday = res.data.checkedDaysWeek;
          app.time = res.data.time;
          flash("Tạo kế hoạch thành công !", "success");
        })
        .catch(res => {
          flash("Không thành công , vui lòng thử lại !", "error");
        });
    }
  }
};
</script>
<style lang="scss" scoped>
.reminder {
  padding: 30px 50px 50px;
  .heading {
    color: black;
  }
}
</style>
