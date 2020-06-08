<template>
  <section class="home-container home"><!-- page-container -->
    <section class="banner">
      <article class="seo">
        阿蓮區天聖宮昨舉行入火安座大典，總統蔡英文應邀主持盛典表示，政府致力於社會照顧，以政府力量來照顧更多人，但即使政府再努力，也不一定做得完整，因此需要社會大眾一起來幫忙，讓更多弱勢族群和老人家受到更好的照顧。
        企業家徐清榮董事長和一群虔誠信眾，在阿蓮區大崗山下合力興建天聖宮，主祀天上聖母媽祖，並熱心公益，時時主動關懷弱勢族群、老人家，結合警力發送民生物資，讓更多人受到照顧。
        天聖宮昨舉行入火安座大典，總統蔡英文、立法院長蘇嘉全、總統府秘書長陳菊和大甲鎮瀾宮董事長顏清標等人應邀觀禮，蔡總統除向天聖宮媽祖上香祈求風調雨順、國泰民安，致贈「澤惠生民」匾額給廟方，離去前並應歌仔戲團和舞團成員要求合影，展現親民的一面。
      </article>
    </section>
    <div class="logo"></div>
    <!-- <img class="logo" src="/../images/title@2x.png" alt="高雄阿蓮天聖宮官方網站" /> -->
    <section class="news">
      <article class="card-wrap">
        <news-card v-for="item in newsCards" :key="item.id" :imgurl="item.img" :title="item.title" :desc="item.desc" :time="item.release_time" :id="item.id"></news-card>
      </article>
      <!-- <div class="search-wrap">
                <el-input placeholder="活動查詢" v-model="newsSearch">
                    <i slot="suffix" class="el-input__icon el-icon-search" @click="onSearchNews"></i>
                </el-input>
            </div> -->
      <div class="btn-wrap">
        <router-link to="/news" class="more-btn">更多活動新知</router-link>
      </div>
    </section>

    <div class="about-bg-img bg-img"></div>
    <div class="about block">
      <h2 class="title">高雄阿蓮天聖宮</h2>
      <div class="coming-soon"></div>
      <article class="seo">
        顯宮與鹿耳兩里居民，素來信仰媽祖、崇拜鄭成功，以高雄阿蓮天聖宮為宗教、文化、政治、社教活動中心；民風淳樸、堅毅而團結，與全國各地一千餘尊媽祖神明結為「媽祖金蘭姊妹會」，是台灣最重要的媽祖信仰圈之一，每年至高雄阿蓮天聖宮朝聖的香客絡繹不絕。
      </article>
      <!-- <div class="desc">顯宮與鹿耳兩里居民，素來信仰媽祖、崇拜鄭成功，以高雄阿蓮天聖宮為宗教、文化、政治、社教活動中心；民風淳樸、堅毅而團結，與全國各地一千餘尊媽祖神明結為「媽祖金蘭姊妹會」，是台灣最重要的媽祖信仰圈之一，每年至高雄阿蓮天聖宮朝聖的香客絡繹不絕。</div>
            <div class="btn-wrap">
                <div class="more-btn" @click="onRedirect('about')">詳細介紹</div>
            </div> -->
    </div>

    <section class="media block">
      <h2 class="title" v-if="!isPlaying"><p class="seo">高雄天聖宮的</p>活動影片</h2>
      <div class="black-mask" v-if="!isPlaying"></div>
      <youtube :video-id="videoId" ref="youtube" @playing="playing" class="youtube-player"></youtube>
      <div class="start-btn" @click="playVideo" v-if="!isPlaying"><div class="right-icon"></div></div>
    </section>

    <div class="activities-bg-img bg-img"></div>
    <section class="activities block">
      <h2 class="title"><p class="seo">高雄阿蓮天聖宮的</p>活動花絮</h2>
      <div class="activities-list">
        <div class="activities-item" v-for="(item, index) in activities" :key="index">
          <el-image :src="item" :preview-src-list="activities" :alt="'高雄阿蓮天聖宮-徐家莊的香客們，近期聚集於此地增添香火'"> </el-image>
        </div>
      </div>
      <div class="btn-wrap">
        <router-link to="/activities" class="more-btn">更多活動花絮</router-link>
      </div>
      <article class="seo">
        阿蓮區「高雄天聖宮」日前結合湖內警分局舉辦祈福賑米關懷弱勢活動，由湖內分局長王世芳率副分局長、防治組長陳恒祥、各分駐（派出）所長、佐警、阿蓮志工分隊長曾玉雲、阿蓮守望相助隊李楨雄隊長、志工、義警及民防等協勤民力一同前往；共有湖內區、路竹區、茄萣區、阿蓮區與田寮區各里、鄰之弱勢族群等感恩戶共100戶受惠。
        此次活動亦結合犯罪預防宣導活動，希望藉此提升民眾防範犯罪的知能，高雄市政府警察局王欽源副局長，更親臨現場與參與貴賓同仁寒暄問好，並全程協助各單位領取各項物資，讓活動現場備感熱絡溫馨。
        天聖宮負責人徐清榮董事長表示，本次係藉由天上聖母慈悲孝親報恩祈福法會，提供平安白米與日常用品物資，交由高雄市政府警察局湖內、岡山、旗山、六龜等分局及其他慈善團體，代為發送轄區之獨居老人、中低收之弱勢族群等感恩戶，讓他們仍能感受到社會溫馨的關懷。
        湖內警分局長王世芳表示，多一次慰問，就多一分感動，希望藉此活動，拋磚引玉，激發各角落善心人士之迴響，為需要幫助的民眾，享有溫馨與安全的生活環境。
      </article>
    </section>

    <div class="service-bg-img bg-img"></div>
    <div class="service block">
      <h2 class="title"><p class="seo">高雄阿蓮天聖宮-徐家莊的</p>線上互動</h2>
      <div class="coming-soon"></div>
      <article class="seo">
        阿蓮區天聖宮昨舉行入火安座大典，總統蔡英文應邀主持盛典表示，政府致力於社會照顧，以政府力量來照顧更多人，但即使政府再努力，也不一定做得完整，因此需要社會大眾一起來幫忙，讓更多弱勢族群和老人家受到更好的照顧。
        企業家徐清榮董事長和一群虔誠信眾，在阿蓮區大崗山下合力興建天聖宮，主祀天上聖母媽祖，並熱心公益，時時主動關懷弱勢族群、老人家，結合警力發送民生物資，讓更多人受到照顧。
        天聖宮昨舉行入火安座大典，總統蔡英文、立法院長蘇嘉全、總統府秘書長陳菊和大甲鎮瀾宮董事長顏清標等人應邀觀禮，蔡總統除向天聖宮媽祖上香祈求風調雨順、國泰民安，致贈「澤惠生民」匾額給廟方，離去前並應歌仔戲團和舞團成員要求合影，展現親民的一面。
      </article>
    </div>

    <div class="joinus-bg-img bg-img"></div>
    <div class="joinus block">
      <h2 class="title">徵求義工<p class="seo">高雄天聖宮-徐家莊的</p></h2>
      <div class="coming-soon"></div>
      <article class="seo">
        任務：<br />
        協助工作人員輸入資料、影印、歸檔、整理文件等事項。<br /><br />

        福利：<br />
        (1)免費參與總會相關教育訓練課程。<br />
        (2)享有意外事故保險。<br />
        (3)志工交通費補助。<br /><br />

        高雄阿蓮天聖宮<br />
        地址：822台灣高雄市阿蓮區復安路8-18號<br />
        電話：07 633 3776
      </article>
      <!-- <div class="desc">
                任務：<br>
                協助工作人員輸入資料、影印、歸檔、整理文件等事項。<br><br>

                福利：<br>
                (1)免費參與總會相關教育訓練課程。<br>
                (2)享有意外事故保險。<br>
                (3)志工交通費補助。<br><br>

                高雄阿蓮天聖宮<br>
                地址：822台灣高雄市阿蓮區復安路8-18號<br>
                電話：07 633 3776
            </div> -->
    </div>

    <div class="traffic block">
      <h2 class="title">交通資訊<p class="seo">高雄阿蓮天聖宮-徐家莊的</p></h2>
      <div class="map">
        <iframe
          title="高雄阿蓮天聖宮交通資訊"
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3677.014854389606!2d120.33444241535192!3d22.838939928896515!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x346e0d1b5b65e917%3A0x4b7486f966ac029a!2z6auY6ZuE5aSp6IGW5a6uLeW-kOWutuiOig!5e0!3m2!1szh-TW!2stw!4v1582252673553!5m2!1szh-TW!2stw"
          frameborder="0"
          style="border:0;"
          allowfullscreen=""
        ></iframe>
      </div>
    </div>

    <div class="faq-bg-img bg-img"></div>
    <div class="faq block">
      <h2 class="title">常見問題<p class="seo">高雄天聖宮的</p></h2>
      <div class="coming-soon"></div>
    </div>

    <div class="contact block">
      <h2 class="title"><p class="seo">阿蓮媽天聖宮的</p>聯絡我們</h2>
      <article class="contact-form">
        <h4 class="desc">您可以透過此表單與我們聯繫，<br />我們將會盡快回覆並竭誠地為您服務。</h4>
        <div class="input-inline">
          <label for="name">
            <el-input v-model="contactForm.name" :id="'name'" :label="'name'" placeholder="姓名"></el-input>
          </label>
          <label for="phone">
            <el-input v-model="contactForm.phone" :id="'phone'" :label="'phone'" placeholder="聯繫電話"></el-input>
          </label>
        </div>
        <!-- 老闆說拿掉信箱 -->
        <!-- <el-input v-model="contactForm.email" placeholder="信箱"></el-input> -->
        <label for="theme">
          <el-input v-model="contactForm.title" :id="'theme'" placeholder="主題"></el-input>
        </label>
        <label for="content">
          <el-input type="textarea" :rows="5" :id="'content'" placeholder="內容" v-model="contactForm.content" maxlength="200" show-word-limit resize="none"> </el-input>
        </label>
        <div class="form-submit-btn" @click="dovalidate">送出</div>
      </article>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      newsCards: [],
      newsSearch: '',
      videoId: 'mFvDcSJ8M2w',
      isPlaying: false,
      activities: ['/../images/activities/activities1.jpg', '/../images/activities/activities2.jpg', '/../images/activities/activities3.jpg'],
      contactForm: {
        name: '',
        phone: '',
        email: '',
        title: '',
        content: ''
      }
    }
  },
  mounted() {
    let vm = this
    axios.get(siteUrl + '/home/news').then(function(res) {
      if (res.data.code === '00000') {
        vm.newsCards = res.data.data.list
      }
    })
  },
  computed: {
    player() {
      return this.$refs.youtube.player
    }
  },
  methods: {
    // onSearchNews() {
    //     console.log('search')
    // },
    /* onRedirect(name) {
                this.$router.push('/' + name)
            }, */
    playVideo() {
      this.player.playVideo()
    },
    playing() {
      this.isPlaying = true
    }, //end playing
    dovalidate() {
      if (this.contactForm.name === '') {
        this.errorMsg('請填寫姓名')
      } else if (this.contactForm.phone === '') {
        this.errorMsg('請填聯繫電話')
      } else if (this.contactForm.title === '') {
        this.errorMsg('請填主題')
      } else if (this.contactForm.content === '') {
        this.errorMsg('請填內容')
      } else {
        this.handleSubmit()
      } //end if
    }, //end dovalidate
    handleSubmit() {
      var vm = this
      console.log(vm.contactForm)
      var formData = new FormData()

      formData.append('name', vm.contactForm.name)
      formData.append('phone', vm.contactForm.phone)
      formData.append('subject', vm.contactForm.title)
      formData.append('content', vm.contactForm.content)
      axios
        .post(siteUrl + '/contact/store', formData)
        .then(function(res) {
          let data = res.data
          if (data.code == '00000') {
            vm.$notify.info({
              title: '儲存成功',
              message: '儲存成功'
            })
            vm.clear()
          } else {
            vm.$notify.error({
              title: '儲存失敗',
              message: '系統有誤'
            })
            console.log(data.message)
          }
        })
        .catch(function() {
          vm.$notify.error({
            title: '儲存失敗',
            message: '系統有誤'
          })
        })
    }, //end handleSubmit
    errorMsg(msg, dur = 0) {
      this.$notify.error({
        message: msg,
        offset: 100,
        duration: this.duration + dur
      })
    }, //end errorMsg
    clear() {
      let vm = this
      vm.contactForm = {
        name: '',
        phone: '',
        email: '',
        title: '',
        content: ''
      }
    } //end clear
  }
}
</script>
