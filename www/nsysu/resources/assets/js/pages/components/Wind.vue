<template>
  <div class="page-container joinus-page">
    <div class="mapbodyAll">
      
      <l-map
        ref="myMap"
        :zoom="zoom"
        :center="center"
        :options="options"
        style="position:absolute"
        >
        <!-- 載入圖資 -->
        <l-tile-layer :url="url" :attribution="attribution" />
        <!-- 自己所在位置 -->
        <l-marker ref="location" :lat-lng="center">
          <l-popup>
            你的位置
          </l-popup>
        </l-marker>
        <!-- 創建標記點 -->
        <v-marker-cluster ref="clusterRef">
          <!--  -->

          <l-marker :lat-lng="item.local" v-for="item in data" :key="item.id"    @click="getDetailData(item.station_id)"  >
            <!-- 標記點樣式判斷 -->
            <l-icon
              :icon-url="icon.type.black"
              :shadow-url="icon.shadowUrl"
              :icon-size="icon.iconSize"
              :icon-anchor="icon.iconAnchor"
              :popup-anchor="icon.popupAnchor"
              :shadow-size="icon.shadowSize"

            />  
            <!-- 彈出視窗 -->
            <!-- <div><span @click="getData(item.station_id)"></span></div> -->
            <l-popup style="font-size:16px">
              {{ item.name }}
            </l-popup>
          </l-marker>
        </v-marker-cluster>

      </l-map>

    <div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      img: '/../images/joinus_banner.png',
      data: [
        { id: 1,station_id:'a123', name: "夢時代購物中心", local: [22.595153, 120.306923] },
        { id: 2,station_id:'a456', name: "漢神百貨", local: [22.61942, 120.296386] },
        { id: 3,station_id:'a789', name: "漢神巨蛋", local: [22.669603, 120.302288] },
        { id: 4,station_id:'b123', name: "大統百貨", local: [22.630748, 120.318033] }
      ],
      zoom: 7,
      center: [23.6, 120.6],
      url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
      attribution: `© <a href="http://osm.org/copyright">OpenStreetMap</a> contributors`,
      options: {
        zoomControl: false
      },
      icon: {
        type: {
          black:
            "https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-black.png",
          gold:
            "https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png"
        },
        shadowUrl:
          "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
        iconSize: [20, 30],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41],
      },
      chartData:this.generateChartData(),
      selectedStationValue:1,
      selectedDuringTime:1,
      dateTimeDuring:[
        {id:1,name:'1個月',value:1},
        {id:2,name:'3個月',value:3},
        {id:3,name:'6個月',value:6},
        {id:4,name:'1年',value:12},
        {id:5,name:'全部',value:0},
      ]
    }
  },
  methods: {
  
  },
  created() {
    
  },
}
</script>
