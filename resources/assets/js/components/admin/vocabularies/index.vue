<template>
  <div class="uk-margin-right">
    <h3>Quản lý từ vựng</h3>

    <div class="sosd-background-white">
      <div class="uk-overflow-auto">
        <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
          <thead>
            <tr>
              <th class="uk-table-shrink">Id</th>
              <th class="uk-table-expand">Tiếng Anh</th>
              <th class="uk-table-expand">Tiếng Việt</th>
              <th class="uk-table-expand">Hình ảnh</th>
              <th class="uk-table-shrink uk-text-nowrap">Người tạo</th>
              <th class="uk-table-expand">Hành động</th>
            </tr>
          </thead>
            <paginate
              name="pvocabularies"
              :list="vocabularies"
              :per="10"
              tag="tbody"
            >
              <tr v-for="u in paginated('pvocabularies')">
                <td>{{ u.id }}</td>
                <td class="uk-table-link">
                  <a class="uk-link-reset" href="">{{ u.en }}</a>
                </td>
                <td class="uk-text-truncate">{{ u.vi }}</td>
                <td>
                  <img class="uk-preserve-width uk-border-circle" :src="u.image" width="40" alt="">
                </td>
                <td class="uk-text-nowrap">{{ u.name }}</td>
                <td>
                  <span class="uk-icon-button" uk-icon="pencil"></span>
                  <span class="uk-icon-button" uk-icon="trash"></span>
                </td>
              </tr>
            </paginate>
        </table>
      </div>
    </div>
        <paginate-links for="pvocabularies" :async="true"
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
        vocabularies: [],
        paginate: ['pvocabularies']
      }
    },
    mounted() {
      var app = this;
      axios.get('/api/v1/vocabularies')
      .then(res => {
        console.log(res.data);
        app.vocabularies = res.data;
      })
      .catch(res => {
        alert('khong load duoc');
      })
    }
  }
</script>

<style lang="scss" scoped>

</style>
