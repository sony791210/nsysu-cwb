<template>
  <section class="page-container news-page">
    <h2 class="title"><p class="seo">高雄阿蓮天聖宮-徐家莊</p>最新活動</h2>
    <div class="news-list">
      <news-card v-for="item in newsCards" :key="item.id" :imgurl="item.img" :title="item.title" :desc="item.desc" :time="item.release_time" :id="item.id"></news-card>
    </div>
    <article class="seo">
      這裡是媽祖宮廟！ 除了是宗教信仰，和地理位址，都是一個很棒的地方！ 宮廟面山地靈有非常大的正能量！ 百年以上的聖尊大甲媽祖，北港媽祖，旗山媽祖，都在天聖宮暫駕數月，歡迎十方善信大德，蒞臨指導！
    </article>
  </section>
</template>
<script>
export default {
  data() {
    return {
      newsCards: []
    }
  },
  mounted() {
    let vm = this
    axios.get(siteUrl + '/newsList').then(function(res) {
      if (res.data.code === '00000') {
        vm.newsCards = res.data.data.list
      }
    })
  }
}
</script>
