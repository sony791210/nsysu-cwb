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
    }
  },
  async mounted() {
    var vm=this;
    await vm.getData();
    console.log('this');
    console.log(vm.data);
    var mymap = L.map('map').setView([23, 120], 5);;
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      maxZoom: 18,
      id: 'mapbox/streets-v11',
      tileSize: 512,
      zoomOffset: -1,
      accessToken: 'pk.eyJ1IjoiYXBwbGU3OTEyMTAiLCJhIjoiY2s2aGp1Zjl6MHZveTNrbXRld2ViZzdtcSJ9.P9qkKbnkCZPCqGDXHbr2aA'
      }).addTo(mymap);
    // var velocity = L.velocityLayer({
    //   displayValues: true,
    //   displayOptions: {
    //     velocityType: "Global Wind",
    //     position: "bottomleft",
    //     emptyString: "No velocity data",
    //     angleConvention: "bearingCW",
    //     displayPosition: "bottomleft",
    //     displayEmptyString: "No velocity data",
    //     speedUnit: "kt"
    //   },
    //   data: vm.data, // see demo/*.json, or wind-js-server for example data service

    //   // OPTIONAL
    //   minVelocity: 0, // used to align color scale
    //   maxVelocity: 10, // used to align color scale
    //   velocityScale: 0.005, // modifier for particle animations, arbitrarily defaults to 0.005
    //   colorScale: [], // define your own array of hex/rgb colors
    //   onAdd: null, // callback function
    //   onRemove: null, // callback function
    //   opacity: 0.97, // layer opacity, default 0.97

    //   // optional pane to add the layer, will be created if doesn't exist
    //   // leaflet v1+ only (falls back to overlayPane for < v1)
    //   paneName: "overlayPane"
    // });
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
