<template>
  <div class="reminder uk-card-default">
    <form>
      <h4 class="heading mb-3">Thời gian học tập</h4>
      <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
        <span v-for="item in week" :key="item.key">
          <input class="uk-checkbox" type="checkbox" name="days" v-model="plan.weekday" :value="item.key"> {{item.name}}
        </span>
      </div>

      <p class="w-100">
        Vào lúc <input name="time" type="time" class="uk-input uk-form-small w-25 mx-2" v-model="plan.time"/> hằng ngày
      </p>
      <button class="btn btn-primary" name="btn-plan" @click="save_plan">Lưu</button>
    </form>
  </div>
</template>
<script>
  export default {
    data: function() {
      return {
        plan: {
          weekday: [],
          time: '21:00',
          user_id: 0,
        },
        user: {},
        week: [
          {
            id: 'monday',
            name: 'Thứ 2',
            status: true,
            key:1
          },
          {
            id: 'tuesday',
            name: 'Thứ 3',
            status: false,
            key:2
          },
          {
            id: 'wednesday',
            name: 'Thứ 4',
            status: false,
            key:3
          },
          {
            id: 'thursday',
            name: 'Thứ 5',
            status: false,
            key:4
          },
          {
            id: 'friday	',
            name: 'Thứ 6',
            status: false,
            key:5
          },
          {
            id: 'saturday',
            name: 'Thứ 7',
            status: false,
            key:6
          },
          {
            id: 'sunday',
            name: 'Chủ nhật ',
            status: false,
            key:0
          }
        ],
      }
    },
    created(){
      this.user = Laravel.user;
      this.get_data();
    },
    methods :{
      get_data() {
        axios.get('/c/training_plans/' + this.user.id)
          .then(res => {
            res.data.weekday = JSON.parse(res.data.weekday);
            this.plan = res.data;
          })
          .catch()
      },

      save_plan(e) {
        var app = this;
        e.preventDefault();
        axios
          .post('/setting/reminder', this.plan)
          .then(res => {
            flash(' Lưu thành công ', 'success');
          })
          .catch(res => {
          })
      }
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
