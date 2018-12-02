<template>
<div>
  <div uk-grid="mansonry: true" v-if="images.length > 0" class="body">
    <div class="sosd_images uk-animation-slide-bottom" v-for="v in shuffleImages">
      <img :src="v.url" width="200px" uk-tooltip="chọn" class="" @click="select(v.url)">
    </div>
  </div>
  <div v-else>
    <p>Hiện không có hình ảnh phù hợp với <em>{{q}}</em>, bạn có thể vui lòng upload hình ảnh cho từ này.</p>
  </div>
</div>
</template>

<script>
  export default {
    props: ['q'],
    data: function() {
      return {
        images: [],
      }
    },
    mounted() {
      this.search();
    },
    computed: {
      shuffleImages() {
        return this.shuffleArray(this.images);
      }
    },
    watch: {
      q() {
        this.search();
      }
    },
    methods: {
      search() {
        var app = this;
        var url = '/c/suggest-images/' + app.q;
        axios
          .get(url)
          .then(res => {
            app.images = res.data;
          })
          .catch(res => {
            flash('Tải hình ảnh gợi ý không thành công','error');
          });
      },
      shuffleArray(array) {
        for (var i = array.length - 1; i > 0; i--) {
          var j = Math.floor(Math.random() * (i + 1));
          var temp = array[i];
          array[i] = array[j];
          array[j] = temp;
        }
        return array;
      },
      select(url) {
        this.$emit('selectImage', url);
      }
    },
  }
</script>

<style lang="scss" scoped>
  .body {
    height: 80vh;
    overflow-y: scroll;
    .sosd_images {

    }
  }
</style>
