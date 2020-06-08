<template>
  <section class="page-container">
    <h2 class="title"><p class="seo">高雄天聖宮-徐家莊的</p>聯絡我們</h2>
    <div class="contact-form">
      <div class="desc">您可以透過此表單與我們聯繫，<br />我們將會盡快回覆並竭誠地為您服務。</div>
      <div class="input-inline">
        <label for="name">
          <el-input v-model="contactForm.name" :id="'name'" placeholder="姓名"></el-input>
        </label>
        <label for="phone">
          <el-input v-model="contactForm.phone" :id="'phone'" placeholder="聯繫電話"></el-input>
        </label>
      </div>
      <!-- <el-input v-model="contactForm.email" placeholder="信箱"></el-input> -->
      <label for="theme">
        <el-input v-model="contactForm.title" :id="'theme'" placeholder="主題"></el-input>
      </label>
      <label for="content">
        <el-input type="textarea" :rows="5" :id="'content'" placeholder="內容" v-model="contactForm.content" maxlength="200" show-word-limit resize="none"> </el-input>
      </label>
      <div class="form-submit-btn" @click="dovalidate">送出</div>
    </div>
  </section>
</template>
<script>
export default {
  data() {
    return {
      contactForm: {
        name: '',
        phone: '',
        email: '',
        title: '',
        content: ''
      }
    }
  },
  methods: {
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
