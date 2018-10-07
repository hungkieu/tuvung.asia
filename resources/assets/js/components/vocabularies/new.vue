<template>
  <div class="sosd-background-white sosd-box-shadow uk-padding sosd-no-margin" uk-grid>
    <div class="uk-width-1-3">
      <form id="form_create_vocab" class="uk-form-stacked">
        <input type="hidden" name="_token" :value="csrf_token">
        <div>
          <label class="uk-form-label">Tiếng Anh</label>
          <div class="uk-form-controls">
            <input class="uk-input" type="text" name="en">
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

    <div class="uk-width-1-2">

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
      }
    },
    mounted() {
      this.csrf_token = Laravel.csrf_token;

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
        axios.post('/vocabularies', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then(function(res){
          app.$router.push('/vocabularies');
          f.reset();
        }).catch(function(res){
          alert('Them khong thanh cong, vui long thu lai');
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
