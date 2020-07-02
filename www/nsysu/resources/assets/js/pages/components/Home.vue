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


      <div class="up">

      </div>

      <div class="middle">
        <form class='test1'>
          <select name="test1" @click="getDetailDataBySelectStation($event)" v-model="selectedStationValue">
            <option  v-for="item in data" :key="item.id" :value="item.station_id"  > {{ item.name }}</option>
          </select>
        </form>
        <form class='test2'>
          <select name="test2" @click="getDetailDataBySelectTime($event)" v-model="selectedDuringTime">
            <option  v-for="item in dateTimeDuring" :key="item.id" :value="item.value"  > {{ item.name }}</option>
          </select>
        </form>
      </div>

      <div class="down">
        <div id="chartdiv" class="box"></div>
      </div>

    </div>
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
    getListData(){
      let vm = this
      axios.get(siteUrl + '/api/cwbData/getListInfo'+'/SST').then(function(res) {
        if (res.data.code === '00000') {
          vm.data = res.data.data
          console.log(vm.data);
        }
      })
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
    getDetailDataBySelectStation(event){
      console.log(event.target.value);
      let vm = this
      vm.selectedStationValue=event.target.value;
      axios.get(siteUrl + '/api/cwbData/getDetailData'+'/SST'+'?stationId='+vm.selectedStationValue+'&here='+vm.selectedDuringTime).then(function(res) {
        if (res.data.code === '00000') {
          vm.chartData = res.data.data
          vm.amcharLine();
          
        }
      })
    },
    getDetailDataBySelectTime(event){
      console.log(event.target.value);
      let vm = this
      vm.selectedDuringTime=event.target.value;
      axios.get(siteUrl + '/api/cwbData/getDetailData'+'/SST'+'?stationId='+vm.selectedStationValue+'&time='+vm.selectedDuringTime).then(function(res) {
        if (res.data.code === '00000') {
          vm.chartData = res.data.data
          
          vm.amcharLine();
          
        }
      })
    },
    amcharLine(){
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
        "dataProvider": vm.chartData,
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
    getIndicatorImage(color, direction){
      var triangle = "M0,0 L0,2 L2,1 Z";
      if (direction == "up") {
        return {
          "svgPath": triangle,
          "color": color,
          "width": 10,
          "height": 10,
          "rotation": 270,
          "offsetX": 5,
          "offsetY": 6
        };
      } else {
        return {
          "svgPath": triangle,
          "color": color,
          "width": 10,
          "height": 10,
          "rotation": 90,
          "offsetX": 5,
          "offsetY": -5
        };
      }
    },
    generateChartData(){
      var chartData = [];
      var firstDate = new Date();
      firstDate.setDate(firstDate.getDate() - 5);

      for (var i = 0; i < 1000; i++) {
        // we create date objects here. In your data, you can have date strings
        // and then set format of your dates using chart.dataDateFormat property,
        // however when possible, use date objects, as this will speed up chart rendering.
        var newDate = new Date(firstDate);
        newDate.setDate(newDate.getDate() + i);

        var visits = Math.round(Math.random() * (40 + i / 5)) + 20 + i;

        chartData.push({
          date: newDate,
          visits: visits
        });
      }
      console.log(chartData);
      return chartData;
    }
  },
  mounted() {
    console.log(window.data);
    // 等地圖創建後執行
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

    this.amcharLine();
    this.getListData();
    
  },
  created() {
    
  },
}
</script>
