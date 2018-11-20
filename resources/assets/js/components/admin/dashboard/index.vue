<template>
   <div class="uk-margin-right">
       <h5 class="">Overview</h5>
          <hr  />
      <div class="row">
          <div class="col-4 pr-5">
              <div class="bg-info">
                    <h5>{{users.length}}</h5>
                    <p>Người dùng</p>
              </div>
          </div>
          <div class="col-4 px-4">
              <div class="bg-warning">
                    <h5>{{vocabularies.length}}</h5>
                    <p>Từ vựng</p>
              </div>

          </div>
          <div class="col-4 pl-5">
              <div class="bg-danger">
                    <h5>{{grammars.length}}</h5>
                    <p>Ngữ pháp</p>
              </div>
          </div>
      </div>
      <hr/>
      <div class="row">
        <div class="col-7">
            <h5 class="mt-3">Người dùng mới</h5>
            <table class="uk-table uk-table-divider mt-0">
                <tbody>
                    <tr  v-for="u in users" v-if="u.is_newbie == 1" :key="u.id">
                        <td>{{u.name}}</td>
                        <td>{{u.email}}</td>
                        <td>{{u.created_at}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-5">
            <h5 class="my-3">Người dùng có điểm cao</h5>
                <ul class="uk-list uk-alert-success py-3 uk-card-default">
                    <li class="px-3" v-for="u in sortedArray(users)" :key="u.id">{{u.name}} - {{u.score}} point</li>
                </ul>
            
        </div>
      </div>
    </div>
</template>
<script>
export default {
  data: function() {
    return {
      users: [],
      grammarsUser: [],
      vocabularyUser: [],
      grammars: [],
      vocabularies: []
    };
  },
  mounted() {
    this.getUser();
    // this.getGrammarUser();
    // this.get_vocabularies();
    this.getStructureSentences();
    this.getVocabulary();
  },
  methods: {
    getUser() {
      var app = this;
      axios
        .get('/api/v1/users')
        .then(res => {
          console.log(res.data);
          app.users = res.data;
        })
        .catch(res => {
          alert('khong load duoc');
        });
    },
    getGrammarUser() {
      var app = this;
      axios
        .get('/grammars/' + app.user.id)
        .then(function(res) {
          app.grammarsUser = res.data;
        })
        .catch(function(res) {
          console.log('err');
        });
    },
    getVocabularyUser() {
      var app = this;
      $.ajax({
        url: '/api/v1/users/' + app.user.id + '/vocabularies',
        method: 'get'
      })
        .done(res => {
          app.vocabularyUser = res;
        })
        .fail(res => {});
    },
    getStructureSentences() {
      var app = this;
      axios
        .get('/admin/structure-sentences')
        .then(function(res) {
          app.grammars = res.data;
        })
        .catch(function(res) {
          console.log(res);
        });
    },
    getVocabulary() {
      var app = this;
      axios
        .get('/api/v1/vocabularies')
        .then(res => {
          app.vocabularies = res.data;
        })
        .catch(res => {
          alert('khong load duoc');
        });
    },
    sortedArray(arr) {
      return arr.sort((a, b) => a.score > b.score);
    }
  }
};
</script>
<style lang="scss" scoped>
.bg-info {
  border: 1px solid lightseagreen;
  background-color: lightgreen !important;
  border-radius: 0.25rem;
  color: #fff;
  padding: 1.25rem;
}
.bg-warning {
  border: 1px solid #c69500;
  background-color: #ffc107 !important;
  border-radius: 0.25rem;
  color: #fff;
  padding: 1.25rem;
}
.bg-danger {
  border: 1px solid #f5302e;
  background-color: #f86c6b !important;
  border-radius: 0.25rem;
  color: #fff;
  padding: 1.25rem;
}
</style>

