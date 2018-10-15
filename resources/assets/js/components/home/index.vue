<template>
  <div>
<router-link to="/vocabularies">Từ vựng</router-link>
 <router-link to="/grammars">Ngữ pháp</router-link>
      
  </div>
</template>

<script>
export default {
  data: function() {
    return {};
  }
};
</script>

<style lang="scss" scoped>
nav {
  span.uk-icon {
    display: inherit;
    padding: 0 10px;
  }
  a {
    font-weight: bold;
    &:hover {
      text-decoration: none;
      color: tomato;
    }
  }
}
</style>
