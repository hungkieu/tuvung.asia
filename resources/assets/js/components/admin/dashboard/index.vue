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
                <div class="row">
                  <div class="col-6" >
                    <h5>{{grammarsUser.length}}</h5>
                    <p class="mb-0">Ngữ pháp</p>
                    <p class="mb-0">( Người dùng )</p>
                  </div>
                  <div class="col-6" >
                    <h5>{{grammars.length}}</h5>
                    <p class="mb-0">Ngữ pháp</p>
                    <p class="mb-0">( Hệ thống )</p>
                  </div>
                </div>
                    
              </div>
          </div>
      </div>
      <hr/>
      <div class="row">
        
        <div class="col-12">
            <h5 class="my-3">Người dùng có điểm cao</h5>
                <div class="uk-card-default">
                  <table class="uk-table uk-table-divider mt-0">
                    <thead class="bg-black">
                      <tr>
                          <th>Email </th>
                          <th>Điểm</th>
                          <th>Số từ vựng</th>
                          <th>Số ngữ pháp</th>
                      </tr>
                  </thead>
                    <tbody>
                        <tr  v-for="(u, i) in sortedArr(users, 'core', 'desc')" v-if="i < 10"  :key="u.id">
                            <td>{{u.email}}</td>
                            <td >
                              {{u.score }}
                            </td>
                            <td>{{u.created_at}}</td>
                            <td>{{u.created_at}}</td>
                        </tr>
                    </tbody>
                </table>
                </div>
<hr/>
        </div>
        <div class="col-8">
            <h5 class="mt-3">Người dùng mới</h5>
            <table class="uk-table uk-table-divider uk-card-default mt-0">
                <tbody>
                    <tr  v-for="(u, i) in sortedArr(users, 'created_at', 'asc')" v-if="u.is_newbie == 1 && i < 10" :key="u.id">
                        <td>{{u.name}}</td>
                        <td>{{u.email}}</td>
                        <td>{{u.created_at}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
      <hr/>
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
          // console.log(res.data);
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
          console.log(app.grammarsUser);

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
    sortedArr(arr, key, type) {
      if (type == 'asc') {
        return arr.sort((a, b) => a[key] - b[key]);
      }
      return arr.sort((a, b) => b[key] - a[key]);
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
.bg-black {
  background: #fafafa;
  color: black;
  th {
    color: black !important;
    font-weight: 500;
  }
}
</style>

