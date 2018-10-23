<template>
  <div class="uk-padding-bottom">
    <div class="uk-container-large uk-grid-medium" uk-grid>
      <router-link class="uk-animation-slide-bottom sosd-card uk-width-1-4" to="/vocabularies">
        <p class="title">Từ vựng</p>
        <p class="thumbnail">
          <span uk-icon="icon: happy; ratio: 5"></span>
        </p>
        <p class="body">
          <p class="description">
            Xây dựng vốn từ vựng của bạn một cách đơn giản và thoải mái
          </p>
          <p><span>Bạn đã thêm</span></p>
          <p class="count">
            <span class="uk-text-success" id="count_vocabularies">
              {{ count_vocabularies }} từ
            </span>
          </p>
        </p>
      </router-link>
      <router-link  class="uk-animation-slide-bottom sosd-card uk-width-1-4" to="/grammars">
        <p class="title">Đặt câu</p>
        <p class="thumbnail">
          <span uk-icon="icon: comments; ratio: 5"></span>
        </p>
        <p class="body">
          <p class="description">
            Luyện tập đặt câu bằng các từ và cấu trúc dễ dàng, dễ ghi nhớ
          </p>
          <p><span>Số câu bạn đã thêm</span></p>
          <p>
            <span class="uk-text-success" id="count_vocabularies">
              0 câu
            </span>
          </p>
        </p>
      </router-link>
      <div class="uk-animation-slide-bottom sosd-chart uk-width-expand">
        <p class="title">Hoạt động gần đây</p>
      </div>
    </div>
    <div class="uk-container-large uk-grid-medium" uk-grid>
      <router-link class="uk-animation-slide-bottom sosd-card uk-width-1-3" to="/grammars">
        <p class="title">Chia sẻ câu chuyện của bạn</p>
        <p class="thumbnail">
          <span uk-icon="icon: heart; ratio: 5"></span>
        </p>
        <p class="body">
          <p class="description">
            Chia sẻ các bức ảnh của bạn và câu chuyện đằng sau nó
          </p>
          <p><span>Số câu bạn đã thêm</span></p>
          <p>
            <span class="uk-text-success" id="count_vocabularies">
              0 câu
            </span>
          </p>
        </p>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      count_vocabularies: 0,
    };
  },
  mounted() {
    var app = this;
    axios.get('/api/v1/users/' + Laravel.user.id + '/vocabularies/count')
    .then(res => {
      app.count_vocabularies = res.data;
    })
    .catch(res => {
      alert('Khong load duoc');
    })
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

.sosd-chart {
  background: white;
  min-height: 200px;
  padding-left: 0px;
  margin: 0 10px;
  color: #333333;
  box-shadow: 1px 1px 5px rgba(33, 33, 33, 0.5);
  p.title{
    text-align: center;
    font-weight: bold;
    margin: 20px 0px;
  }
}

.sosd-card {
  background: white;
  min-height: 200px;
  padding-left: 0px;
  margin: 0 10px;
  color: #333333;
  box-shadow: 1px 1px 5px rgba(33, 33, 33, 0.5);
  text-align: center;
  text-decoration: none;
  transition: all ease 1s;
  p.title{
    font-weight: bold;
    margin: 20px 0px;
  }
  p.description {
    width: 85%;
    margin: 5px auto 20px;
  }
  p {
    margin: 5px 0px;
  }
}
</style>
