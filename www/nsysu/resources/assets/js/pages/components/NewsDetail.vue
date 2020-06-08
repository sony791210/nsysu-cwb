<template>
    <section class="page-container news-detail-page">
        <h2 class="title"><p class="seo">高雄天聖宮</p>最新活動</h2>
        <figure class="body" v-if="news.img">
            <div class="img-wrap">
                <!-- <div class="img" :style="{ 'background-image':'url('+ news.img +')' }"></div> -->
                <img class="img" :src="news.img" :alt="`高雄天聖宮${news.title}`">
            </div>
            <figcaption class="info-wrap">
                <h3 class="info-title">
                    {{news.title}}
                </h3>
                <div class="info-desc" v-html="news.desc"></div>
                <div class="info-time">
                    {{news.release_time}}
                </div>
            </figcaption>
            <div class="btn-wrap">
                <router-link to="/news" class="more-btn">回活動列表</router-link>
            </div>
        </figure>
    </section>
</template>
<script>
    export default {
        mounted() {
            let vm = this;
            axios.get(siteUrl + '/newsDetail/'+ this.$route.params.id).then(function(res) {
                vm.news = res.data.data;
            });
        },
        data() {
            return {
                news: {}
            }
        },
        methods: {
            /* onBack() {
                this.$router.push('/news')
            } */
        }
    }
</script>