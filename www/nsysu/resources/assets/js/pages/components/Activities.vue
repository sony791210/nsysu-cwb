<template>
    <section class="page-container activities-page">
        <h2 class="title">
            <p class="seo">阿蓮媽天聖宮-徐家莊的</p>
            活動花絮</h2>
        <div class="body">
            <ul class="tab-wrap">
                <li class="tab-item" :class="{'focus': tabActive === item.name}" v-for="(item, index) in tab" :key="index" @click="onChangeTab(item.name)">{{item.label}}</li>
            </ul>
            <section class="photo-list-wrap" v-if="tabActive === 'photo'">
                <figure class="list-wrap-item" v-for="(item, index) in photoList" :key="'1_'+index">
                    <el-image 
                        :src="item" 
                        :preview-src-list="getSrcList(index)"
                        :alt="`總統蔡英文南下高雄出席天聖宮入火安座大典${index+1}`">
                    </el-image>
                    <!-- <div class="img" :style="{ 'background-image':'url('+ item.img +')' }" @click="onPreview(item.img)"></div> -->
                </figure>
            </section>

            <section class="media-list-wrap" v-if="tabActive === 'media'">
                <div class="list-wrap-item" v-for="(item, index) in mediaList" :key="'2_'+index">
                    <youtube :video-id="item" :ref="'youtube_'+ index" class="youtube-player"></youtube>
                </div>
            </section>
        </div>
    </section>
</template>
<script>
    import ElImageViewer from 'element-ui/packages/image/src/image-viewer'
    export default {
        data() {
            return {
                tabActive: 'photo',
                tab: [
                    {
                        name: 'photo',
                        label: '活動照片'
                    },
                    {
                        name: 'media',
                        label: '活動影片'
                    }
                ],
                photoList: [
                    '/../images/activities/1.jpg',
                    '/../images/activities/2.jpg',
                    '/../images/activities/3.jpg',
                    '/../images/activities/4.jpg',
                    '/../images/activities/5.jpg',
                    '/../images/activities/6.jpg',
                    '/../images/activities/7.jpg',
                    '/../images/activities/8.jpg',
                    '/../images/activities/9.jpg',
                    '/../images/activities/10.jpg',
                    '/../images/activities/11.jpg',
                    '/../images/activities/12.jpg',
                    '/../images/activities/13.jpg',
                    '/../images/activities/14.jpg',
                    '/../images/activities/15.jpg',
                    '/../images/activities/16.jpg',
                    '/../images/activities/17.jpg',
                    '/../images/activities/18.jpg',
                    '/../images/activities/19.JPG',
                    '/../images/activities/20.JPG',
                    '/../images/activities/21.BMP',
                    '/../images/activities/22.BMP',
                ],
                mediaList: [
                    'mFvDcSJ8M2w'
                ]
            }
        },
        methods: {
            onChangeTab(name) {
                this.tabActive = name
            },
            getSrcList(index) {
                return this.photoList.slice(index).concat(this.photoList.slice(0,index))
            }
        }
    }
</script>