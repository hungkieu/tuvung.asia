<template>
  <div>
    <div v-if="loading">
      <Loading></Loading>
    </div>

    <div v-if="error">
      <b>Vui lòng thử lại</b>
    </div>

    <div v-if="success">
      <div class="uk-container">
        <div v-if="vocabularies.length >= 5">
          Bạn có {{ p_vocabularies.length }} từ cần ôn tập
          <button class="uk-button" @click="start">Ôn tập</button>
          <div class="exam" v-if="inprogress">
            <div class="head">
              <div class="start">huong dan</div>
              <div class="center">
                <progress class="uk-progress" :value="exam.step" :max="exam.questions.length"></progress>
              </div>
              <div class="end">
                <span uk-icon="close" @click="stop"></span>
              </div>
            </div>
            <div class="content">
              <div class="quest">
                <div v-for="(quest, index) in exam.questions">
                  <div class="body" v-if="index == exam.step">
                    <div v-if="quest.correct_answer.image != null">
                      <img :src="quest.correct_answer.image" alt="" height="250px">
                    </div>
                    <div class="question">
                      Từ <b>{{ quest.correct_answer.vi }}</b> trong tiếng anh là?
                    </div>
                    <div class="choices uk-child-width-1-2" uk-grid>
                      <div v-for="choice in quest.choices" @click="answer(quest.correct_answer.id, choice.id)">
                        {{ choice.en }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="foot"></div>
          </div>
        </div>
        <div v-else>
          Bạn cần học tối thiểu 5 từ để sử dụng chức năng này
        </div>
      </div>
    </div>
  </div>
</template>

<script>
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
        inprogress: false,
        exam: {
          questions: [],
          step: 0,
        },
        user: {},
        vocabularies: []
      };
    },
    mounted() {
      this.user = Laravel.user;
      this.get_vocabularies();
    },
    computed: {
      p_vocabularies() {
        return this.vocabularies.filter((v) => {
          var last_practice = v.last_practice
          var three_days_ago = new Date();
          three_days_ago = three_days_ago.setDate(three_days_ago.getDate() - 3);
          return v.last_practice == null || last_practice < three_days_ago;
        })
      }
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
      },
    },
    methods: {
      get_vocabularies() {
        var app = this;
        $.ajax({
          url: '/api/v1/users/' + app.user.id + '/vocabularies',
          method: 'get'
        })
        .done(res => {
          app.vocabularies = res;
          setTimeout(function() {
            app.success = true;
          }, 100);
        })
        .fail(res => {
          setTimeout(function() {
            app.error = true;
          }, 100);
        });
      },

      start() {
        this.inprogress = true;
        var vocabs = this.p_vocabularies.slice(0, 10);
        var questions = vocabs.map(val => {
          var correct_answer = val;
          var choices = [];
          var arr = [];
          while(arr.length < 3) {
            var randomNumber = Math.floor(Math.random() * vocabs.length);
            if(vocabs[randomNumber].id == correct_answer.id) continue;
            if(arr.indexOf(randomNumber) > -1) continue;
            choices.push(vocabs[randomNumber]);
            arr[arr.length] = randomNumber;
          }
          choices = this.shuffle(choices.concat(correct_answer));
          return {
            correct_answer: correct_answer,
            choices: choices,
          }
        });
        this.exam.questions = questions;
      },

      stop() {
        this.inprogress = false;
      },

      shuffle(a) {
        var j, x, i;
        for (i = a.length - 1; i > 0; i--) {
          j = Math.floor(Math.random() * (i + 1));
          x = a[i];
          a[i] = a[j];
          a[j] = x;
        }
        return a;
      },

      answer(c_id, id) {
        if(c_id == id) {
          this.exam.step += 1;
        }
        if(this.exam.step >= this.exam.questions.length) this.stop();
      }
    }
  };
</script>

<style lang="scss" scoped>
.exam {
  width: 100vw;
  height: 100vh;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background: rgb(241, 244, 248);
  .head {
    height: 50px;
    margin: 0 50px;
    display: grid;
    align-items: center;
    grid-template-columns: 1fr 2fr 1fr;
    .center {
      .uk-progress {
        margin: 0;
      }
    }
    .end {
      justify-self: end;
      span {
        cursor: pointer;
      }
    }
  }
  .content {
    display: flex;
    justify-content: center;
    .quest {
      width: 50%;
    }
  }
}
</style>
