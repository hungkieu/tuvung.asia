<template>
<div>
  <nav class="uk-navbar-container pb-3" uk-navbar>
            <div class="uk-navbar-left">
                <router-link to="/">Trang chủ</router-link> <span uk-icon="icon: chevron-right; "></span>
                <router-link to="/grammars">Ngữ pháp</router-link> <span uk-icon="icon: chevron-right; "></span>
                <router-link to="">Bộ ngữ pháp cơ bản</router-link>
            </div>
            <div class="uk-navbar-right">
            </div>
         </nav>
    <div id="accordion">
  <div class="card">
    <div class="uk-alert-success mb-0" uk-alert id="headingOne"  data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
      <h5 class="mb-0">
          Thì hiện tại đơn
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body p-3">
        1. Định nghĩa thì hiện tại đơn
Thì hiện tại đơn (tiếng Anh: Simple present hoặc Present simple) là một thì trong tiếng Anh hiện đại. Thì này diễn tả một hành động chung chung, tổng quát lặp đi lặp lại nhiều lần hoặc một sự thật hiển nhiên hoặc một hành động diễn ra trong thời gian hiện tại.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="uk-alert-success mb-0" uk-alert  id="headingTwo"  data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
      <h5 class="mb-0">
          Giới từ
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body p-3">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>

</div>
</template>
<script>
export default {};
</script>
<style lang="scss" scoped>
nav {
  text-transform: uppercase;
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


