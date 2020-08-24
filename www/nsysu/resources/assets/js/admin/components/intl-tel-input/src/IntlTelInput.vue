<template>
  <div class="intl-tel-input allow-dropdown" :class="{ validator: startValidator, success: validatorStatus, error: !validatorStatus, custom: currentOptions.customCss }" @mouseleave="hideSubMenu = true;">
    <div class="flag-container">
      <div class="selected-flag" @click="showSubMenu" :title="currentData.name + ': +' + currentData.dialCode">
        <div :class="'iti-flag ' + currentData.code"></div>
        <div class="iti-dialCode">+{{ currentData.dialCode }}</div>
        <div class="iti-arrow"></div>
      </div>
      <ul class="country-list" v-show="!hideSubMenu">
        <li @click="currentCode = item.code; hideSubMenu = true;" v-for="(item, index) in frontCountriesArray" :key="index" :class="'country ' + (item.code == currentCode ? 'highlight' : '')">
          <div class="flag-box">
            <div :class="'iti-flag ' + item.code"></div>
          </div>
          <span class="country-name">{{ item.name }}</span>
          <span class="dial-code">+{{ item.dialCode }}</span>
        </li>
        <li class="divider"></li>
        <li @click="currentCode = item.code; hideSubMenu = true;" v-for="(item, index) in countriesArray" :key="index" :class="'country ' + (item.code == currentCode ? 'highlight' : '')">
          <div class="flag-box">
            <div :class="'iti-flag ' + item.code"></div>
          </div>
          <span class="country-name">{{ item.name }}</span>
          <span class="dial-code">+{{ item.dialCode }}</span>
        </li>
      </ul>
    </div>
    <div class="input-group">
      <div :class="{ readonly: currentOptions.readonly }" style="width:100%;">
        <input type="tel" class="form-control input-lg" autocomplete="off" :placeholder="currentData.phoneFormat" :required="currentOptions.required" :readonly="currentOptions.readonly" v-model="modelValue" @blur="validatorCellphone" @change="onChange(modelValue)">
      </div>
      <div v-if="currentOptions.addInputGroup" class="input-group-btn" style="width:100%;">
        <button type="button" class="btn btn-lg" :class="currentOptions.inputGroup.css" @click.prevent="onBtnClick"> {{ currentOptions.inputGroup.text }} </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import countries from '../assets/countries.json';
import { parse, format, getNumberType, isValidNumber } from '../assets/js/validate'
import '../assets/css/intl-tel-input.css';

export default {
  name: 'intlTelInput',
  mounted() {
    // 自動抓國家
    if (this.currentOptions.setGeoIpLookup) {
      let self = this;
      axios.defaults.headers.post['Content-Type'] = 'application/json';
      axios.defaults.timeout = 20000;
      const http = axios.create();
      http.get("https://ipinfo.io").then(function(response) {
        if (response && response.data && response.data.country) {
          self.currentCode = response.data.country.toLowerCase();
        }
      });
    }

    // 自訂預設的國家
    this.setCountryCode();

    // 自訂預設的國碼
    this.setDialCodeToCountryCode();
    // 有預設值自動檢查格式
    if (this.dialCode && this.value) this.validatorCellphone();
  },
  props: {
    options: {
      type: Object,
      default() {
        return {};
      }
    },
    defaultCountryCode: {
      type: String,
      default: Object.keys(countries)[0],

      validator(code) {
        var clearCode = String(code).toLowerCase();
        return !!countries[clearCode];
      }
    },
    countryCode: {
      type: String,
      default: ''
    },
    dialCode: {
      type: String,
      default: ''
    },
    value: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      initOptions: {
        // display the country dial code next to the selected flag so it's not part of the typed number
        separateDialCode: false,
        // don't insert international dial codes
        nationalMode: true,
        setGeoIpLookup: true,
        toFront: ['tw', 'jp', 'kr', 'cn', 'hk', 'mo', 'my', 'sg'],
        required: false,
        readonly: false,
        customCss: false,
        addInputGroup: false,
        inputGroup: {
          css: {},
          text: ''
        }
      },
      currentCode: this.defaultCountryCode,
      hideSubMenu: true,
      modelValue: this.value,
      startValidator: false,
      validatorStatus: false
    }
  },
  watch:{
    value: function(val){

      // if(this.startValidator === false){
        this.modelValue = val;
        // console.log(this.modelValue);
      // }
    }
  },
  computed: {
    currentOptions() {
      return Object.assign(this.initOptions, this.options);
    },
    currentData() {
      return countries[this.currentCode];
    },

    frontCountriesArray() {
      const toFrontCodes = {};

      this.currentOptions.toFront.forEach((code) => {
        const stringCode = String(code);
        const needObj = countries[stringCode];

        if (needObj) {
          toFrontCodes[stringCode] = needObj;
        }
      });

      return toFrontCodes;
    },

    countriesArray() {
      const countryCopie = { ...countries };

      this.currentOptions.toFront.forEach((code) => {
        delete countryCopie[code];
      });

      return countryCopie;
    }
  },
  methods: {
    onChange(val){
      this.$emit('change-cellphone', this.modelValue ,this.currentData.dialCode.toString(),this.currentCode, this._isValidNumber());
    },
    showSubMenu() {
      if (!this.currentOptions.readonly) this.hideSubMenu = !this.hideSubMenu;
    },
    _getFullNumber() {
      var val = this.modelValue,
        dialCode = this.currentData.dialCode.toString(),
        prefix;
      if (this.currentOptions.separateDialCode) {
        prefix = "+" + dialCode;
      } else if (dialCode && dialCode.charAt(0) == "1" && dialCode.length == 4 && dialCode.substr(1) != val.substr(0, 3)) {
        prefix = dialCode.substr(1);
      } else {
        prefix = "";
      }
      return prefix + val;
    },
    _getNumberType() {
      try {
        let parsePhone = parse(this._getFullNumber(), this.currentData.code.toUpperCase());
        return getNumberType(parsePhone.phone, parsePhone.country);
      } catch (error) {
        return -1;
      }
    },
    getNumber() {
      return format(this._getFullNumber(), this.currentData.code.toUpperCase(), 'International');
    },
    _isValidNumber() {
      if (this.modelValue) {
        let val = this._getFullNumber().trim(),
          countryCode = (this.currentOptions.nationalMode) ? this.currentData.code.toUpperCase() : "";
        return isValidNumber(val, countryCode);
      }

      return false;
    },
    setCountryCode() {
      if (this.countryCode) {
        var clearCode = String(this.countryCode).toLowerCase();
        if (!!countries[clearCode]) {
          this.currentCode = clearCode;
        }
      }
    },
    setDialCodeToCountryCode() {
      if (this.dialCode) {
        let dialCode = this.dialCode.replace('+', '');
        let code = Object.keys(this.countriesArray).find(c => this.countriesArray[c].dialCode == dialCode);
        if (code) {
          this.currentCode = code;
        }
      }
    },
    validatorCellphone() {
      this.startValidator = true;
      this.validatorStatus = ((this._getNumberType() === 'MOBILE' || this._getNumberType() === 'FIXED_LINE_OR_MOBILE') && this._isValidNumber());
      if (this.validatorStatus) {
        this.$emit('validate-cellphone-success', this.getNumber(), this.currentCode);
      }
      else {
        this.$emit('validate-cellphone-error', this.modelValue);
      }

    },
    onBtnClick() {
      // 回傳手機號碼
      this.$emit('get-cellphone', this.getNumber(), this.currentCode);
      this.$emit('on-btn-click');
    }
  }
}
</script>
