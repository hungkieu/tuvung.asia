<template>
</template>

<script>
  export default {
    name: "Flash",
    methods:{
      onFlash(m){
        toastr[m.status](m.message, m.title, {progressBar: true});
      }
    },
    created() {
      var app = this;
      window.notify.$on('flash', function(msg) {
        app.onFlash(msg);
      });
    }
  };
</script>
