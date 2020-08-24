<template>
    <div class="next-btn-group">
      <el-button type="info" @click.prevent="close">關閉</el-button>
      <el-button v-if="getstep-1 > 0" @click.prevent="back">上一步</el-button>
      <el-button type="primary" v-if="getstep-1 < steplength-1" ref="nextbtm" @click.prevent="dovalidate">下一步</el-button>
      <el-button type="primary" v-if="showSubmit && (getstep-1 == steplength-1) && (!view_only)" @click.prevent="dovalidate">送出</el-button>
      <el-button type="success" v-if="(getstep-1 == steplength-1) && (view_only) && (is_review)" @click.prevent="review">審核</el-button>
      <el-button type="primary" v-if="showSave" @click.prevent="dovalidate">儲存</el-button>
    </div>
</template>
<script>
export default{
  props: {
    getstep: {
      type: Number
    },
    view_only: {
      type: Boolean
    },
    is_review: {
      type: Boolean
    },
    steplength:{
      type: Number
    },
    showSave: {
      type: Boolean,
      default: false
    },
    showSubmit: {
      type: Boolean,
      default: true
    }
  },
  methods: {
    back(){
      this.$emit('back');
    },
    dovalidate() {
      // console.log(this.clonestate);
      this.$emit('dovalidate');
    },
    close(){
      this.$emit('close');
    },
    review(){
      this.$emit('review');
    }
  }
}
</script>