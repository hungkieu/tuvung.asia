<template>
<div>
  <div class="uk-flex">
    <div class="uk-text-left uk-margin-right">
      <router-link to="/vocabularies">
        <button class="uk-button uk-button-primary sosd-color-white">
          <span uk-icon="icon: arrow-left;"></span> Quay lại
        </button>
      </router-link>
    </div>
  </div>
  <div class="sosd-background-white sosd-box-shadow uk-padding sosd-no-margin" uk-grid>
    <div class="uk-width-1-3" >
      <h3>
        Thêm từ vựng
      </h3>
      <hr>
      <form id="form_create_vocab" class="uk-form-stacked">
        <input type="hidden" name="_token" :value="csrf_token">
        <input type="hidden" v-model="parent_id" name="parent_id">
        <div>
          <label class="uk-form-label">Tiếng Anh</label>
          <div class="uk-form-controls">
            <input class="uk-input" @change="search" v-model="vocabulary.en" type="text" name="en" required id="en">
          </div>
        </div>

        <div>
          <label class="uk-form-label">Tiếng Việt</label>
          <div class="uk-form-controls">
            <input class="uk-input" type="text" name="vi">
          </div>
        </div>

        <div>
          <label class="uk-form-label">Loại từ</label>
          <div class="uk-form-controls uk-column-1-3">
            <label>
              <input value="Danh từ" class="uk-checkbox" type="checkbox" name="type[]">
              Danh từ
            </label>
            <label>
              <input value="Động từ" class="uk-checkbox" type="checkbox" name="type[]">
              Động từ
            </label>
            <label>
              <input value="Tính từ" class="uk-checkbox" type="checkbox" name="type[]">
              Tính từ
            </label>
            <label>
              <input value="Trạng từ" class="uk-checkbox" type="checkbox" name="type[]">
              Trạng từ
            </label>
            <label>
              <input value="Giới từ" class="uk-checkbox" type="checkbox" name="type[]">
              Giới từ
            </label>
            <label>
              <input value="Từ nối" class="uk-checkbox" type="checkbox" name="type[]">
              Từ nối
            </label>
          </div>
        </div>
        <div>
          <label class="uk-form-label">Hình ảnh</label>
          <div>
            <input type="file" id="file" name="image" style="display: none" @change="preview_image">
            <label for="file" class="preview_image" v-if="preview">
              <img :src="preview_image_vl" />
              <span class="txt-change-image">Thay đổi ảnh</span>
            </label>
            <label for="file" class="preview" v-else="preview">
              Upload hình ảnh
            </label>
          </div>
        </div>
        <div class="uk-margin">
         <button @click="send" class="uk-button uk-button-primary sosd-color-white">Thêm từ mới</button>
        </div>
      </form>
    </div>
    <div class="uk-width-2-3" >
      <h3>
        Hình ảnh gợi ý
      </h3>
      <hr>
      <div uk-grid="mansonry: true" v-if="searches.length > 0">
        <div v-for="v in searches">
          <img :src="v.image" width="200px">
        </div>
      </div>
      <div v-else>
        <b>Không có hỉnh ảnh phù hợp</b>
      </div>
    </div>
 </div>
</div>
</template>

<script>
export default {
  data: function() {
    return {
      csrf_token: '',
      preview: false,
      preview_image_vl: '',
      parent_id: 0,
      vocabulary: {
        en: ''
      },
      searches: []
    };
  },
  mounted() {
    var app = this;
    axios.get('/api/v1/vocabularies/search/all')
    .then(res => {
      app.searches = res.data;
    })
    .catch(res => {
      alert('khong load duoc');
    })

    if (this.$route.params.id) {
      this.parent_id = this.$route.params.id;
    }
    this.csrf_token = Laravel.csrf_token;

    jQuery.extend(jQuery.expr[':'], {
      focusable: function(el, index, selector) {
        return $(el).is('a, button, :input, [tabindex]');
      }
    });

    $(document).on('keypress', 'input,select', function(e) {
      if (e.which == 13) {
        e.preventDefault();
        var $canfocus = $(':focusable');
        var index = $canfocus.index(document.activeElement) + 1;
        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
      }
    });
  },
  methods: {
    search() {
      var app = this;
      var en = app.vocabulary.en
      axios.get('/api/v1/vocabularies/search/' + en)
      .then(res => {
        app.searches = res.data;
      })
      .catch(res => {
        alert('khong load duoc');
      })
    },

    send(e) {
      var app = this;
      e.preventDefault();
      var f = document.getElementById('form_create_vocab');
      var formData = new FormData(f);
      let input_en = document.getElementById('en');

      if (input_en.value != '') {
        axios
          .post('/vocabularies', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
          .then(function(res) {
            if (app.$route.params.id) app.$router.push('/vocabularies/' + app.$route.params.id);
            else app.$router.push('/vocabularies');
            f.reset();
          })
          .catch(function(res) {
            alert('Them khong thanh cong, vui long thu lai');
          });
      } else {
        alert('Bạn phải nhập từ tiếng Anh');
      }
    },

    preview_image(e) {
      var files = e.target.files;
      if (files && files[0]) {
        var reader = new FileReader();
        var app = this;
        reader.onload = function(e) {
          app.preview_image_vl = e.target.result;
        };
        reader.readAsDataURL(files[0]);
        this.preview = true;
      }
    }
  }
};
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
.preview {
  width: 150px;
  height: 150px;
  border: 1px dashed rgb(33, 33, 33);
  line-height: 150px;
  text-align: center;
}
.preview_image {
  height: 200px;
  width: 100%;
  max-width: 200px;
  min-width: 150px;
  position: relative;
  img {
    object-fit: cover;
    height: 100%;
    width: 100%;
  }
  .txt-change-image {
    position: absolute;
    display: none;
    bottom: 0;
    left: 0;
    width: 100%;
    text-align: center;
    background: rgba(0, 0, 0, 0.3);
    color: #fff !important;
    padding: 10px;
  }
  &:hover {
    .txt-change-image {
      display: block;
    }
  }
}
</style>
