<template>
  <div>
    <div>
      <div class="uk-container">
        <div class="image_cat">
          <img src="/images/fav.png" alt="">
        </div>
        <div v-if="p_vocabularies.length >= 5">

          <div class="main text-center">
            <div>

            </div>
            <div >
              Bạn có {{ p_vocabularies.length }} từ cần ôn tập
            </div>
            <div class="mt-2">
              <button class="uk-button uk-button-primary sosd-btn" @click="start">Ôn tập</button>
            </div>
          </div>

          <div class="exam" v-if="inprogress">
            <div class="head">
              <div class="start">huong dan</div>
              <div class="center">
                <progress class="uk-progress" :value="quest_correct.length" :max="exam.questions.length"></progress>
              </div>
              <div class="end">
                <span uk-icon="close" @click="stop"></span>
              </div>
            </div>
            <div class="content">
              <div class="quest">
                <div v-for="(quest, index) in exam.questions">
                  <div class="body" v-show="index == exam.step">
                    <div class="image" v-if="quest.correct_answer.image != null">
                      <img :src="quest.correct_answer.image" alt="" height="250px">
                    </div>
                    <div class="question">
                      Từ <b>{{ quest.correct_answer.vi }}</b> trong tiếng anh là?
                    </div>
                    <div class="choices uk-child-width-1-2" uk-grid="first-column:; margin:;">
                      <div v-for="(choice, index2) in quest.choices">
                        <button :class="Object.assign(choice.class, {keytip: true})" @click="answer(index, choice.id)">
                          {{ choice.en }}
                          <span>{{ index2 + 1 }}</span>
                        </button>
                      </div>
                    </div>
                    <div class="foot" v-if="quest.answer">
                      <div class="wrap"></div>
                      <div class="foot_cont" uk-grid>
                        <div class="message uk-width-2-3">
                          <div class="success" v-if="quest.correct">
                            <h3><i class="fa fa-check-circle-o" aria-hidden="true"></i> Chính xác</h3>
                          </div>
                          <div class="error" v-else>
                            <h3><i class="fa fa-times-circle-o" aria-hidden="true"></i> Không chính xác</h3>
                          </div>
                        </div>
                        <div class="next uk-width-1-3">
                          <button @click="next_step" :class="{ success: quest.correct, error: !quest.correct }">
                            Tiếp theo
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-if="exam.step == 999 ">
                  <div class="congratulation">
                    <h1>Tuyệt vời</h1>
                    Bạn đã hoành thành ôn luyện {{ exam.questions.length }} từ
                    <button class="btn-co" @click="stop">
                      Kết thúc
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else class="text-center">
          <div>Không có từ nào cần ôn tập</div>
          <div class="mt-2">
            <router-link to="/">
              <button class="uk-button sosd-btn uk-button-primary">Trang chủ</button>
            </router-link>
          </div>
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
        inprogress: false,
        exam: {
          questions: [],
          step: 0,
        },
        user: {},
        vocabularies: [],
        key: 0,
        watch_key: true,
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
      },

      quest_correct() {
        return this.exam.questions.filter(e => e.correct);
      }
    },
    watch: {
      key() {
        let quest = this.exam.questions[this.exam.step];
        if(this.watch_key)
          if([1, 2, 3, 4].includes(+this.key) && quest.answer == false)
            this.answer(this.exam.step, quest.choices[this.key - 1].id)
          if (this.key == "Enter" && quest.answer)
            this.next_step()
        this.watch_key = false;
        this.key = 0;
      }
    },
    methods: {
      keyboard(o) {
        var app = this;
        if(o == true)
          $(window).on('keypress', function(event) {
            app.watch_key = true;
            console.log(event);
            app.key = event.key;
          })
        else
          $(window).off('keypress')
      },

      get_vocabularies() {
        var app = this;
        $.ajax({
          url: '/api/v1/users/' + app.user.id + '/vocabularies',
          method: 'get'
        })
        .done(res => {
          app.vocabularies = res;
        })
        .fail(res => {
          flash('Lỗi tải dữ liệu', 'error');
        });
      },

      start() {
        this.inprogress = true;
        this.keyboard(true);
        var vocabs = this.p_vocabularies.slice(0, 10);
        if(vocabs.length < 5) { return; }
        var questions = vocabs.map(val => {
          var correct_answer = val;
          correct_answer = Object.assign({class: { choice: true, success: false, error: false }}, correct_answer)
          var choices = [];
          var arr = [];
          while(arr.length < 3) {
            var randomNumber = Math.floor(Math.random() * vocabs.length);
            if(vocabs[randomNumber].id == correct_answer.id) continue;
            if(arr.indexOf(randomNumber) > -1) continue;
            var vocab = Object.assign({class: { choice: true, success: false, error: false }}, vocabs[randomNumber])
            choices.push(vocab);
            arr[arr.length] = randomNumber;
          }
          choices = this.shuffle(choices.concat(correct_answer));
          return {
            correct_answer: correct_answer,
            choices: choices,
            answer: false,
            correct: false,
          }
        });

        this.exam.questions = questions;
      },

      stop() {
        this.loading = true;
        this.get_vocabularies();
        this.exam.step = 0;
        this.inprogress = false;
        this.keyboard(false);
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

      answer(quest_index, choice_id) {
        $('.content').animate({scrollTop: $('.content').height()}, 500);

        var quest = this.exam.questions[quest_index];
        quest.choices.forEach(choice => {
          if (quest.correct_answer.id == choice.id) {
            choice.class.success = true;
          } else if (choice_id == choice.id)  {
            choice.class.error = true;
          }
        })
        if(quest.correct_answer.id == choice_id) {
          quest.correct = true;
          axios.post('/vocabularies/practice', {
            id: choice_id
          })
          .then(res => {
            console.log(res.data);
          })
          .catch(res => {
            console.log(res.data);
          })
        }
        quest.answer = true;
      },

      next_step() {
        let index = this.exam.step;
        let quest = this.exam.questions[index];
        if(quest.correct == false) {
          quest.answer = false;
          quest.choices.forEach((choice) => {
            choice.class.error = false;
            choice.class.success = false;
          })
          var length = this.exam.questions.length;
          for (let i = index; i < length; i++) {
            if(this.exam && !this.exam.questions[i + 1]) break;
              this.exam.questions.splice(i, 1, this.exam.questions[i + 1])
          }
          this.exam.questions.splice(length - 1, 1, quest);
        } else {
          this.exam.step += 1;
          if(this.exam.step >= this.exam.questions.length) {
            this.exam.step = 999;
          }
        }
      }
    }
  };
</script>

<style lang="scss" scoped>
.image_cat {
  text-align: center;
  margin: 20px;
  img {
    height: 250px;
  }
}

.sosd-btn {
  border-radius: 15px;
  &:hover {
    box-shadow: 0px 0px 10px 1px rgba(30, 135, 240, 0.8);
  }
}

.keytip {
  position: relative;
  span {
    position: absolute;
    bottom: -5px;
    right: -5px;
    color: #899194;
    background: white;
    border: 1px solid rgb(233, 233, 233);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    border-radius: 5px;
    font-size: 0.7em;
  }
}

.exam {
  width: 100vw;
  height: 100vh;
  display: grid;
  grid-template-rows: 50px auto;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background: rgb(241, 244, 248);
  overflow: hidden;
  .head {
    box-sizing: border-box;
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
    box-sizing: content-box;
    padding-right: 17px;
    width: 100%;
    display: flex;
    justify-content: center;
    max-height: 100%;
    min-height: 0;
    min-width: 0;
    overflow-y: scroll;
    .quest {
      width: 50%;
      .body {
        .image {
          margin: 20px 0px 20px 0px;
          text-align: center;
          img {
            height: 250px;
          }
        }
        .question {
          b {
            color: rgb(0, 121, 243);
          }
        }
        .choices {
          div {
            margin-top: 40px;
            .choice {
              outline: none;
              border: none;
              cursor: pointer;
              width: 75%;
              padding: 15px 0px;
              border-radius: 15px;
              background: white;
              &:hover {
                box-shadow: 0px 1px 3px 0px rgba(33, 33, 33, 0.3);
              }

            }

            .success {
              animation: scale 0.3s linear both;
              background: rgb(128, 223, 133);
              color: white;
            }

            .error {
              animation: shake 0.5s linear both;
              background: rgb(255, 38, 104);
              color: white;
            }
          }
        }
        padding-bottom: 100px;
      }
    }
  }

  .foot {
    width: 100vw;
    height: 100vh;
    position: fixed;
    z-index: 2;
    top: 50px;
    left: 0;
    display: grid;
    grid-template-rows: auto 75px 50px;
    wrap: {
      width: 100%;
      background: white;
      opacity: 0.1;
    }
    .foot_cont {
      background: white;
      display: flex;
      align-items: center;
      opacity: 0.9;
      padding: 0 50px;
      .next {
        text-align: right;
        button {
          cursor: pointer;
          border: none;
          outline: none;
          border-radius: 15px;
          padding: 5px 15px;
        }
        button.success {
          background: rgb(128, 223, 133);
          color: white;
        }
        button.error {
          background: rgb(255, 38, 104);
          color: white;
        }
      }

      .success {
        animation: scale 0.3s linear both;
        color: rgb(128, 223, 133);
      }

      .error {
        animation: shake 0.3s linear both;
        color: rgb(255, 38, 104);
      }
    }
  }

  .congratulation {
    animation: scale 0.8s ease both;
    display: flex;
    align-items: center;
    flex-direction: column;
    margin-top: 50px;
    line-height: 50px;
    h1 {
      color: rgb(128, 223, 133);
    }
    .btn-co {
      cursor: pointer;
      outline: none;
      border: none;
      background: rgb(128, 223, 133);
      color: white;
      padding: 5px 40px;
      border-radius: 50px;
    }
  }

  @keyframes scale {
    0% { transform: scale(0.9, 0.9) };

    40% { transform: scale(1.1, 1.1) };

    100% { transform: scale(1.0, 1.0) }
  }

  @keyframes shake {
    10%, 90% {
      transform: translate3d(-1px, 0, 0);
    }

    20%, 80% {
      transform: translate3d(2px, 0, 0);
    }

    30%, 50%, 70% {
      transform: translate3d(-4px, 0, 0);
    }

    40%, 60% {
      transform: translate3d(4px, 0, 0);
    }
  }

}
</style>
