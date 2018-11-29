<template>
  <div class="uk-margin-right">
    <h5 class="color-title">Overview</h5>
    <hr>
    <div class="row">
      <div class="col-4 pr-5">
        <div class="bg-danger">
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
        <div class="bg-info">
          <div class="row">
            <div class="col-6">
              <h5>{{grammar_users}}</h5>
              <p class="mb-0">Ngữ pháp</p>
              <p class="mb-0">( Người dùng )</p>
            </div>
            <div class="col-6">
              <h5>{{grammars.length}}</h5>
              <p class="mb-0">Ngữ pháp</p>
              <p class="mb-0">( Hệ thống )</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-xl-7 col-12">
        <h5 class="my-3 color-title">Người dùng có điểm cao</h5>
        <div class="uk-card-default">
          <table class="uk-table uk-table-divider mt-0">
            <thead class="bg-black">
              <tr>
                <th class="text-center">Email</th>
                <th class="text-center">Điểm</th>
                <th class="text-center">Số từ vựng</th>
                <th class="text-center">Số ngữ pháp</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(u, i) in sortedArr(users, 'core', 0)" v-if="i < 10" :key="u.id">
                <td class="text-center color-black">{{u.email}}</td>
                <td class="text-center color-black">{{u.score }}</td>
                <td class="text-center color-black">{{u.vocabulary_total}}</td>
                <td class="text-center color-black">{{u.grammar_total}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <hr>
      </div>
      <div class="col-xl-5 col-12">
        <h5 class="mt-3 color-title">Người dùng mới</h5>
        <table class="uk-table uk-table-divider uk-card-default mt-0">
          <thead class="bg-black">
            <tr>
              <th class="text-center d-xl-none d-block">Tên người dùng</th>
              <th class="text-center">Email</th>
              <th class="text-center">Ngày tạo</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(u, i) in sortedArr(users, 'created_at', 0)" v-if="i < 5" :key="u.id">
              <td class="color-black text-center d-xl-none d-block">{{u.name}}</td>
              <td class="color-black text-center">{{u.email}}</td>
              <td class="color-black text-center">{{u.created_at}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <hr>
  </div>
</template>
<script>
export default {
  data: function() {
    return {
      users: [],
      grammar_users: 0,
      grammarsUser: [],
      vocabularyUser: [],
      grammars: [],
      vocabularies: []
    };
  },
  mounted() {
    this.getUser();
    // this.get_vocabularies();
    this.getStructureSentences();
    this.getVocabulary();
  },
  methods: {
    getUser() {
      var app = this;
      axios
        .get("/api/v1/users")
        .then(res => {
          // console.log(res.data);
          app.users = res.data;
          for (let index = 0; index < app.users.length; index++) {
            const element = app.users[index];
            console.log(parseInt(element.grammar_total));
            app.grammar_users += parseInt(element.grammar_total);
          }
        })
        .catch(res => {
          alert("khong load duoc");
        });
    },
    getVocabularyUser() {
      var app = this;
      $.ajax({
        url: "/api/v1/users/" + app.user.id + "/vocabularies",
        method: "get"
      })
        .done(res => {
          app.vocabularyUser = res;
        })
        .fail(res => {});
    },
    getStructureSentences() {
      var app = this;
      axios
        .get("/admin/structure-sentences")
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
        .get("/api/v1/vocabularies")
        .then(res => {
          app.vocabularies = res.data;
        })
        .catch(res => {
          alert("khong load duoc");
        });
    },
    sortedArr(arr, key, type) {
      if (type === 1) {
        return arr.sort((a, b) => b[key] - a[key]);
      } else {
        return arr.sort((a, b) => a[key] - b[key]);
      }
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
.color-black {
  color: black !important;
}
.color-title {
  color: lightseagreen;
}
</style>

