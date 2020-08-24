<template>
  <div class="cropper-warp">
    <div class="cropper-content">
      <!-- 剪裁框 -->
      <div class="cropper">
        <vue-cropper
          ref="cropper"
          :img="imgFile.url"
          :outputSize="option.size"
          :outputType="option.outputType"
          :info="false" :full="option.full"
          :canMove="option.canMove"
          :canMoveBox="option.canMoveBox"
          :original="option.original"
          :autoCrop="option.autoCrop"
          :autoCropWidth="autoCropWidth"
          :autoCropHeight="autoCropHeight"
          :fixedBox="option.fixedBox"
          @realTime="realTime"
          :fixed="option.fixed"
          :fixedNumber="fixedNumber"
          :center-box="option.centerBox"
          :enlarge="option.enlarge">
        </vue-cropper>
      </div>
      <!-- 預覽框 -->
      <!-- <div class="show-preview" :style="{'width': '35vw', 'height': '35vw',  'overflow': 'hidden', 'margin': '0 25px', 'display':'flex', 'align-items' : 'center'}">
        <div :style="previews.div" class="preview">
          <img :src="previews.url" :style="previews.img">
        </div>
      </div> -->
    </div>
    <div class="footer-btn">
      <!-- 縮放旋轉按鈕 -->
      <div class="scope-btn">
        <el-button type="primary" icon="el-icon-zoom-in" @click="changeScale(1)"></el-button>
        <el-button type="primary" icon="el-icon-zoom-out" @click="changeScale(-1)"></el-button>
        <el-button type="primary" @click="rotateLeft">逆時針旋轉</el-button>
        <el-button type="primary" @click="rotateRight">順時針旋轉</el-button>
      </div>

      <!-- <div class="scope-btn">
        <el-button type="warning" @click="isPhyImg">封面圖片、實體商品(非封面) [4:3]</el-button>
        <el-button type="warning" @click="notPhyImg">虛擬商品(非封面) [8:3]</el-button>
      </div> -->
      <!-- 確認上傳按鈕 -->
      <div class="upload-btn">
        <el-button type="danger" :disabled="btnDisable" @click="uploadImg('blob')">上傳</el-button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      previews: {}, // 預覽數據
      option: {
        img: '', //裁剪圖片的地址 (默認：空)
        size: 1, // 裁剪生成圖片的質量 (默認:1)
        full: true, // 是否輸出原圖比例的截圖 選true生成的圖片會非常大 (默認:false)
        outputType: 'png',
        canMove: true, // 上傳圖片是否可以移動 (默認:true)
        original: false, // 上傳圖片按照原始比例渲染 (默認:false)
        canMoveBox: true, // 截圖框能否拖動 (默認:true)
        autoCrop: true, // 是否默認生成截圖框 (默認:false)
        fixedBox: false, // 固定截圖框大小 不允許改變 (默認:false)
        fixed: true, // 是否開啟截圖框寬高固定比例 (默認:true)
        autoCropWidth: 512,
        autoCropHeight: 384,
        centerBox: true,
        fixedNumber: [4, 3], // 截圖框比例 (默認:[1:1])
        enlarge: 2
      },
      btnDisable: false
    }
  },
  props: {
    imgFile:{
      type: Object
    },
    fixedNumber:{
      type: Array
    },
    autoCropWidth:{
      type: Number
    },
    autoCropHeight:{
      type: Number
    }
  },
  methods: {
    changeScale (num) {
      // 圖片縮放
      num = num || 1
      this.$refs.cropper.changeScale(num)
    },
    rotateLeft () {
      // 向左旋轉
      this.$refs.cropper.rotateLeft()
    },
    rotateRight () {
      // 向右旋轉
      this.$refs.cropper.rotateRight();
    },
    realTime (data) {
      // 實時預覽
      this.previews = data;
      this.btnDisable = false;
    },
    isPhyImg(){
      this.option.fixedNumber = [4,3];
      this.option.autoCropWidth = 512;
      this.option.autoCropHeight = 384;
    },
    notPhyImg(){
      this.option.fixedNumber = [8,3];
      this.option.autoCropWidth = 480;
      this.option.autoCropHeight = 180;
    },
    uploadImg (type) {
      this.btnDisable = true;
      // 將剪裁好的圖片回傳給父組件
      event.preventDefault()
      let vm = this;
      if (type === 'blob') {
        this.$refs.cropper.getCropBlob(data => {
          let fileName = this.imgFile.name.split(".");
          fileName = fileName[0]+'.png';
          let file = new File([data], fileName, {type: "image/png"});
          let img = window.URL.createObjectURL(data);
          vm.$emit('upload', file, img, this.imgFile.uid);
        })
      } else {
        this.$refs.cropper.getCropData(data => {
          vm.$emit('upload', data);
        })
      }
    }
  }
}
</script>