<template>
  <div>
      Thêm cấu trúc câu mới
      <div class="uk-margin-top">
        <input type="text" v-model="node.text">
        <button @click="createNode" class="uk-button uk-button-primary">
          Tạo nút
        </button>
      </div>

      Thêm từ cấu trúc có sẵn
      <div class="uk-margin-top">
        <input style="width: 500px;" type="text" v-model="structure_available">
        <button @click="addStructureAvailable" class="uk-button uk-button-primary">
          Thêm
        </button>
      </div>

      <div class="uk-margin-top uk-grid-small" uk-grid>
        <div v-for="node in node.nodes" draggable="true" class="sosd-label">
          {{ node }}
        </div>

        <div class="sosd-label" id="trash">
          <span uk-icon="trash"></span>
        </div>
      </div>

      Kéo từ để tạo thành câu:
      <div class="sosd-border" uk-grid>
        <div v-for="(node, index) in structures" :data-index="index" draggable="true" class="sosd-label sosd-node-added">
          {{ node }}
        </div>

        <div>
          <button class="uk-button uk-button-primary" id="boxAdd">+</button>
        </div>
      </div>

      <div class="uk-margin">
        Xem trước: <b>{{ preview_structures }}</b>
      </div>

      <div class="uk-margin">
        <p>Nội dung:</p>
        <p><input type="text" v-model="description" name=""></p>
      </div>

      <div class="uk-margin">
        <button class="uk-button uk-button-primary" @click="addStructure">
          Thêm cấu trúc
        </button>
      </div>

      <div class="uk-margin" v-if="last_structures.length > 0">
        <h3>Các cấu trúc vừa tạo</h3>
        <article v-for="s in last_structures" class="uk-article sosd-background-white">
          <h1 class="uk-article-title">{{ s.structures.join(" + ") }}</h1>
          <p class="uk-article-meta">{{ s.description }}</p>
        </article>
      </div>
  </div>
</template>

<script>
  export default {
    data: function() {
      return {
        node: {
          text: '',
          nodes: ["Danh từ", "to be", "Động từ"]
        },
        structures: [],
        description: '',
        last_structures: [],
        structure_available: ''
      }
    },
    computed: {
      preview_structures() {
        return this.structures.join(" + ");
      }
    },
    methods: {
      addStructureAvailable() {
        var arr = this.structure_available.split(" + ");
        var length = arr.length;
        for(let i = 0; i < length; i++) {
          this.node.nodes.push(arr[i]);
          this.structures.push(arr[i]);
        }
      },

      createNode() {
        this.node.nodes.push(this.node.text);
      },

      addStructure() {
        var app = this;
        app.last_structures.push({
          description: app.description, structures: app.structures.slice()
        })
      }
    },
    mounted() {
      var app = this;
      $('.uk-grid-small').on('dragstart', '.sosd-label', function(e) {
        e.originalEvent.dataTransfer.setData('text', e.target.innerHTML);
      })

      $('.sosd-border').on('dragstart', '.sosd-node-added', function(e) {
        e.originalEvent.dataTransfer.setData('index', $(e.target).data('index'));
      })

      $('.sosd-border').on('dragover', '.sosd-node-added', function(e) {
        e.preventDefault();
      })

      $('.sosd-border').on('dragleave', '.sosd-node-added', function(e) {
        e.preventDefault();
      })

      $('#trash').on('dragover', function(e) {
        e.preventDefault();
      })

      $('#trash').on('drop', function(e) {
        e.preventDefault();
        var index = e.originalEvent.dataTransfer.getData('index');
        if(index) app.structures.splice(index, 1);
        e.originalEvent.dataTransfer.setData('index', null);
      })

      $('.sosd-border').on('drop', '.sosd-node-added', function(e) {
        e.preventDefault();
        var index = e.originalEvent.dataTransfer.getData('index');
        if(index) {
        var this_index = $(this).data('index');
        var swap = app.structures[index];
        app.$set(app.structures, index, app.structures[this_index]);
        app.$set(app.structures, this_index, swap);
        }
        e.originalEvent.dataTransfer.setData('index', null);
      })

      $('#boxAdd').on('dragover', function(e) {
        e.preventDefault();
      })

      $('#boxAdd').on('dragenter', function(e) {
        e.preventDefault();
        this.className += ' transform';
      })

      $('#boxAdd').on('dragleave', function(e) {
        e.preventDefault();
        this.className = 'uk-button uk-button-primary';
      })

      $('#boxAdd').on('drop', function(e) {
        e.preventDefault();
        this.className = 'uk-button uk-button-primary';
        var text = e.originalEvent.dataTransfer.getData('text');
        if(text) app.structures.push(text);
      })
    }
  }
</script>

<style lang="scss" scoped>
  .sosd-label {
    display: inline-block;
    padding: 5px 10px;
    background: white;
    margin: 5px;
  }
  .sosd-border {
    padding: 10px;
    width: 80%;
    margin: 20px auto;
    border: 1px dotted black;
  }
  #boxAdd {
    transition: all ease 1s;
  }
  .transform {
    transform: scale(1.1, 1.1);
  }
</style>
