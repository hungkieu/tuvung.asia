<template>
  <div>
    <div v-if="loading">
      <Loading></Loading>
    </div>

    <div v-if="error">
      <b>Vui lòng thử lại</b>
    </div>

    <div v-if="success">
    </div>
  </div>
</template>

<script>
  import Loading from './../shared/loading';

  export default {
    components: {
      Loading: Loading
    },
    data: function() {
      return {
        error: false,
        success: false,
        loading: true,
        user: {},
        vocabularies: []
      };
    },
    mounted() {
      this.user = Laravel.user;
      this.get_vocabularies();
    },
    watch: {
      error() {
        if (this.error) {
          this.success = false;
          this.loading = false;
        }
      },
      success() {
        if (this.success) {
          this.error = false;
          this.loading = false;
        }
      },
      loading() {
        if (this.loading) {
          this.error = false;
          this.success = false;
        }
      },
    },
    methods: {
      get_vocabularies() {
        var app = this;
        $.ajax({
          url: '/api/v1/users/' + app.user.id + '/vocabularies',
          method: 'get'
        })
        .done(res => {
          app.vocabularies = res;
          setTimeout(function() {
            app.success = true;
          }, 500);
        })
        .fail(res => {
          setTimeout(function() {
            app.error = true;
          }, 500);
        });
      }
    }
  };
</script>

<style lang="scss" scoped>

</style>
