<template>
  <div class="pb-5">
    <div v-if="loading">
      <Loading></Loading>
    </div>

    <div v-if="error">
      <b>Vui lòng thử lại</b>
    </div>

    <div v-if="success">
      <div class="sosd_nav">
        <div class="uk-container">
          <router-link to="/">Trang chủ</router-link> <span uk-icon="icon: chevron-right; "></span>
          <router-link to="/vocabularies">Từ vựng của bạn</router-link> <span uk-icon="icon: chevron-right; "></span>
          <span v-if="vocabulary">{{ vocabulary.en }}</span>
        </div>
      </div>

      <div class="sosd_background" v-bind:style="{background: bgR}">
        <div class="sosd_card">
          <div class="sosd_image">
            <div v-if="vocabulary.image">
              <img :src="vocabulary.image" alt="image">
            </div>
            <div v-else>
              <p class="char">{{ vocabulary.en[0] }}</p>
            </div>
          </div>
          <div class="body" uk-grid>
            <div>
              <p><h4>{{ vocabulary.en }}</h4></p>
              <p><span>{{ vocabulary.vi }}</span></p>
              <p><i>{{ type }}</i></p>
            </div>
            <div class="uk-width-expand tool uk-inline">
              <div class="icon" uk-tooltip="Nghe" @click="speach(vocabulary.en)">
                <i class="fa fa-volume-up" aria-hidden="true"></i>
              </div>

              <div class="icon" uk-tooltip="Thêm từ liên kết ">
                <router-link :to="{name: 'newChildVocab', params: { id: vocabulary.id }}" >
                  <i class="fa fa-plus" aria-hidden="true"></i>
                </router-link>
              </div>

              <div class="icon" uk-tooltip="Sửa">
                <router-link :to="{name: 'editVocab', params: { id: vocabulary.id }}" >
                  <i class="fa fa-pencil" aria-hidden="true"></i>
                </router-link>
              </div>

              <div class="icon" uk-tooltip="Xóa" @click="deleteVocab(vocabulary.id)">
                <i class="fa fa-trash" aria-hidden="true"></i>
              </div>

              <span v-if="vocabulary.parent_id != 0">
                <div class="icon" uk-tooltip="Cha" uk-toggle="target: #m_tool">
                  <router-link v-if="vocabulary.parent_id" :to="{name: 'showVocab', params: {id: vocabulary.parent_id}}">
                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                  </router-link>
                </div>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="sosd_background_af"></div>
      <div v-if="pedigree.length == 0">
        <div class="uk-margin-top text-center">
          <b>Từ này chưa có từ liên kết đến, <router-link :to="{name: 'newChildVocab', params: { id: vocabulary.id }}" >Thêm ngay</router-link></b>
        </div>
      </div>
      <div class="uk-container" v-else>
        <div class="sosd_menu">
          <ul>
              <li @click="grid = true" :class="{active: grid}"><span uk-icon="grid"></span> Dạng lưới</li>
              <li @click="map = true" :class="{active: map}"><span uk-icon="git-branch"></span> Dạng bản đồ</li>
          </ul>
        </div>
        <div class="sosd_vocabularies uk-padding-small uk-child-width-1-5" uk-grid="masonry: true;" v-if="grid">
          <div v-for="v in pedigree">
            <router-link :to="{ name: 'showVocab', params: {id: v.id} }" class="vocab uk-card uk-card-default" uk-tooltip="Xem">
              <div class="uk-card-media-top">
                <img :src="v.image" alt="">
              </div>
              <div class="uk-card-body">
                <div>
                  <h3 class="uk-card-title">{{ v.en }}</h3>
                  <p>{{ v.vi }}</p>
                </div>
              </div>
            </router-link>
          </div>
        </div>
        <div v-show="map">
          <div id="map"></div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</template>

<script src="">
import go from 'gojs';
import Loading from './../shared/loading';
export default {
  components: {
    Loading: Loading
  },
  data: function() {
    return {
      error: false,
      success: false,
      loading: true,
      grid: true,
      map: false,
      vocabulary: {},
      pedigree: [],
      user: {},
      bg: [
        "url('/svg/showVocab/bg1.svg')",
        "url('/svg/showVocab/bg2.svg')",
        "url('/svg/showVocab/bg3.svg')",
        "url('/svg/showVocab/bg4.svg')",
        "url('/svg/showVocab/bg5.svg')"
      ]
    };
  },
  computed: {
    bgR() {
      return this.bg[Math.round(Math.random() * 4)];
    },
    type() {
      let types = ['Danh từ', 'Động từ', 'Tính từ', 'Trạng từ', 'Giới từ', 'Từ nối'];
      return this.vocabulary.type
        .split(',')
        .map(v => {
          return types[v];
        })
        .join(',');
    },
  },
  watch: {
    grid() {
      if (this.grid) this.map = false;
    },
    map() {
      if (this.map) {
        this.grid = false;
        this.init_map();
      }
    },
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
    this.user = Laravel.user;
    this.get_vocabularies();
  },
  updated() {},
  methods: {
    get_vocabularies() {
      var app = this;
      $.ajax({
        url: '/api/v1/vocabularies/' + app.$route.params.id + '/pedigree',
        method: 'get'
      })
        .done(res => {
          app.vocabulary = res.vocabulary;
          app.pedigree = res.vocabularies;
          setTimeout(function() {
            app.success = true;
          }, 500);
        })
        .fail(res => {
          setTimeout(function() {
            app.error = true;
          }, 500);
        });
    },

    init_map() {
      var app = this;
      var make = go.GraphObject.make;
      var diagram = make(go.Diagram, 'map', {
        initialContentAlignment: go.Spot.Center,
        'undoManager.isEnabled': true,
        layout: make(go.TreeLayout, { angle: 90, layerSpacing: 35 })
      });
      diagram.nodeTemplate = make(
        go.Node,
        'Horizontal',
        { background: '#03B1E8' },
        make(
          go.Picture,
          { margin: 10, width: 50, height: 50, background: '#03B1E8' },
          new go.Binding('source')
        ),
        make(
          go.TextBlock,
          { margin: 12, stroke: 'white', font: 'bold 16px Roboto' },
          new go.Binding('text', 'name')
        ),
        {
          doubleClick: function(e, node) {
            app.$router.push({ name: 'showVocab', params: { id: node.$d.key } });
          }
        }
      );
      diagram.linkTemplate = make(
        go.Link,
        { routing: go.Link.Orthogonal, corner: 5 },
        make(go.Shape, { strokeWidth: 1, stroke: '#333' })
      );
      var model = make(go.TreeModel);
      let array = this.pedigree.concat(this.vocabulary);
      model.nodeDataArray = array.map(v => {
        return {
          key: v.id,
          parent: v.parent_id,
          name: v.en,
          source: !!v.image ? v.image : ''
        };
      });
      diagram.model = model;
    },

    speach(en) {
      responsiveVoice.speak(en);
    },

    deleteVocab(_id) {
      var app = this;
      $.ajax({
        url: '/vocabularies',
        data: {
          _token: Laravel.csrf_token,
          id: _id
        },
        method: 'delete',
      })
      .done(res => {
        if(app.vocabulary.parent_id != 0) {
          app.$router.push({name: 'showVocab', params: { id: app.vocabulary.parent_id }});
        } else {
          app.$router.push({name: 'indexVocab'});
        }
        flash(res, 'success');
      })
      .fail(res => {
        flash(res.responseText, 'error');
      })
    }
  }
};
</script>

<style lang="scss" scoped>
.sosd_nav {
  box-sizing: border-box;
  background: rgb(247, 247, 247);
  border-bottom: 1px solid rgb(233, 233, 233);
  width: 100%;
  height: 50px;
  line-height: 50px;
}
.sosd_background {
  box-sizing: border-box;
  background-repeat: no-repeat;
  background-size: cover;
  width: 100%;
  height: 200px;
  position: relative;
  display: flex;
  justify-content: center;
  top: 0;
  .sosd_card {
    position: absolute;
    top: 60%;
    box-sizing: border-box;
    width: 50%;
    height: 150px;
    background: white;
    box-shadow: 0 0px 1px 1px rgba(33, 33, 33, 0.2);
    .sosd_image {
      box-sizing: border-box;
      float: left;
      img {
        width: 150px;
        height: 150px;
        object-fit: cover;
      }
      .char {
        color: white;
        width: 150px;
        height: 150px;
        box-sizing: border-box;
        line-height: 150px;
        text-align: center;
        background: #f38c81;
        font-size: 36px;
        text-transform: uppercase;
      }
    }
    .body {
      .tool {
        display: flex;
        justify-content: flex-end;
        .icon {
          display: flex;
          width: 32px;
          height: 32px;
          margin-top: 5px;
          margin-right: 10px;
          justify-content: center;
          align-items: center;
          background: white;
          border: none;
          outline: none;
          border-radius: 50%;
          cursor: pointer;
          color: #333;
          &:hover {
            background: rgb(233, 233, 233);
          }
          a {
            color: #333;
          }
        }
      }
    }
  }
}
.sosd_background_af {
  width: 100%;
  height: 120px;
  background: rgb(250, 250, 250);
  border-top: 1px solid rgb(233, 233, 233);
  border-bottom: 1px solid rgb(233, 233, 233);
}
.sosd_dialog {
  padding: 0;
  width: auto;
  ul {
    margin: 0;
    padding: 0;
    list-style: none;
    li {
      a {
        text-decoration: none;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 200px;
        height: 50px;
        color: #333333;
        &:hover {
          background: #03b1e8;
          color: white;
        }
      }
    }
  }
}
.sosd_vocabularies {
  .vocab {
    position: relative;
    display: inline-block;
    text-decoration: none;
    .uk-card-body {
      padding: 10px 30px;
      h3,
      p {
        margin: 8px 0;
        padding: 0;
      }
    }
    img {
      width: 100%;
    }
  }
}
.sosd_menu {
  ul {
    list-style: none;
    display: flex;
    justify-content: center;
    margin-top: 10px;
    li {
      box-sizing: border-box;
      display: inline-block;
      margin-right: 15px;
      padding: 10px;
      &.active, &:hover {
        background: #03b1e8;
        color: white;
      }
    }
  }
}
#map {
  width: 100%;
  min-height: 500px;
  background: rgb(247, 247, 247);
}
</style>
