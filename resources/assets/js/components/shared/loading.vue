<template>
  <div class="container">
  <span class=""></span>
  <div class="line">
    <div class="inner"></div>
  </div>
  </div>
</template>

<script>
  export default {}
</script>

<style lang="scss" scoped>
$width: 100px;
$height: 100px;

.container{
  //background: #eaeaea;
  width: $width*2;
  height: $height*2;
  background-size: cover;
  vertical-align: middle;
  margin: 200px auto;
}

.fa-linkedin{
  display: block;
  font-size: 5em;
  text-align: center;
  color: #0077B5;
}

.line{
  height: 3px;
  width: 100%;
  background: #e8e8e8;
  margin-top: 30%;

  .inner{
    width: 100%;
    height: inherit;
    background: #1f8bfe;
    animation: slide 2s ease-in-out infinite;
  }
}

@keyframes slide{
  0%{
    transform-origin: left;
    transform: scalex(0.3);
  }
  //12.5%{
    //transform-origin: left;
    //transform: scalex(0.2);
  //}
  25%{
    transform-origin: left;
    transform: scalex(1);
  }
  26%{
    transform-origin: right;
    transform: scalex(1);
  }
  50%{
    transform-origin: right;
    transform: scalex(0.3);
  }
  //62.5%{
    //transform-origin: right;
    //transform: scalex(0.2);
  //}
  75%{
    transform-origin: right;
    transform: scalex(1);
  }
  76%{
    transform-origin: left;
    transform: scalex(1);
  }
  100%{
    transform-origin: left;
    transform: scalex(0.3);
  }
}
</style>
