
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



import Vue from 'vue'
import { LMap, LTileLayer, LMarker, LPopup,LIcon } from 'vue2-leaflet';

import Vue2LeafletMarkerCluster from 'vue2-leaflet-markercluster';
import "leaflet.markercluster/dist/MarkerCluster.css";
import "leaflet.markercluster/dist/MarkerCluster.Default.css";

// 載入 css
import "leaflet/dist/leaflet.css";
import "leaflet-velocity-ts/dist/leaflet-velocity.js"


///////////////////////////
//測試
import "leaflet-geotiff-2/dist/leaflet-geotiff.js";

// // optional renderers
import "leaflet-geotiff-2/dist/leaflet-geotiff-rgb.js";
import "leaflet-geotiff-2/dist/leaflet-geotiff-vector-arrows.js";
import "leaflet-geotiff-2/dist/leaflet-geotiff-plotty.js"; // requires plotty




// 啟用載入的各組件  vue2-leaflet
Vue.component("l-map", LMap);
Vue.component("l-tile-layer", LTileLayer);
Vue.component("l-marker", LMarker);
Vue.component("l-popup", LPopup);
Vue.component("l-icon", LIcon);
Vue.component('v-marker-cluster', Vue2LeafletMarkerCluster)

// 設定預設 icon
import { Icon } from "leaflet";
delete Icon.Default.prototype._getIconUrl;
Icon.Default.mergeOptions({
  iconRetinaUrl: require("leaflet/dist/images/marker-icon-2x.png"),
  iconUrl: require("leaflet/dist/images/marker-icon.png"),
  shadowUrl: require("leaflet/dist/images/marker-shadow.png")
});

Vue.config.productionTip = false;

