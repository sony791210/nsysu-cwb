<template>
  <section>
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
      <ul class="tab-group">
        
        <a href="/" class="tab-group-item">
          <img class="img" src="https://ttpass.tw/dist/client/img/bc7f287.png" alt="132(123)" >
        </a>
        <router-link :to="'/' + item.name" v-for="item in tabs" :key="item.name">
          <li class="tab-group-item">
            {{ item.label }}
            <ul class="link-content">
              <li >123</li>
              <li >234</li>
              <li >1342523</li>
              <li >1325423</li>
            </ul>
          </li>
        </router-link>
      </ul>
      <i class="fas fa-bars navbar-icon" @click="onShowCollapse"></i>
      <h2 class="navbar-title">
        NSYSU WEB
      </h2>
    </nav>
    <router-view></router-view>
    <footer class="footer block">
      <div class="desc">
        <div class="contact">
          <div class="address">地址<br />高雄市鼓山區蓮海路70號</div>
          <div class="phone">電話<br />07 XXX XXXX</div>
        </div>
        <ul class="social">
          <li class="social-icon youtube" @click.prevent="onSocialLink('youtube')"></li>
          <li class="social-icon facebook" @click.prevent="onSocialLink('facebook')"></li>
          <li class="social-icon instagram" @click.prevent="onSocialLink('instagram')"></li>
          <li class="social-icon line" @click.prevent="onSocialLink('line')"></li>
        </ul>
      </div>
      <h2 class="copyright">NSYSU KANGOO 版權所有</h2>
    </footer>
    <transition name="slideDownUp">
      <div class="collapse show" v-if="showCollapse">
        <ul class="list-group">
          <li class="close" @click="onCloseCollapse"><i class="fas fa-times"></i></li>
          <li class="list-group-item" v-for="item in tabs" :key="item.name" @click="onLink(item.name)">
            {{ item.label }}
          </li>
        </ul>
      </div>
    </transition>
    <transition name="fade">
      <div class="scroll-top" v-show="showTop" v-scroll-to="scrollOption"></div>
    </transition>
  </section>
</template>
<script>
export default {
  data() {
    return {
      tabs: [

        {
          label: '高雄阿蓮天聖宮',
          name: 'about'
        },
        {
          label: '活動花絮',
          name: 'activities'
        },
        {
          label: '線上互動',
          name: 'service'
        },
        {
          label: '徵求義工',
          name: 'joinUs'
        },
        {
          label: '交通資訊',
          name: 'traffic'
        },
        {
          label: '常見問題',
          name: 'faq'
        },
        {
          label: '聯絡我們',
          name: 'contact'
        }
      ],
      showCollapse: false,
      showTop: false,
      scrollTimeout: null,
      scrollOption: {
        el: 'body',
        duration: 300,
        easing: 'ease-in-out'
      }
    }
  },
  beforeMount() {
    //window.addEventListener('scroll', this.handleScroll, false);
    window.addEventListener('scroll', this.handleScroll, { capture: false, passive: true })
  },
  mounted() {
    this.onChangeTabs(this.$route.name)
  },
  beforeDestroy() {
    window.removeEventListener('scroll', this.handleScroll, { capture: false, passive: true })
  },
  watch: {
    $route(to, from) {
      this.onChangeTabs(to.name)
    }
  },
  methods: {
    handleScroll() {
      let self = this
      if (!self.scrollTimeout) {
        self.scrollTimeout = setTimeout(function() {
          self.scrollTimeout = null
          self.actualScrollHandler()
        }, 66)
      }
    },
    actualScrollHandler() {
      this.showTop = window.scrollY > 50
    },
    onChangeTabs(name) {
      if (name !== 'home' && this.tabs[0].name !== '') {
        this.tabs.unshift({
          label: '回首頁',
          name: ''
        })
      } else if (name === 'home' && this.tabs[0].name === '') {
        this.tabs.shift({
          label: '回首頁',
          name: ''
        })
      }
    },
    onHome() {
      this.$router.push('/')
    },
    onSocialLink(name) {
      switch (name) {
        case 'youtube':
          break
        case 'facebook':
          window.open('https://www.facebook.com/%E9%AB%98%E9%9B%84%E5%A4%A9%E8%81%96%E5%AE%AE-%E5%BE%90%E5%AE%B6%E8%8E%8A-1285465691591832/', '_blank')
          break
        case 'instagram':
          break
        case 'line':
          break
      }
    },
    onShowCollapse() {
      this.showCollapse ? (this.showCollapse = false) : (this.showCollapse = true)
    },
    onCloseCollapse() {
      this.showCollapse = false
    },
    onLink(name) {
      this.onCloseCollapse()
      this.$router.push('/' + name)
    }
  }
}
</script>
