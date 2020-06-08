<template>
  <el-input class="input_longnumber" v-model="value" placeholder="" @change="onChange" @keydown.native="onlyNumber" :disabled="viewonly" :maxlength="maxlength"></el-input>
</template>

<script>
  export default {
    props: {
      model: {
        type: [String, Number],
        required: true,
      },
      viewonly: {
        type: Boolean,
        default: false
      },
      maxlength: {
        type: Number,
        default: 6
      }
    },
    watch:{
      model(val){
        this.value = val;
      }
    },
    data() {
      return {
        value: this.model
      }
    },
    methods: {
      onlyNumber($event) {
        var keyCode = ($event.keyCode ? $event.keyCode : $event.which);
        if (keyCode === 229 || keyCode !== 8 && keyCode !== 37 && keyCode !== 39 && (keyCode < 48 || keyCode > 57) && (keyCode < 96 || keyCode > 105)) {
          $event.preventDefault();
        } else {
          return true;
        }
      },
      onChange(val){
        this.$emit("on-change",val);
      }
    }
  }
</script>
