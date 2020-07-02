<template>
  <div>
    
    <div id="chartDiv" style="max-width: 500px;height: 560px;margin: 0px auto"> </div>
  </div>
</template>

<script>

import { JSC } from 'jscharting-vue';
export default {
    data() {
      return {
        data:'test'
      }
    },
    methods: {
       renderChart(data){
         JSC.chart('chartDiv', {
            debug: true,
            type:'radar column',
            animation_duration:1000,
            title:{label_text:'Wind Rose Chart',position:'center'},
            legend:{
              title_label_text:'Wind Speed (in mph)',
              position:'bottom',
              template:'%icon %name',
              reversed:true 
            },
            annotations:[
              {
                label:{
                  text:'Calm: 17%<br>Avg speed: 7.9 mph',
                  style_fontSize:14
                },
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
       getData(){
          let vm = this
          JSC.fetch('./data/windRoseData.csv').then(function(response) {	return response.text();}).then(function(text) {
            let data2 = JSC.csv2Json(text);
          });
       }
    },
    mounted() {
      var chart;
      console.log(this.data);
      this.getData();
      console.log(this.data);
      // this.renderChart(this.data);
    },

}
</script>

<style>
.columnChart {
    height: 300px;
}
</style>