<template>
  <div>
    <div class="sosd_nav">
      <div class="uk-container">
        <router-link to="/">Trang chủ</router-link> <span uk-icon="icon: chevron-right; "></span>
        <router-link to="/vocabularies">Từ vựng</router-link> <span uk-icon="icon: chevron-right; "></span>
        <span v-if="vocabulary"><router-link v-if="vocabulary.id" :to="{name: 'showVocab', params: {id: vocabulary.id}}">{{ vocabulary.en }}</router-link> <span uk-icon="icon: chevron-right; "></span></span>
        <span>Sửa từ vựng</span>
      </div>
    </div>
    <div class="uk-container">
    <div class="uk-margin-top" uk-grid>
      <div class="uk-width-1-3">
      <h3>
        Sửa từ vựng
      </h3>
      <hr>
      <form id="form_create_vocab" class="uk-form-stacked">
        <input type="hidden" name="_token" :value="csrf_token">
        <input type="hidden" v-model="vocabulary.parent_id" name="parent_id">
        <div>
          <label class="uk-form-label bold">Tiếng Anh <span v-if="!validate.en">( <i class="uk-text-meta uk-text-warning">* Không được để trống </i> )</span></label>
          <div class="uk-form-controls">
            <input class="uk-input" @change="search" v-model="vocabulary.en" type="text" name="en" required id="en" tabindex="1">
          </div>
        </div>

        <div>
          <label class="uk-form-label bold">Tiếng Việt <span v-if="!validate.vi">( <i class="uk-text-meta uk-text-warning">* Không được để trống </i> )</span></label>
          <div class="uk-form-controls">
            <input class="uk-input" type="text" name="vi" v-model="vocabulary.vi" tabindex="2">
          </div>
        </div>

        <div>
          <label class="uk-form-label bold">Loại từ <span v-if="!validate.type">( <i class="uk-text-meta uk-text-warning">* Bạn chưa chọn loại từ</i> )</span></label>
          <div class="uk-form-controls uk-column-1-3" >
            <label class="uk-form-label" v-for="t in type">
              <input :value="t.value" class="uk-checkbox" v-model="vocabulary.type" type="checkbox" name="type[]">
              {{t.name}}
            </label>
          </div>
        </div>
        <div>
          <label class="uk-form-label bold">Hình ảnh</label>
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

        <div>
          <SuggestImage :q='vocabulary.en' @selectImage='select($event)'></SuggestImage>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import SuggestImage from './SuggestImage';
export default {
  components: {
    SuggestImage,
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
      validate: {
        en: true,
        vi: true,
        type: true,
      },
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
        app.vocabulary = res.data;
        app.vocabulary.type = app.vocabulary.type.split(',');
        app.preview_image_vl = app.vocabulary.image;
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
    validated() {
      if(this.vocabulary.en.trim().length == 0)
        this.validate.en = false;
      else
        this.validate.en = true;
      if(this.vocabulary.vi.trim().length == 0)
        this.validate.vi = false;
      else
        this.validate.vi = true;
      if(this.vocabulary.type.length == 0)
        this.validate.type = false;
      else
        this.validate.type = true;
      return Object.values(this.validate).every(val => val == true);
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
      if (app.validated()) {
        axios
        .post('/vocabularies/' + app.$route.params.id + '/edit', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(function(res) {
          flash('Sửa thành công', 'success');
          if (app.$route.params.id) app.$router.push('/vocabularies/' + app.$route.params.id);
          else app.$router.push('/vocabularies');
          f.reset();
        })
        .catch(function(res) {
          alert('Sua khong thanh cong, vui long thu lai');
        });
      } else {
        flash('Bạn chưa nhập đúng trường dữ liệu', 'error');
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
    },
    select(url) {
      this.preview = true;
      this.preview_image_vl = url;
      this.import_image = true;
    }
  }
};
</script>

<style lang="scss" scoped>
.bold {
  font-weight: bold
}
.sosd_nav {
  box-sizing: border-box;
  background: rgb(247, 247, 247);
  border-bottom: 1px solid rgb(233, 233, 233);
  width: 100%;
  height: 50px;
  line-height: 50px;
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
