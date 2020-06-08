<template>
  <div>
    <div v-if="hasSort">
      <span v-for="(item, index) in imgs">
        <el-input-number class="sort-input" size="mini" v-model="item.sort" style="margin:0 12px;" :min="1" :max="limit" :key="index"></el-input-number>
      </span>
    </div>
    <el-upload
      action="https://jsonplaceholder.typicode.com/posts/"
      list-type="picture-card"
      ref="uploadImg"
      accept="image/*"
      :auto-upload="false"
      :http-request="imageUpload"
      :show-file-list="true"
      :on-preview="handlePictureCardPreview"
      :on-remove="handleRemove"
      :on-change="handleChange"
      :on-exceed='uploadOverrun'
      :file-list="imgs"
      :limit="limit"
      id="img-list">
      <i class="el-icon-plus"></i>
    </el-upload>
    <el-dialog :visible.sync="dialogVisible" :v-model="imgs" top="5vh">
      <img width="100%" :src="dialogImageUrl" alt="">
    </el-dialog>
    <el-dialog class="cropper" title="剪裁圖片" :visible.sync="cropDialogVisible" width="80vw" top="5vh" :close-on-press-escape="false" :close-on-click-modal="false" :show-close="false">
      <cropper ref="cropper"
              :img-file="cropOption.img"
              :fixed-number="cropOption.fixedNumber"
              :auto-crop-width="cropOption.autoCropWidth"
              :auto-crop-height="cropOption.autoCropHeight"
              @upload="imageUpload">
      </cropper>
    </el-dialog>
  </div>
</template>

<script>
export default {
  data () {
    return {
      getFileNum: 0,
      dialogImageUrl: '',
      dialogVisible: false,
      cropDialogVisible: false,
      cropOption: {
        img: '',
        autoCropWidth: this.autoCropWidth,
        autoCropHeight: this.autoCropHeight,
        fixedNumber: this.fixedNumber
      },
      imgs: this.imgList
    }
  },
  props: {
    imgList: {
      type: Array,
      required: true
    },
    getId: {
      type: String,
      required: true
    },
    fixedNumber:{
      type: Array,
      required: true
    },
    autoCropWidth:{
      type: Number,
      required: true
    },
    autoCropHeight:{
      type: Number,
      required: true
    },
    limit: {
      type: Number,
      default: 5
    },
    imgType: {
      type: Array
    },
    imgSize: {
      type: Number
    },
    hasSort: {
      type: Boolean,
      default: false
    }
  },
  mounted() {
    this.getFileNum = this.imgList.length;
    var img = document.getElementById(this.getId);
    var card = img.getElementsByClassName("el-upload--picture-card")[0];
    if(this.imgList.length >= this.limit) {
      card.classList.add("img-overrun");
    }
    if(this.fixedNumber) {
      var val = this.fixedNumber[1]/this.fixedNumber[0];
      var upload = document.getElementById(this.getId);
      var items = upload.getElementsByClassName("el-upload-list__item");
      card.style.height = 148 * val + 'px';
      card.style.lineHeight = (146 * val + 15) + 'px';
      Array.from(items).forEach(function(element) {
        element.style.height = 146 * val + 'px';
      });
    }
  },
  methods: {
    uploadOverrun() {
      this.getFileNum = this.limit;
      this.$message.error('最多僅能上傳' + this.limit + '張圖片');
    },
    imageUpload(file, url, uid) {
      this.getFileNum += 1;
      this.imgs.push({
        file: file,
        url: url,
        sort: this.getFileNum
      });
      this.cropDialogVisible = false;
      if(this.getFileNum >= this.limit) {
        var img = document.getElementById(this.getId);
        var card = img.getElementsByClassName("el-upload--picture-card")[0];
        card.classList.add("img-overrun");
      }
      if(this.fixedNumber) {
        var val = this.fixedNumber[1]/this.fixedNumber[0];
        var upload = document.getElementById(this.getId);
        var items = upload.getElementsByClassName("el-upload-list__item");
        Array.from(items).forEach(function(element) {
          element.style.height = 146 * val + 'px';
        });
      }
      this.$emit("upload", this.imgs);
    },
    handleRemove(file, fileList) {
      this.getFileNum = fileList.length;
      var index = this.imgs.findIndex(val => val.uid === file.uid);
      if (index != -1) {
          this.imgs.splice(index, 1);
      }
      if(this.getFileNum < this.limit) {
        var img = document.getElementById(this.getId);
        var card = img.getElementsByClassName("el-upload--picture-card")[0];
        card.classList.remove("img-overrun");
      }
    },
    handleChange(file, fileList){
      if (!file) return;
      if(this.imgType) {
        var isImgType = this.imgType.every(function(item){
          if(item.toLowerCase() === 'jpg' || item.toLowerCase() === 'jpeg') {
            var type = 'image/jpeg';
          }
          else if(item.toLowerCase() === 'png'){
            var type = 'image/png';
          }
          else if(item.toLowerCase() === 'gif') {
            var type = 'image/gif';
          }

          if(type && file.raw.type === type) {
            return item
          }
        });
      }
      if(this.imgSize) {
        var isImgSize = file.size / 1024 / 1024 <= this.imgSize;
      }

      if (this.imgType && !isImgType) {
        this.$message.error('上傳圖片格式錯誤!');
        let index = fileList.findIndex(val => val.uid === file.uid);
        fileList.splice(index, 1);
      }
      else if (this.imgSize && !isImgSize) {
        this.$message.error('上傳圖片大小不能大於' + this.imgSize + 'MB!');
        let index = fileList.findIndex(val => val.uid === file.uid);
        fileList.splice(index, 1);
      }
      else{
        this.cropDialogVisible = true;
        this.cropOption.img = file;
      }
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    }
  }
}
</script>
<style>
.img-overrun {
  display: none !important;
}
</style>
