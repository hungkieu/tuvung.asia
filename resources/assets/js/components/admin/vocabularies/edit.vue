<template>
  <div>
    <div class="sosd_nav">
    <div class="uk-container">
      <router-link to="/">Trang chủ</router-link> <span uk-icon="icon: chevron-right; "></span>
      <router-link to="/vocabularies">Từ vựng</router-link> <span uk-icon="icon: chevron-right; "></span>
      <h3>Sửa từ vựng</h3>
      <hr>
    </div>
  </div>
    <div class="uk-container">
    <div class="uk-flex">
      <div class="uk-text-left uk-margin-right">
        <button @click="back" class="uk-button uk-button-primary sosd-color-white">
          <span uk-icon="icon: arrow-left;"></span> Quay lại
        </button>
      </div>
    </div>
    <div class="sosd-background-white sosd-box-shadow uk-padding sosd-no-margin" uk-grid>
      <div class="uk-width-1-3">
      <h3>
        Sửa từ vựng
      </h3>
      <hr>
        <form id="form_create_vocab" class="uk-form-stacked">
          <input type="hidden" name="_token" :value="csrf_token">
          <input type="hidden" v-model="form.parent_id" name="parent_id">
          <div>
            <label class="uk-form-label">Tiếng Anh</label>
            <div class="uk-form-controls">
              <input class="uk-input" v-model="form.en" type="text" name="en">
            </div>
          </div>

          <div>
            <label class="uk-form-label">Tiếng Việt</label>
            <div class="uk-form-controls">
              <input class="uk-input" v-model="form.vi" type="text" name="vi">
            </div>
          </div>

          <div>
            <label class="uk-form-label">Loại từ</label>
            <div class="uk-form-controls uk-column-1-3">
               <label v-for="(t, i) in type"> 
               
              <input :value="t.value" class="uk-checkbox" v-model="form.type" type="checkbox">
              {{t.name}}
            </label>
            </div>
          </div>

          <div>
            <label class="uk-form-label">Hình ảnh</label>
            <div>
              <input type="file" id="file" name="image" style="display: none" @change="preview_image">
              <label for="file" class="preview_image" v-if="preview">
                <img :src="preview_image_vl" />
                <input type="hidden" name="import_image" v-model="import_image">
                <input type="hidden" name="import_image_url" v-model="preview_image_vl">
                <span class="txt-change-image">Thay đổi ảnh</span>
              </label>
              <label for="file" class="preview" v-else="preview">
                Upload hình ảnh
              </label>
            </div>
          </div>

          <div class="uk-margin">
            <button @click="send" class="uk-button uk-button-primary sosd-color-white">Sửa</button>
         </div>
        </form>
      </div>
      <div class="uk-width-2-3">
      <h3>
        Hình ảnh gợi ý
      </h3>
      <hr>

      <div v-if="loading">
        <Loading></Loading>
      </div>

      <div v-if="error">
        <b>Vui lòng thử lại</b>
      </div>

      <div v-if="success">
        <div uk-grid="mansonry: true" v-if="searches.length > 0">
          <div class="sosd_images uk-animation-slide-bottom" v-for="v in searches" @click="select($event, v.image)">
            <img :src="v.image" width="200px" class="">
          </div>
        </div>
        <div v-else>
          <b>Không có hỉnh ảnh phù hợp</b>
        </div>
      </div>
    </div>
    </div>
  </div>
  </div>
</template>

<script>

import Loading from './../../shared/loading';
export default {
  components: {
    Loading: Loading
  },
  data: function() {
    return {
      error: false,
      success: false,
      loading: true,
      import_image: false,
      csrf_token: '',
      preview: true,
      preview_image_vl: '',
      parent_id: 0,
      form: {},
      type: [
        {
          name: 'Danh từ',
          value: '0'
        },
        {
          name: 'Động từ',
          value: '1'
        },
        {
          name: 'Tính từ',
          value: '2'
        },
        {
          name: 'Trạng từ',
          value: '3'
        },
        {
          name: 'Giới từ',
          value: '4'
        },
        {
          name: 'Từ nối',
          value: '5'
        }
      ]
      ,
      vocabulary: {
        en: '',
        vi: '',
        type: [],
        parent_id: 0
      },
      searches: []
    };
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
    }
  },
  mounted() {
    var app = this;
    this.search();
    axios
      .get('/api/v1/vocabularies/' + app.$route.params.id)
      .then(res => {
        app.form = res.data;
         app.form.type = app.form.type.split(',');
        console.log(app.form.type);
        app.preview_image_vl = app.form.image;
      })
      .catch(res => {
        alert('Khong load duoc tu vung');
      });

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
    back() {
      this.$router.go(-1);
    },
    search() {
      var app = this;
      app.loading = true;
      var en = app.vocabulary.en;
      var url = '/api/v1/vocabularies/search/all';
      if (en != '') url = '/api/v1/vocabularies/search/' + en;
      axios
        .get(url)
        .then(res => {
          setTimeout(function() {
            app.searches = res.data;
            app.success = true;
          }, 500);
        })
        .catch(res => {
          setTimeout(function() {
            app.error = true;
          }, 500);
        });
    },       

    send(e) {
      var app = this;
      e.preventDefault();
      var f = document.getElementById('form_create_vocab');
      var formData = new FormData(f);
      axios
        .post('/admin/vocabularies/' + app.$route.params.id + '/edit', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(function(res) {
          app.$router.push('/admin/vocabularies');
          f.reset();
        })
        .catch(function(res) {
          alert('Sua khong thanh cong, vui long thu lai');
        });
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
        this.import_image = false;
      }
    },
    select(e, url) {
      this.preview = true;
      this.preview_image_vl = url;
      this.import_image = true;
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
