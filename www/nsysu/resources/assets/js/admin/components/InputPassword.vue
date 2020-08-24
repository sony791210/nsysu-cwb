<template>
  <div class="input-password">
    <input v-if="!isView" class="form-control" :class="{ error: isError, 'input-lg': setInputLg }" type="password" :name="name" :minlength="min" :maxlength="max" :placeholder="placeholder" :autocomplete="autocomplete" v-model="modelValue" @blur="onValidate" required>
    <input v-else class="form-control" :class="{ error: isError, 'input-lg': setInputLg }" type="text" :name="name" :minlength="min" :maxlength="max" :placeholder="placeholder" :autocomplete="autocomplete" v-model="modelValue" @blur="onValidate">
    <div class="icon">
      <i class="fa" :class="{ 'fa-eye-slash': !isView, 'fa-eye': isView }" @click="onToggle" aria-hidden="true"></i>
    </div>
    <div v-show="isError" class="color-red text-left">密碼格式錯誤。</div>
  </div>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      default: 'password_' + Math.floor((Math.random() * 10000) + 1).toString()
    },
    value: {
      type: String,
      default: ''
    },
    placeholder: {
      type: String,
      default: ''
    },
    autocomplete: {
      type: String,
      default: 'on'
    },
    min: {
      type: Number,
      default: 8
    },
    max: {
      type: Number,
      default: 16
    },
    setInputLg: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      isView: false,
      isError: false
    }
  },
  computed: {
    modelValue: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit('input', value);
      }
    }
  },
  methods: {
    onToggle() {
      this.isView = !this.isView;
    },
    checkPassword(str) {
      let result1 = /^[a-zA-Z0-9]{8,16}$/.test(str);
      // 先測試是否有英文
      let result2 = /[a-zA-Z]{1,}/.test(str);
      // 先測試是否有數字
      let result3 = /[0-9]{1,}/.test(str);

      return (str.length > 0 && result1 == true && result2 == true && result3 == true);
    },
    onValidate() {
      this.isError = (!this.checkPassword(this.modelValue));
      this.$emit('validate', !this.isError);
    }
  },
  mounted() {
    if (this.modelValue) this.onValidate();
  }
}
</script>