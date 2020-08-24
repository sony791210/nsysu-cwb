<template>
    <figure class="news-card" @click="onDetail(id)">
        <div class="news-card__header">
            <!-- <div class="img" :style="{ 'background-image':'url('+ imgurl +')' }"></div> -->
            <img class="img" :src="imgurl" :alt="`高雄天聖宮${title}`">
        </div>
        <figcaption class="news-card__body">
            <h3 class="title">
                {{title}}
            </h3>
            <p class="desc">
                {{desc}}
            </p>
            <div class="time">
                {{time}}
            </div>
        </figcaption>
    </figure>
</template>
<script>
    export default {
        props: {
            id: {
                type: Number
            },
            imgurl: {
                type: String
            },
            title: {
                type: String
            },
            desc: {
                type: String
            },
            time: {
                type: String
            }
        },
        methods: {
            onDetail(id) {
                this.$router.push('/news/'+id)
            }
        }
    }
</script>