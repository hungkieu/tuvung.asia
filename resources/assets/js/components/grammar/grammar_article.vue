<template>
<div>
  12132

</div>
</template>
<script>
export default {
  data() {
    return {
      grammarsArticles: []
    };
  },
  created() {
    const app = this;
    axios
      .get('/ngu-phap-tieng-anh')
      .then(function(res) {
        app.grammarsArticles = res.data;
        // let a = app.grammarsArticles.find('div.td-page-title');
        console.log(app.grammarsArticles);
      })
      .catch(function(res) {
        console.log('err' + res);
      });
  }
};
</script>
<style lang="scss" scoped>
</style>


