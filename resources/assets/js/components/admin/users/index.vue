<template>
  <div class="uk-margin-right">
    <h3>Quản lý người dùng</h3>

    <div class="sosd-background-white">
      <div class="uk-overflow-auto">
        <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
          <thead>
            <tr>
              <th class="uk-table-shrink">Id</th>
              <th class="uk-table-expand">Ảnh đại diện</th>
              <th class="uk-table-expand">Tên người dùng</th>
              <th class="uk-width-expand">Email</th>
              <th class="uk-table-shrink uk-text-nowrap">Điểm</th>
              <th class="uk-table-expand">Hành động</th>
            </tr>
          </thead>
            <paginate
              name="pusers"
              :list="users"
              :per="10"
              tag="tbody"
            >
              <tr v-for="u in paginated('pusers')">
                <td>{{ u.id }}</td>
                <td>
                  <img class="uk-preserve-width uk-border-circle" :src="u.avatar" width="40" alt="">
                </td>
                <td class="uk-table-link">
                  <a class="uk-link-reset" href="">{{ u.name }}</a>
                </td>
                <td class="uk-text-truncate">{{ u.email }}</td>
                <td class="uk-text-nowrap">{{ u.score }}</td>
                <td>
                  <span class="uk-icon-button" uk-icon="pencil"></span>
                  <span class="uk-icon-button" uk-icon="trash"></span>
                </td>
              </tr>
            </paginate>
        </table>
      </div>
    </div>
        <paginate-links for="pusers" :async="true"
          :show-step-links="true"
          :step-links="{
            next: '>',
            prev: '<'
          }"
          :classes="{
            'ul' : 'uk-pagination'
          }"
        ></paginate-links>
  </div>
</template>

<script>
  export default {
    data: function() {
      return {
        users: [],
        paginate: ['pusers']
      }
    },
    mounted() {
      var app = this;
      axios.get('/api/v1/users')
      .then(res => {
        app.users = res.data;
      })
      .catch(res => {
        alert('khong load duoc');
      })
    }
  }
</script>

<style lang="scss" scoped>

</style>
