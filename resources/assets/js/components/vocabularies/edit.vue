<template>
  <div class="sosd-background-white sosd-box-shadow uk-padding sosd-no-margin" uk-grid>
    <div class="uk-width-1-3">
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
            <label>
              <input v-model="form.type" value="Danh từ" class="uk-checkbox" type="checkbox" name="type[]">
              Danh từ
            </label>
            <label>
              <input v-model="form.type" value="Động từ" class="uk-checkbox" type="checkbox" name="type[]">
              Động từ
            </label>
            <label>
              <input v-model="form.type" value="Tính từ" class="uk-checkbox" type="checkbox" name="type[]">
              Tính từ
            </label>
            <label>
              <input v-model="form.type" value="Trạng từ" class="uk-checkbox" type="checkbox" name="type[]">
              Trạng từ
            </label>
            <label>
              <input v-model="form.type" value="Giới từ" class="uk-checkbox" type="checkbox" name="type[]">
              Giới từ
            </label>
            <label>
              <input v-model="form.type" value="Từ nối" class="uk-checkbox" type="checkbox" name="type[]">
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

    <div class="uk-width-1-2">

    </div>
  </div>
</template>

<script>
  export default {
    data: function() {
      return {
        csrf_token: '',
        preview: true,
        preview_image_vl: '',
        parent_id: 0,
        form: {},
      }
    },
    mounted() {
      var app = this;
      axios.get('/api/v1/vocabularies/' + app.$route.params.id)
      .then((res) => {
        app.form = res.data;
        app.form.type = JSON.parse(app.form.type);
        app.preview_image_vl = app.form.image;
      })
      .catch((res) => {
        alert('Khong load duoc tu vung');
      });


      this.csrf_token = Laravel.csrf_token;

      jQuery.extend(jQuery.expr[':'], {
        focusable: function (el, index, selector) {
          return $(el).is('a, button, :input, [tabindex]');
        }
      });

      $(document).on('keypress', 'input,select', function (e) {
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
     send(e) {
        var app = this;
        e.preventDefault();
        var f = document.getElementById('form_create_vocab');
        var formData = new FormData(f);
        axios.post('/vocabularies/' + this.$route.params.id + '/edit', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then(function(res){
          if(app.$route.params.id)
            app.$router.push('/vocabularies/' + app.$route.params.id);
          else
            app.$router.push('/vocabularies');
          f.reset();
        }).catch(function(res){
          alert('Sua khong thanh cong, vui long thu lai');
        });
      },

      preview_image(e) {
        var files = e.target.files;
        if(files && files[0]) {
          var reader = new FileReader();
          var app = this;
          reader.onload = function(e) {
            app.preview_image_vl = e.target.result;
          }
          reader.readAsDataURL(files[0]);
          this.preview = true;
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  .preview {
    width: 150px;
    height: 150px;
    border: 1px dashed rgb(33, 33, 33);
    line-height: 150px;
    text-align: center;
  }
  .preview_image {
    height: 150px;
    width: 100%;
    max-width: 200px;
    min-width: 150px;
  }
</style>
