<template>
  <div class="page-container joinus-page">

      <div id="map" style="height:900px"></div>

  </div>
</template>


<script>


export default {
  data() {
    return {
      data:''
    }
  },
  methods: {
    async getData(){
      let vm=this
      await axios.get(siteUrl + '/api/cwbData/getSurfaceData').then(function(res) {
        if (res.data.code === '00000') {
          // 
          var abc = '[ {"hear":"test","data":[123]},{"hear":"test2","data":[34]}]'

          console.log(JSON.parse(abc))
          console.log('test')
          // console.log(res.data.data.data);
          console.log(JSON.parse(res.data.data.data))
          vm.data=JSON.parse(res.data.data.data)
        }
      })
    },
    getTif(){
      
    }
  },
  async mounted() {
    var vm=this;
    await vm.getData();
    // const url =siteUrl+'/tiff/test.tif';
    var mymap = L.map('map').setView([23, 120], 5);;
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
       attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
       maxZoom: 18,
       id: 'mapbox/streets-v11',
       tileSize: 512,
       zoomOffset: -1,
       accessToken: 'pk.eyJ1IjoiYXBwbGU3OTEyMTAiLCJhIjoiY2s2aGp1Zjl6MHZveTNrbXRld2ViZzdtcSJ9.P9qkKbnkCZPCqGDXHbr2aA'
    }).addTo(mymap);
    const windSpeedUrl=siteUrl+'/tiff/point2.tiff'
    // https://stuartmatthews.github.io/leaflet-geotiff/tif/wind_speed.tif';
    const plottyRenderer = L.LeafletGeotiff.plotty({
        displayMin: 0.01,
        displayMax: 1,
        clampLow: true,
        clampHigh: true,
        colorScale:"summer"
        
      });
    // const windSpeedLayer = L.leafletGeotiff(windSpeedUrl, {
    //     band: 0,
    //     renderer: plottyRenderer,
    //     opacity: 0.1,
    //   }).addTo(mymap);
      // const windSpeedUrl2=siteUrl+'/tiff/wind_speed.tif'
      // const windSpeedLayer2 = L.leafletGeotiff(windSpeedUrl2, {
      //   band: 0,
      //   renderer: plottyRenderer,
      // }).addTo(mymap);


//     viridis	inferno	turbo
// rainbow	jet	hsv
// hot	cool	spring
// summer	autumn	winter
// bone	copper	greys
// yignbu	greens	yiorrd
// bluered	rdbu	picnic
// portland	blackbody	earth
// electric	magma	plasma
    console.log('this');
    console.log(vm.data);
    



    
    
    let velocity = L.velocityLayer({
      displayValues: true,
      displayOptions: {
        velocityType: 'GBR Wind',
        position: 'bottomleft',//REQUIRED !
        emptyString: 'No velocity data', //REQUIRED !
        angleConvention: 'bearingCW',
        displayPosition: 'bottomleft',
        displayEmptyString: 'No velocity data',
        speedUnit: 'm/s'
      },
      data: vm.data,
      maxVelocity: 10,
      velocityScale: 0.05,
    });
    velocity.addTo(mymap);

  },
  created() {
    
  },
}
</script>
