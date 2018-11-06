<template>
  <div>
    <form>
      <h6 class="py-2">Thời gian học tập</h6>
        <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
          <span v-for="item in week" :key="item.key">
            <input class="uk-checkbox" type="checkbox" name="days" v-model="checkedDaysWeek"
            :checked="item.status ? true : false" value="item.key"   @change="item.status = !item.status" > {{item.name}}
          </span>
        </div>
        <button class="btn btn-primary" name="btn-plan" @click="save_plan">Lưu</button>
      </form>
      <p class="w-100">Vào lúc <input name="time" type="time" class="uk-input  uk-form-small w-25 mx-2  "  v-model="time"/> hằng ngày</p>
  </div>
</template>
<script>
  export default {
    data: function() {
      return {
        time: {},
        checkedDaysWeek: [],
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
        },
        create(){
          this.user = Laravel.user;
          axios
            .get('/setting/reminder')
            .then(function(res) {
              console.log(res);
            })
            .catch(function(res) {
              console.log('err');
            });
        }
        ,methods :{


        save_plan(e) {
          var app = this;
          e.preventDefault();
          axios
          .post('/setting/reminder', {user_id: app.user.id,weekday:app.checkedDaysWeek,time:app.time})
          .then(res => {
            app.weekday= res.data.checkedDaysWeek
            app.time=res.data.time
          })
          .catch(res => {
            alert(res.data);
          })


        }
        }
  }
</script>
<style lang="scss" scoped>
  .formtaokehoach {
    width: 700px;
  }
</style>