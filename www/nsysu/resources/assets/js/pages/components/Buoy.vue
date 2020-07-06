<template>
  <div class="page-container joinus-page">
    <div class="mapbodyAll2">
      
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

          <l-marker :lat-lng="item.local" v-for="item in data" :key="item.id"    @click="updateData(item.station_id)"  >
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















      <div class="map">  </div>
      <div class="plotArea">  
        <div class="windy" id="chartDivWind" > </div>
        <div class="wave" id="chartDivWave" > </div>
      </div>


      <div class="down">
        <div id="chartdiv" class="box"></div>
      </div>
    </div>
  </div>
</template>


<script>

import { JSC } from 'jscharting-vue';

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
        chartData:this.data,
        selectedStationValue:1,
        selectedDuringTime:1,
        dateTimeDuring:[
          {id:1,name:'1個月',value:1},
          {id:2,name:'3個月',value:3},
          {id:3,name:'6個月',value:6},
          {id:4,name:'1年',value:12},
          {id:5,name:'全部',value:0},
        ],
        windData:'',
        waveData:'',
        sstData:'',
      }
      

    },
    methods: {
        amchar(){
          AmCharts.makeChart("chartdiv",
          {
            "export": {
              "enabled": true,
              "libs": { "autoLoad": true},
              
            },
            
            "type": "serial",
            "categoryField": "type",
            "chartCursor": {},
            "graphs": [
              {
                "type": "column",
                "title": "Pizza types",
                "valueField": "sold",
                "fillAlphas": 0.8
              }
            ],
            "dataProvider": [
              { "type": "Margherita", "sold": 120 },
              { "type": "Funghi", "sold": 82 },
              { "type": "Capricciosa", "sold": 78 },
              { "type": "Quattro Stagioni", "sold": 71 }
            ]
          }
          );
        },
        async renderChartWind(data){
         await JSC.chart('chartDivWind', {
            debug: false,
            type:'radar column',
            animation_duration:1000,
            title:{label_text:'風速玫瑰圖',position:'center'},
            legend:{
              title_label_text:'Wind Speed (in m/s)',
              position:'bottom',
              template:'%icon %name',
              reversed:true 
            },
            annotations:[
              {
                // label:{
                //   text:'Calm: 17%<br>Avg speed: 7.9 mph',
                //   style_fontSize:14
                // },
                position:'inside bottom right'
              }
            ],
            defaultSeries_shape_padding:.02,
            yAxis:{
              defaultTick_label_text:'%value%',
              scale:{				type:'stacked',			},
              alternateGridFill:'none'
            },
            opacity:'10%',
            xAxis:{
              scale:{				range:[0,360],				interval:45			},
              customTicks:[
                {value:360, label_text:'N'},
                {value:45, label_text:'NE'},
                {value:90, label_text:'E'},
                {value:135, label_text:'SE'},
                {value:180, label_text:'S'},
                {value:225, label_text:'SW'},
                {value:270, label_text:'W'},
                {value:315, label_text:'NW'},
              ]
            },
            palette:["#c62828","#ff7043","#fff176","#aed581","#80cbc4","#bbdefb"],
            defaultPoint:{tooltip:'<b>%seriesName</b> %xValue° %yValue%'},
            series:JSC.nest().key('speed').key('angle').rollup('percent').series(data).reverse()
          })
        },
        async renderChartWave(data){
         await JSC.chart('chartDivWave', {
            debug: false,
            type:'radar column',
            animation_duration:1000,
            title:{label_text:'波速玫瑰圖',position:'center'},
            legend:{
              title_label_text:'Wave (in m)',
              position:'bottom',
              template:'%icon %name',
              reversed:true 
            },
            annotations:[
              {
                // label:{
                //   text:'Calm: 17%<br>Avg speed: 7.9 mph',
                //   style_fontSize:14
                // },
                position:'inside bottom right'
              }
            ],
            defaultSeries_shape_padding:.02,
            yAxis:{
              defaultTick_label_text:'%value%',
              scale:{				type:'stacked',			},
              alternateGridFill:'none'
            },
            xAxis:{
              scale:{				range:[0,360],				interval:45			},
              customTicks:[
                {value:360, label_text:'N'},
                {value:45, label_text:'NE'},
                {value:90, label_text:'E'},
                {value:135, label_text:'SE'},
                {value:180, label_text:'S'},
                {value:225, label_text:'SW'},
                {value:270, label_text:'W'},
                {value:315, label_text:'NW'},
              ]
            },
            palette:["#c62828","#ff7043","#fff176","#aed581","#80cbc4","#bbdefb"],
            defaultPoint:{tooltip:'<b>%seriesName</b> %xValue° %yValue%'},
            series:JSC.nest().key('speed').key('angle').rollup('percent').series(data).reverse()
          })
        },
        async getData(id){
          let vm = this
          console.log(id);
          var url1=axios.get(siteUrl + '/api/cwbData/getDetailDataByBuoy/wind'+'?stationId='+id).then(function(res) {
            if (res.data.code === '00000') {
              vm.windData = res.data.data
            } })

          var url2=axios.get(siteUrl + '/api/cwbData/getDetailDataByBuoy/wave'+'?stationId='+id).then(function(res) {
            if (res.data.code === '00000') {
              vm.waveData = res.data.data
            } })
          var url3=axios.get(siteUrl + '/api/cwbData/getDetailDataByBuoy/sst'+'?stationId='+id).then(function(res) {
            if (res.data.code === '00000') {
              vm.sstData = res.data.data
              console.log(vm.sstData);
            } })

          await Promise.all([url1, url2, url3]).then(function(values){
            console.log(values);
            return values
          }).catch(function(err){
            console.log('FK');
            console.log(err);
          })
        },
        getListData(){
          let vm = this
          axios.get(siteUrl + '/api/cwbData/getListInfo'+'/buoy').then(function(res) {
            if (res.data.code === '00000') {
              vm.data = res.data.data
              console.log(vm.data);
            }
          })
        },
        async updateData(id){
          console.log(id);
          await this.getData(id);
          
          await this.renderChartWind(this.windData);
          await this.renderChartWave(this.waveData);
          await this.amcharLine(this.sstData);
        },
        getDetailData(stationId){
          console.log(stationId);
          let vm = this
          vm.selectedStationValue=stationId;
          axios.get(siteUrl + '/api/cwbData/getDetailData'+'/SST'+'?stationId='+stationId+'&time='+vm.selectedDuringTime).then(function(res) {
            if (res.data.code === '00000') {
              vm.chartData = res.data.data;
              
              vm.amcharLine();
              
            }
          })
        },
       amcharLine(data){
          var vm=this;
          
          AmCharts.makeChart("chartdiv",
          {
            "export": {
              "enabled": true,
              "position": "bottom-right",
              "libs": { "autoLoad": true},
              
            },
            "type": "serial",
            "theme": "light",
            "marginTop": 7,
            "dataProvider": data,
            "valueAxes": [{
              "axisAlpha": 0.2,
              "dashLength": 1,
              "position": "left"
            }],
            "backgroundAlpha":0.8,
            "backgroundColor": "#FFFFFF",
            "mouseWheelZoomEnabled": true,
            "graphs": [{
              "id": "g1",
              "balloonText": "[[value]]",
              "bullet": "round",
              "bulletBorderAlpha": 1,
              "bulletColor": "#FFFFFF",
              "hideBulletsCount": 50,
              "title": "red line",
              "valueField": "visits",
              "useLineColorForBulletBorder": true,
              "balloon": {
                "drop": true
              }
            }],
            "chartScrollbar": {
              "autoGridCount": true,
              "graph": "g1",
              "scrollbarHeight": 40
            },
            "chartCursor": {
              "limitToGraph": "g1"
            },
            "dataDateFormat":"YYYY-MM-DD JJ:NN:SS",
            "categoryField": "date",
            "categoryAxis": {
              "parseDates": true,
              "axisColor": "#DADADA",
              "dashLength": 1,
              "minPeriod":"hh",
              "minorGridEnabled": true,
              "dateFormats":	[{"period":"fff","format":"JJ:NN:SS"},{"period":"ss","format":"JJ:NN:SS"},{"period":"mm","format":"JJ:NN"},{"period":"hh","format":"JJ:NN"},{"period":"DD","format":"MMM DD"},{"period":"WW","format":"MMM DD"},{"period":"MM","format":"MMM"},{"period":"YYYY","format":"YYYY"}],
            },
            "listeners": [{
              "event": "rendered",
              "method": function(e) {
                  // set up generic mouse events
                  var sb = e.chart.chartScrollbar.set.node;
                  sb.addEventListener("mousedown", function() {
                    e.chart.mouseIsDown = true;
                  });
                  e.chart.chartDiv.addEventListener("mouseup", function() {
                    e.chart.mouseIsDown = false;
                    // zoomed finished
                    console.log("zoom finished", e.chart.lastZoomed);
                  });
                }

            }, {
              "event": "zoomed",
              "method": function(e) {
                e.chart.lastZoomed = e;
                console.log("ignoring zoomed");
              }
            }]
          });
            

        },
    },
    async mounted() {
      
      await this.getData('C6V27');
      this.getListData('C6V27');
      this.renderChartWind(this.windData);
      this.renderChartWave(this.waveData);
      this.amcharLine(this.sstData);
      
      this.$nextTick(() => {
        // 獲得目前位置
        navigator.geolocation.getCurrentPosition(position => {
          const p = position.coords;
          // 將中心點設為目前的位置
          // this.center = [p.latitude, p.longitude];
          // 將目前的位置的標記點彈跳視窗打開
          // this.$refs.location.mapObject.openPopup();
        });
      });
    },

}
</script>

<style>
.columnChart {
    height: 300px;
}
</style>