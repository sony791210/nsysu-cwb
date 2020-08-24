$(function() {
  var ckeditorConfig = {
    language: 'zh-TW',
    height: 250,
    filebrowserImageBrowseUrl: siteUrl + '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: siteUrl + '/laravel-filemanager/upload?type=Images&_token=' + csrfToken,
    filebrowserBrowseUrl: siteUrl + '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: siteUrl + '/laravel-filemanager/upload?type=Files&_token=' + csrfToken
  };

  if (backend_data.page == 'review') {
    var ckeditorConfig = {
      language: 'zh-TW',
      height: 250,
      filebrowserImageBrowseUrl: siteUrl + '/laravel-filemanager?type=Images',
      filebrowserImageUploadUrl: siteUrl + '/laravel-filemanager/upload?type=Images&_token=' + csrfToken,
      filebrowserBrowseUrl: siteUrl + '/laravel-filemanager?type=Files',
      filebrowserUploadUrl: siteUrl + '/laravel-filemanager/upload?type=Files&_token=' + csrfToken,
      toolbar: 'Full'
    };
  }

  CKEDITOR.on('dialogDefinition', function(ev) {
    var dialogName = ev.data.name,
        dialogDefinition = ev.data.definition;
    if (dialogName === 'image') {
        dialogDefinition.removeContents('Upload');
    }
  });
  CKEDITOR.replace('product_content1', ckeditorConfig);
  CKEDITOR.replace('product_content2', ckeditorConfig);
  CKEDITOR.replace('product_content3', ckeditorConfig);
})
const paymentOptions = ['信用卡一次付清', 'ATM虛擬帳號', 'LinePay', 'ApplePay', 'GooglePay', '台灣Pay'];
backend_data.checkedPyament = backend_data.prod.payment_linepay == 1 ? [paymentOptions[2]] : [];
backend_data.prod.payment_virtual_atm == 1 ? backend_data.checkedPyament.push(paymentOptions[1]) : '';
backend_data.prod.payment_credit_once == 1 ? backend_data.checkedPyament.push(paymentOptions[0]) : '';
backend_data.prod.payment_applepay == 1 ? backend_data.checkedPyament.push(paymentOptions[3]) : '';
backend_data.prod.payment_googlepay == 1 ? backend_data.checkedPyament.push(paymentOptions[4]) : '';
backend_data.prod.payment_taiwanpay == 1 ? backend_data.checkedPyament.push(paymentOptions[5]) : '';

var app = new Vue({
  el: '#app',
  data() {
    return {
      // public
      isphysical: Boolean(backend_data.is_physical), //實體true,虛擬false
      activeName: 'step1',
      steps: 0,
      stepLength: 4,
      duration: 2000,
      identity: backend_data.identity, //管理員1,供應商2
      viewOnly: backend_data.viewOnly, //只能檢視
      isReview: backend_data.isReview, //第四步驟審核按鈕狀態
      isEdit: backend_data.isEdit, //編輯
      // step1
      get_filenum: backend_data.prod_imgs.length,
      ruleForm1: {
        categoryOptions: backend_data.top_tags,
        categoryValue: backend_data.top_tag,
        subCategoryOptions: backend_data.sub_tags,
        subCategoryValue: backend_data.sub_tag,
        martTime: backend_data.prod.onshelf_time !== null ? [backend_data.prod.onshelf_time, backend_data.prod.offshelf_time] : '', //[0]開始,[1]結束
        prodSaleTime: backend_data.prod.onsale_time !== null ? [backend_data.prod.onsale_time, backend_data.prod.offsale_time] : '', //[0]上架,[1]下架
        effectiveTimeRadio: backend_data.prod.expire_type,
        effectiveTimeDay: backend_data.prod.expire_daycount != null ? backend_data.prod.expire_daycount : '',
        effectiveTimeDate: backend_data.prod.expire_due != null ? backend_data.prod.expire_due : '',
        effectiveTimeRange: backend_data.prod.expire_start != null ? [backend_data.prod.expire_start, backend_data.prod.expire_due] : '',
        checkedPayment: backend_data.checkedPyament,
        buyNumValue: backend_data.prod.limit_type,
        buyNumOptions: [{
          value: 0,
          label: '每筆訂單（單筆限購）'
        }, {
          value: 1,
          label: '這個商品（會員商品限購）'
        }],
        buyNum: backend_data.prod.limit_num,
        origin_product_imgs: JSON.parse(JSON.stringify(backend_data.prod_imgs)),
        deleted_origin_imgs: [],
        product_imgs: backend_data.prod_imgs
      },
      company: backend_data.company,
      dialogImageUrl: '',
      dialogVisible: false,
      cropDialogVisible: false,
      cropOption: {
        img: '',
        autoCropWidth: 512,
        autoCropHeight: 384,
        fixedNumber: [4, 3]
      },
      checkAll: false,
      payment: paymentOptions,
      // step2
      ruleForm2: {
        product_name: backend_data.prod.name,
        sale_content: backend_data.prod.short,
        product_title1: backend_data.prod.tabs1,
        product_content1: backend_data.prod.desc1,
        product_title2: backend_data.prod.tabs2,
        product_content2: backend_data.prod.desc2,
        product_title3: backend_data.prod.tabs3,
        product_content3: backend_data.prod.desc3
      },
      rules2: {
        product_name: [{
          required: true,
          message: '請輸入商品名稱',
          trigger: 'blur'
        }],
        sale_content: [{
          required: true,
          message: '請輸入商品賣點',
          trigger: 'blur'
        }],
        product_title1: [{
          required: true,
          message: '請輸入頁籤名稱',
          trigger: 'blur'
        }],
        product_title2: [{
          required: true,
          message: '請輸入頁籤名稱',
          trigger: 'blur'
        }],
        product_title3: [{
          required: true,
          message: '請輸入頁籤名稱',
          trigger: 'blur'
        }],
      },
      input: '',
      textarea: '',
      content: '',

      // step3
      ruleForm3: backend_data.prod_specs,
      rules3: {},
      ticketRadio: backend_data.prod.price_type, //無票種0,有票種1
      specTypeChange: backend_data.prod.price_type,
      apiParamsOptions: backend_data.specApiParamsOptions,
      // step4
      ruleForm4: {
        place: backend_data.prod.store,
        zipcode: backend_data.prod.zipcode,
        city: backend_data.prod.county,
        district: backend_data.prod.district,
        address: backend_data.prod.address,
        fare: backend_data.prod.shipping,
        apiNo: backend_data.prod.api,
        apiNoOptions: backend_data.apiTypeOptions,
        bookUseTime: backend_data.prod.bookable,
        onSearchRadio: backend_data.prod.on_search,
        stata_radio: backend_data.prod.status
      },
      rules4: {},
      tableData: backend_data.shipping_fees,
      fix_fare: backend_data.prod.vendor_shipping_fees[0].fee.toString(),
      editer: backend_data.editor,
      addtime: backend_data.prod.created_at,
      edittime: backend_data.prod.updated_at,
      tag_value: backend_data.prod_keywords,
      tag_options: backend_data.keywords
    }
  },

  methods: {
    // public
    back() {
      this.activeName = 'step' + (this.steps);
      this.steps -= 1;
    },
    onlyNumber($event) {
      var keyCode = ($event.keyCode ? $event.keyCode : $event.which);
      if (keyCode !== 8 && keyCode !== 37 && keyCode !== 39 && (keyCode < 48 || keyCode > 57) &&
        (keyCode < 96 || keyCode > 105)) {
        // console.log(keyCode);
        $event.preventDefault();
      } else {
        return true;
      }
    },

    //商品驗證
    dovalidate() {
      switch (this.activeName) {
        case 'step1':
          var imgSortResult = new Set();
          var imgSortRepeat = new Set();
          this.ruleForm1.product_imgs.forEach(item => {
            imgSortResult.has(item.sort) ? imgSortRepeat.add(item.sort) : imgSortResult.add(item.sort);
          });
          if (this.ruleForm1.categoryValue === '') {
            this.$notify.error({
              message: '請選擇商品分類',
              offset: 100,
              duration: this.duration
            });
            this.activeName = 'step' + (this.steps + 1);
          } else if (this.ruleForm1.subCategoryValue === '') {
            this.$notify.error({
              message: '請選擇子分類',
              offset: 100,
              duration: this.duration
            });
            this.activeName = 'step' + (this.steps + 1);
          } else if (this.get_filenum < 1) {
            this.$notify.error({
              message: '請上傳圖片',
              offset: 100,
              duration: this.duration
            });
            this.activeName = 'step' + (this.steps + 1);
          } else if (imgSortRepeat.size != 0) {
            this.$notify.error({
              message: '注意！圖片排序編號重複',
              offset: 100,
              duration: this.duration
            });
            this.activeName = 'step' + (this.steps + 1);
          } else if (!imgSortResult.has(1)) {
            this.$notify.error({
              message: '注意！必須有排序為1的圖片作為封面',
              offset: 100,
              duration: this.duration
            });
            this.activeName = 'step' + (this.steps + 1);
          } else if (this.identity === 1 && this.ruleForm1.martTime === null) {
              this.$notify.error({
                message: '請完整填寫賣場上下架時間',
                offset: 100,
                duration: this.duration
              });
              this.activeName = 'step' + (this.steps + 1);
          } else if (this.identity === 1 && this.ruleForm1.prodSaleTime === null) {
              this.$notify.error({
                message: '請完整填寫商品銷售時間',
                offset: 100,
                duration: this.duration
              });
              this.activeName = 'step' + (this.steps + 1);
          } else if (this.identity === 1 && this.ruleForm1.martTime.length !== 2) {
              this.$notify.error({
                message: '請完整填寫賣場上下架時間',
                offset: 100,
                duration: this.duration
              });
              this.activeName = 'step' + (this.steps + 1);
          } else if (this.identity === 1 && this.ruleForm1.prodSaleTime.length !== 2) {
              this.$notify.error({
                message: '請完整填寫商品銷售時間',
                offset: 100,
                duration: this.duration
              });
              this.activeName = 'step' + (this.steps + 1);
          } else if (this.identity === 1 && (this.ruleForm1.martTime[0] > this.ruleForm1.prodSaleTime[0] || this.ruleForm1.martTime[1] < this.ruleForm1.prodSaleTime[1])) {
              this.$notify.error({
                message: '『商品銷售時間』必須在『賣場上下架時間』內',
                offset: 100,
                duration: this.duration + 1000
              });
              this.activeName = 'step' + (this.steps + 1);
          } else if(!this.isphysical && this.ruleForm1.effectiveTimeRadio === '') {
            this.$notify.error({
              message: '請選擇商品有效使用時間',
              offset: 100,
              duration: this.duration
            });
            this.activeName = 'step' + (this.steps + 1);
          } else if (!this.isphysical && this.ruleForm1.effectiveTimeRadio === 1 && this.ruleForm1.effectiveTimeDay === '') {
            this.$notify.error({
              message: '請填寫商品有效使用時間詳細參數',
              offset: 100,
              duration: this.duration
            });
            this.activeName = 'step' + (this.steps + 1);
          } else if (!this.isphysical && this.ruleForm1.effectiveTimeRadio === 2 && (this.ruleForm1.effectiveTimeDate === null || this.ruleForm1.effectiveTimeDate === '')) {
            this.$notify.error({
              message: '請填寫商品有效使用時間詳細參數',
              offset: 100,
              duration: this.duration
            });
            this.activeName = 'step' + (this.steps + 1);
          } else if (!this.isphysical && this.ruleForm1.effectiveTimeRadio === 3 && (this.ruleForm1.effectiveTimeRange === null || this.ruleForm1.effectiveTimeRange.length !== 2)) {
            this.$notify.error({
              message: '請填寫商品有效使用時間詳細參數',
              offset: 100,
              duration: this.duration
            });
            this.activeName = 'step' + (this.steps + 1);
          } else if (this.identity === 1 && !this.isphysical && this.ruleForm1.effectiveTimeRadio === 2 && this.ruleForm1.effectiveTimeDate < this.ruleForm1.prodSaleTime[1]) {
            this.$notify.error({
              message: '商品有效時間需大於等於銷售結束時間',
              offset: 100,
              duration: this.duration
            });
            this.activeName = 'step' + (this.steps + 1);
          } else if (this.identity === 1 && !this.isphysical && this.ruleForm1.effectiveTimeRadio === 3 && this.ruleForm1.effectiveTimeRange[1] < this.ruleForm1.prodSaleTime[1]) {
            this.$notify.error({
              message: '商品有效結束時間需大於等於銷售結束時間',
              offset: 100,
              duration: this.duration
            });
            this.activeName = 'step' + (this.steps + 1);
          } else if (this.identity === 1 && this.ruleForm1.checkedPayment.length === 0) {
              this.$notify.error({
                message: '請選擇金流收款方式',
                offset: 100,
                duration: this.duration
              });
              this.activeName = 'step' + (this.steps + 1);
          } else if (this.identity === 1 && (this.ruleForm1.buyNumValue === '' || this.ruleForm1.buyNum === '')) {
              this.$notify.error({
                message: '請完整填寫商品可賣數量',
                offset: 100,
                duration: this.duration
              });
              this.activeName = 'step' + (this.steps + 1);
          } else {
              this.steps += 1;
              this.activeName = 'step' + (this.steps + 1);
          }
          break;
        case 'step2':
          if (this.ruleForm2.product_content1 === '<p>&nbsp;</p>' ||
            this.ruleForm2.product_content2 === '<p>&nbsp;</p>' ||
            this.ruleForm2.product_content3 === '<p>&nbsp;</p>') {
            this.$notify.error({
              message: '請完整填寫產品內容!',
              offset: 100,
              duration: this.duration
            });
            this.activeName = 'step' + (this.steps + 1);
            break;
          } else {
            this.$refs.ruleForm2.validate((valid, errors) => {
              if (valid) {
                this.steps += 1;
                this.activeName = 'step' + (this.steps + 1);
              } else {
                this.activeName = 'step' + (this.steps + 1);
                return false;
              }
            });
            break;
          }
        case 'step3':
          var result = new Set();
          var repeat = new Set();
          this.ruleForm3.forEach(item => {
            result.has(item.sortnum) ? repeat.add(item.sortnum) : result.add(item.sortnum);
          });
          // console.log(repeat);
          if (this.ruleForm3.length === 0) {
            this.$notify.error({
              message: '請新增規格/尺寸！',
              offset: 100,
              duration: this.duration
            });
            this.activeName = 'step' + (this.steps + 1);
            break;
          } else {
            //商品無票種/屬性
            if (this.ticketRadio === 0) {
              for (len = 0; len < this.ruleForm3.length; len++) {
                let check_sp = this.ruleForm3[len].ten_million + this.ruleForm3[len].million + this.ruleForm3[len].thousands +
                  this.ruleForm3[len].hundreds + this.ruleForm3[len].tens + this.ruleForm3[len].ones;
                check_sp = (check_sp.replace(/\b(0+)/gi, "").replace(/^\s+|\s+$/g, '') === '') ? 0 : check_sp.replace(/\b(0+)/gi, "").trim();
                // console.log(Number(check_sp));
                //確認無空格
                if (this.ruleForm3[len].sortnum === '' || this.ruleForm3[len].spec === '') {
                  this.$notify.error({
                    message: '請填寫規格排序及名稱！',
                    offset: 100,
                    duration: this.duration
                  });
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                // } else if (this.identity === 1 && this.ruleForm3[len].specTime === null) {
                //   this.ruleForm3[len].specTime = this.ruleForm1.prodSaleTime;
                // } else if (this.identity === 1 && this.ruleForm3[len].specTime.length !== 2) {
                //   this.ruleForm3[len].specTime = this.ruleForm1.prodSaleTime;
                } else if (this.identity === 1 && this.ruleForm3[len].specTime !== null && this.ruleForm3[len].specTime.length === 2 && (this.ruleForm1.martTime[0] > this.ruleForm3[len].specTime[0] || this.ruleForm1.martTime[1] < this.ruleForm3[len].specTime[1])) {
                  this.$notify.error({
                    message: '規格 【 ' + this.ruleForm3[len].spec + ' 】 的『停開賣時間』必須在『賣場上下架時間』內',
                    offset: 100,
                    duration: this.duration + 1500
                  });
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                } else if(this.ruleForm3[len].c_price === '' || this.ruleForm3[len].s_price === ''){
                  this.$notify.error({
                    message: '請完整填寫規格【' + this.ruleForm3[len].spec + '】價格！',
                    offset: 100,
                    duration: this.duration
                  });
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                //驗證中文
                } else if (!(/^(0|[1-9]\d*)$/.test(Number(this.ruleForm3[len].c_price))) ||
                  !(/^(0|[1-9]\d*)$/.test(Number(this.ruleForm3[len].s_price))) ||
                  !(/^(0|[1-9]\d*)$/.test(Number(this.ruleForm3[len].salenum)))) {
                  this.$notify.error({
                    message: '請檢查規格【' + this.ruleForm3[len].spec + '】的『定價』、『售價』、『商品可賣量』是否含有中文！',
                    offset: 100,
                    duration: this.duration
                  });
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                //再次確認售價正確
                } else if (Number(this.ruleForm3[len].s_price) !== Number(check_sp)) {
                  this.$notify.error({
                    message: '請再次確認規格【' + this.ruleForm3[len].spec + '】售價!',
                    offset: 100,
                    duration: this.duration
                  });
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                } else if (Number(check_sp) === 0) {
                  this.$notify.error({
                    message: '請注意規格【' + this.ruleForm3[len].spec + '】售價為零！',
                    offset: 100,
                    duration: this.duration
                  });
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                } else if (Number(this.ruleForm3[len].s_price) > Number(this.ruleForm3[len].c_price)) {
                  this.$notify.error({
                    message: '規格【' + this.ruleForm3[len].spec + '】『售價』大於『定價』，請再次確認售價或定價！',
                    offset: 100,
                    duration: this.duration + 1500
                  });
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                } else if(this.ruleForm3[len].salenum === ''){
                  this.$notify.error({
                    message: '請填寫規格【' + this.ruleForm3[len].spec + '】可賣量！',
                    offset: 100,
                    duration: this.duration
                  });
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                } else if(this.ruleForm3[len].checkAutoUpdate && (this.ruleForm3[len].autoUpdateLow === '' || this.ruleForm3[len].autoUpdateSaleNum === '')){
                  this.$notify.error({
                    message: '請填寫規格【' + this.ruleForm3[len].spec + '】自動更新可賣量規則！',
                    offset: 100,
                    duration: this.duration
                  });
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                } else if (this.ruleForm3[len].groupTicketRadio === 1 && this.ruleForm3[len].groupTicketNum === '') {
                  this.$notify.error({
                    message: '請填寫規格【' + this.ruleForm3[len].spec + '】團體票包含數量！',
                    offset: 100,
                    duration: this.duration
                  });
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                } else if (this.identity === 1 && !this.isphysical && this.ruleForm3[len].apiParams === '' ) {
                  this.$notify.error({
                    message: '請選擇規格【 ' + this.ruleForm3[len].spec + ' 】API參數',
                    offset: 100,
                    duration: this.duration
                  });
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                } else if (this.identity === 1 && this.ruleForm3[len].invoiceRadio === '') {
                  this.$notify.error({
                    message: '請選擇規格【 ' + this.ruleForm3[len].spec + ' 】開立發票規則',
                    offset: 100,
                    duration: this.duration
                  });
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                } else if (this.identity === 1 && this.ruleForm3[len].handling === '') {
                  this.$notify.error({
                    message: '請填寫規格【 ' + this.ruleForm3[len].spec + ' 】手續費',
                    offset: 100,
                    duration: this.duration
                  });
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                } else if(!this.isphysical && this.ruleForm3[len].useConditions === ''){
                  this.$notify.error({
                    message: '請填寫規格【' + this.ruleForm3[len].spec + '】使用條件設定！',
                    offset: 100,
                    duration: this.duration
                  });
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                } else if (repeat.size != 0) {
                  this.$notify.error({
                    message: '注意！規格排序編號重複',
                    offset: 100,
                    duration: this.duration
                  });
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                } else if (len === this.ruleForm3.length - 1) {
                  for (len = 0; len < this.ruleForm3.length; len++) {
                    this.ruleForm3[len].ten_million = (this.ruleForm3[len].ten_million === '' || this.ruleForm3[len].ten_million === ' ') ? 0 : this.ruleForm3[len].ten_million;
                    this.ruleForm3[len].million = (this.ruleForm3[len].million === '' || this.ruleForm3[len].million === ' ') ? 0 : this.ruleForm3[len].million;
                    this.ruleForm3[len].thousands = (this.ruleForm3[len].thousands === '' || this.ruleForm3[len].thousands === ' ') ? 0 : this.ruleForm3[len].thousands;
                    this.ruleForm3[len].hundreds = (this.ruleForm3[len].hundreds === '' || this.ruleForm3[len].hundreds === ' ') ? 0 : this.ruleForm3[len].hundreds;
                    this.ruleForm3[len].tens = (this.ruleForm3[len].tens === '' || this.ruleForm3[len].tens === ' ') ? 0 : this.ruleForm3[len].tens;
                    this.ruleForm3[len].ones = (this.ruleForm3[len].ones === '' || this.ruleForm3[len].ones === ' ') ? 0 : this.ruleForm3[len].ones;
                    this.ruleForm3[len].c_price = this.ruleForm3[len].c_price.toString().replace(/^0+/, '');
                    this.ruleForm3[len].s_price = this.ruleForm3[len].s_price.toString().replace(/^0+/, '');
                    this.ruleForm3[len].salenum = (Number(this.ruleForm3[len].salenum) !== 0) ? this.ruleForm3[len].salenum.toString().replace(/^0+/, '') : 0;
                  }
                  this.steps += 1;
                  this.activeName = 'step' + (this.steps + 1);
                  break;
                }
              }
            } else if(this.ticketRadio === 1) {
              //商品有票種/屬性
              for (len = 0; len < this.ruleForm3.length; len++) {
                var ticketResult = new Set();
                var ticketRepeat = new Set();
                this.ruleForm3[len].items.forEach(item => {
                  ticketResult.has(item.sortnum) ? ticketRepeat.add(item.sortnum) : ticketResult.add(item.sortnum);
                });
                for (item_len = 0; item_len < this.ruleForm3[len].items.length; item_len++) {
                  let item_check_sp = this.ruleForm3[len].items[item_len].ten_million + this.ruleForm3[len].items[item_len].million +
                    this.ruleForm3[len].items[item_len].thousands + this.ruleForm3[len].items[item_len].hundreds +
                    this.ruleForm3[len].items[item_len].tens + this.ruleForm3[len].items[item_len].ones;
                  item_check_sp = (item_check_sp.replace(/\b(0+)/gi, "").replace(/^\s+|\s+$/g, '') === '') ? 0 : item_check_sp.replace(/\b(0+)/gi, "").trim();
                  // console.log(Number(item_check_sp));
                  //確認無空格
                  if (this.ruleForm3[len].sortnum === '' || this.ruleForm3[len].spec === '') {
                    this.$notify.error({
                      message: '請填寫規格排序及名稱！',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  } else if (this.ruleForm3[len].items[item_len].sortnum === '' || this.ruleForm3[len].items[item_len].spec === '') {
                    this.$notify.error({
                      message: (this.isphysical)?'請填寫屬性排序及名稱！':'請填寫票種排序及名稱！',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  // } else if (this.identity === 1 && this.ruleForm3[len].specTime === null) {
                  //   this.ruleForm3[len].specTime = this.ruleForm1.prodSaleTime;
                  // } else if (this.identity === 1 && this.ruleForm3[len].specTime.length !== 2) {
                  //   this.ruleForm3[len].specTime = this.ruleForm1.prodSaleTime;
                  } else if (this.identity === 1 && this.ruleForm3[len].items[item_len].specTime !== null
                    && this.ruleForm3[len].items[item_len].specTime.length === 2
                    && (this.ruleForm1.martTime[0] > this.ruleForm3[len].items[item_len].specTime[0]
                      || this.ruleForm1.martTime[1] < this.ruleForm3[len].items[item_len].specTime[1])) {
                    this.$notify.error({
                      message: (this.isphysical)?
                      '屬性【' + this.ruleForm3[len].items[item_len].spec + '】的『停開賣時間』必須在『賣場上下架時間』內':'票種【' + this.ruleForm3[len].items[item_len].spec + '】的『停開賣時間』必須在『賣場上下架時間』內',
                      offset: 100,
                      duration: this.duration + 1500
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  } else if(this.ruleForm3[len].items[item_len].c_price === '' || this.ruleForm3[len].items[item_len].s_price === ''){
                    this.$notify.error({
                      message: (this.isphysical)?
                      '請完整填寫屬性【' + this.ruleForm3[len].items[item_len].spec + '】價格！':'請完整填寫票種【' + this.ruleForm3[len].items[item_len].spec + '】價格！',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  //驗證中文
                  } else if (!(/^(0|[1-9]\d*)$/.test(Number(this.ruleForm3[len].items[item_len].c_price))) ||
                    !(/^(0|[1-9]\d*)$/.test(Number(this.ruleForm3[len].items[item_len].s_price))) ||
                    !(/^(0|[1-9]\d*)$/.test(Number(this.ruleForm3[len].items[item_len].salenum)))) {
                    this.$notify.error({
                      message: (this.isphysical)?
                      '請檢查屬性【' + this.ruleForm3[len].spec + '】的『定價』、『售價』、『商品可賣量』是否含有中文！':'請檢查票種【' + this.ruleForm3[len].spec + '】的『定價』、『售價』、『商品可賣量』是否含有中文！',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  //再次確認售價正確
                  } else if (Number(this.ruleForm3[len].items[item_len].s_price) !== Number(item_check_sp)) {
                    this.$notify.error({
                      message: (this.isphysical)?'請再次確認屬性【' + this.ruleForm3[len].items[item_len].spec + '】售價！':'請再次確認票種【' + this.ruleForm3[len].items[item_len].spec + '】售價！',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  } else if (Number(item_check_sp) === 0) {
                    this.$notify.error({
                      message: (this.isphysical)?'請注意屬性【' + this.ruleForm3[len].items[item_len].spec + '】售價為零！':'請注意票種【' + this.ruleForm3[len].items[item_len].spec + '】售價為零！',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  } else if (Number(this.ruleForm3[len].items[item_len].s_price) > Number(this.ruleForm3[len].items[item_len].c_price)) {
                    this.$notify.error({
                      message: (this.isphysical)?
                      '屬性【' + this.ruleForm3[len].items[item_len].spec + '】『售價』大於『定價』，請再次確認售價或定價！':'票種【' + this.ruleForm3[len].items[item_len].spec + '】『售價』大於『定價』，請再次確認售價或定價！',
                      offset: 100,
                      duration: this.duration + 1500
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  } else if(this.ruleForm3[len].items[item_len].salenum === ''){
                    this.$notify.error({
                      message: (this.isphysical)?'請填寫屬性【' + this.ruleForm3[len].items[item_len].spec + '】可賣量！':'請填寫票種【' + this.ruleForm3[len].items[item_len].spec + '】可賣量！',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  } else if(this.ruleForm3[len].items[item_len].checkAutoUpdate && (this.ruleForm3[len].items[item_len].autoUpdateLow === '' || this.ruleForm3[len].items[item_len].autoUpdateSaleNum === '')){
                    this.$notify.error({
                      message: (this.isphysical)?'請填寫屬性【' + this.ruleForm3[len].spec + '】自動更新可賣量規則！':'請填寫票種【' + this.ruleForm3[len].spec + '】自動更新可賣量規則！',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  // } else if (this.ruleForm3[len].items[item_len].groupTicketRadio === 1 && this.ruleForm3[len].items[item_len].groupTicketNum === '') {
                  //   this.$notify.error({
                  //     message: '請填寫票種【' + this.ruleForm3[len].items[item_len].spec + '】團體票包含數量！',
                  //     offset: 100,
                  //     duration: this.duration
                  //   });
                  //   this.activeName = 'step' + (this.steps + 1);
                  //   break;
                  } else if (this.identity === 1 && !this.isphysical && this.ruleForm3[len].items[item_len].apiParams === '') {
                    this.$notify.error({
                      message: (this.isphysical)?'請選擇屬性【' + this.ruleForm3[len].items[item_len].spec + '】API參數':'請選擇票種【' + this.ruleForm3[len].items[item_len].spec + '】API參數',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  } else if (this.identity === 1 && this.ruleForm3[len].items[item_len].invoiceRadio === '') {
                    this.$notify.error({
                      message: (this.isphysical)?'請選擇屬性【' + this.ruleForm3[len].items[item_len].spec + '】開立發票規則':'請選擇票種【' + this.ruleForm3[len].items[item_len].spec + '】開立發票規則',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  } else if (this.identity === 1 && this.ruleForm3[len].items[item_len].handling === '') {
                    this.$notify.error({
                      message: (this.isphysical)?'請填寫屬性【' + this.ruleForm3[len].items[item_len].spec + '】手續費':'請選擇票種【' + this.ruleForm3[len].items[item_len].spec + '】手續費',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  } else if(!this.isphysical && this.ruleForm3[len].items[item_len].useConditions === ''){
                    this.$notify.error({
                      message: (this.isphysical)?'請填寫屬性【' + this.ruleForm3[len].items[item_len].spec + '】使用條件設定！':'請填寫票種【' + this.ruleForm3[len].items[item_len].spec + '】使用條件設定！',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  } else if (repeat.size != 0) {
                    this.$notify.error({
                      message: '注意！規格排序編號重複',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  } else if (ticketRepeat.size != 0) {
                    this.$notify.error({
                      message: (this.isphysical)?'注意！屬性排序編號重複':'注意！票種排序編號重複',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  } else if ((len === this.ruleForm3.length - 1) && (item_len === this.ruleForm3[len].items.length - 1)) {
                    for (len = 0; len < this.ruleForm3.length; len++) {
                      for (item_len = 0; item_len < this.ruleForm3[len].items.length; item_len++) {
                        this.ruleForm3[len].items[item_len].ten_million =
                          (this.ruleForm3[len].items[item_len].ten_million === '' || this.ruleForm3[len].items[item_len].ten_million === ' ') ? 0 : this.ruleForm3[len].items[item_len].ten_million;
                        this.ruleForm3[len].items[item_len].million =
                          (this.ruleForm3[len].items[item_len].million === '' || this.ruleForm3[len].items[item_len].million === ' ') ? 0 : this.ruleForm3[len].items[item_len].million;
                        this.ruleForm3[len].items[item_len].thousands =
                          (this.ruleForm3[len].items[item_len].thousands === '' || this.ruleForm3[len].items[item_len].thousands === ' ') ? 0 : this.ruleForm3[len].items[item_len].thousands;
                        this.ruleForm3[len].items[item_len].hundreds =
                          (this.ruleForm3[len].items[item_len].hundreds === '' || this.ruleForm3[len].items[item_len].hundreds === ' ') ? 0 : this.ruleForm3[len].items[item_len].hundreds;
                        this.ruleForm3[len].items[item_len].tens =
                          (this.ruleForm3[len].items[item_len].tens === '' || this.ruleForm3[len].items[item_len].tens === ' ') ? 0 : this.ruleForm3[len].items[item_len].tens;
                        this.ruleForm3[len].items[item_len].ones =
                          (this.ruleForm3[len].items[item_len].ones === '' || this.ruleForm3[len].items[item_len].ones === ' ') ? 0 : this.ruleForm3[len].items[item_len].ones;
                        this.ruleForm3[len].items[item_len].c_price =
                          this.ruleForm3[len].items[item_len].c_price.toString().replace(/^0+/, '');
                        this.ruleForm3[len].items[item_len].s_price =
                          this.ruleForm3[len].items[item_len].s_price.toString().replace(/^0+/, '');
                        this.ruleForm3[len].items[item_len].salenum =
                          (Number(this.ruleForm3[len].items[item_len].salenum) !== 0) ? this.ruleForm3[len].items[item_len].salenum.toString().replace(/^0+/, '') : 0;
                      }
                    }
                    this.steps += 1;
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  }
                }
              }
              break;
            }
          }
          break;
        case 'step4':
          if(this.isphysical){
            let tablesta = false;
            this.tableData.forEach(item => {
              (item.min !== '' && item.max !== '' && item.price !== '') ? tablesta = true: tablesta = false;
            });
            if (this.ruleForm4.fare === 'num') {
              if (tablesta === false) {
                this.$notify.error({
                  message: '請完整填寫運費區間！',
                  offset: 100,
                  duration: this.duration
                });
                this.activeName = 'step' + (this.steps + 1);
                break;
              } else {
                // console.log(this.tableData.length);
                for (len4 = 0; len4 < this.tableData.length; len4++) {
                  if (!(/^(0|[1-9]\d*)$/.test(Number(this.tableData[len4].min))) ||
                    !(/^(0|[1-9]\d*)$/.test(Number(this.tableData[len4].max))) ||
                    !(/^(0|[1-9]\d*)$/.test(Number(this.tableData[len4].price)))) {
                    this.$notify.error({
                      message: '運費區間規則請勿填寫中文！',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  } else if (Number(this.tableData[0].min) != 1) {
                    this.$notify.error({
                      message: '第一區間的件數小要為『1』！',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  } else if (Number(this.tableData[len4].max) <= Number(this.tableData[len4].min)) {
                    this.$notify.error({
                      message: '件數大必須『大於』件數小！',
                      offset: 100,
                      duration: this.duration
                    });
                    this.activeName = 'step' + (this.steps + 1);
                    break;
                  } else if (len4 != this.tableData.length - 1) {
                    if ((Number(this.tableData[len4 + 1].min) - Number(this.tableData[len4].max)) != 1) {
                      this.$notify.error({
                        message: '運費區間『件數小』的值為『上一個件數大』的值加１！',
                        offset: 100,
                        duration: this.duration + 1500
                      });
                      this.activeName = 'step' + (this.steps + 1);
                      break;
                    }
                  } else {
                    //submit
                    this.handleSubmit();
                  }
                }
              }
            } else if (this.ruleForm4.fare === 'fix') {
              if (this.fix_fare === '') {
                this.$notify.error({
                  message: '請填寫固定運費！',
                  offset: 100,
                  duration: this.duration
                });
                this.activeName = 'step' + (this.steps + 1);
                break;
              } else if (!(/^(0|[1-9]\d*)$/.test(Number(this.fix_fare)))) {
                this.$notify.error({
                  message: '固定運費請勿填寫中文！',
                  offset: 100,
                  duration: this.duration
                });
                this.activeName = 'step' + (this.steps + 1);
                break;
              } else if (Number(this.fix_fare) === 0) {
                this.$notify.error({
                  message: '固定運費不可為0！（或選擇免運費）',
                  offset: 100,
                  duration: this.duration
                });
                this.activeName = 'step' + (this.steps + 1);
                break;
              } else {
                //submit
                this.handleSubmit();
              }
            } else {
              //submit
              this.handleSubmit();
            }
          }
          else if(!this.isphysical){
            if(this.ruleForm4.place === ''){
              this.$notify.error({
                message: '請填寫地名(店名)',
                offset: 100,
                duration: this.duration
              });
              this.activeName = 'step' + (this.steps + 1);
              break;
            }
            else if(this.ruleForm4.address === ''){
              this.$notify.error({
                message: '請完整填寫地址',
                offset: 100,
                duration: this.duration
              });
              this.activeName = 'step' + (this.steps + 1);
              break;
            }
            else if(this.ruleForm4.bookUseTime === ''){
              this.$notify.error({
                message: '請選擇是否可預定使用時間',
                offset: 100,
                duration: this.duration
              });
              this.activeName = 'step' + (this.steps + 1);
              break;
            }
            else if(this.identity === 1 && this.ruleForm4.apiNo === ''){
              this.$notify.error({
                message: '請選擇商品API編號',
                offset: 100,
                duration: this.duration
              });
              this.activeName = 'step' + (this.steps + 1);
              break;
            }
            else{
              //submit
              this.handleSubmit();
            }
          }
      }
    },
    // step1
    uploadOverrun(){
      this.get_filenum = 5;
      this.$message.error('最多僅能上傳五張圖片');
    },
    prodImageUpload(file, url, uid) {
      this.get_filenum += 1;
      this.ruleForm1.origin_product_imgs.push({
        file: file,
        url: url,
        sort: this.get_filenum
      })
      this.ruleForm1.product_imgs = this.ruleForm1.origin_product_imgs;
      this.cropDialogVisible = false;
    },
    handleRemove(file, fileList) {
      this.get_filenum = fileList.length;
      let orgIndex = this.ruleForm1.origin_product_imgs.findIndex(val => val.uid === file.uid);
      if(orgIndex != -1){
        if(file.id){
          this.ruleForm1.deleted_origin_imgs.push(file.id);
        }
        this.ruleForm1.origin_product_imgs.splice(orgIndex, 1);
      }
      this.ruleForm1.product_imgs = this.ruleForm1.origin_product_imgs;
    },
    handleChange(file, fileList){
      if (!file) return;
      const isImage = file.raw.type === 'image/jpeg' || file.raw.type === 'image/png' || file.raw.type === 'image/gif';
      const isLt6M = file.size / 1024 / 1024 <= 6;

      if (!isImage) {
        this.$message.error('上傳圖片格式只能是jpg、png、gif格式!');
        let index = fileList.findIndex(val => val.uid === file.uid);
        fileList.splice(index, 1);
      }
      else if (!isLt6M) {
        this.$message.error('上傳圖片大小不能大於6MB!');
        let index = fileList.findIndex(val => val.uid === file.uid);
        fileList.splice(index, 1);
      }
      else{
        if(!this.isphysical){
          this.cropOption.fixedNumber = [8, 3];
          this.cropOption.autoCropWidth = 480;
          this.cropOption.autoCropHeight = 180;
        }
        this.cropDialogVisible = true;
        this.cropOption.img = file;
      }
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    },
    handleCheckAllChange(val) {
      this.ruleForm1.checkedPayment = val ? paymentOptions : [];
    },
    handleCheckedPaymentChange(value) {
      let checkedCount = value.length;
      this.checkAll = checkedCount === this.payment.length;
      this.isIndeterminate = checkedCount > 0 && checkedCount < this.payment.length;
    },
    // step3
    addspec() {
      if (this.identity === 1) {
        this.ruleForm3.push({
          sortnum: (this.ruleForm3.length === 0) ? 1 : this.ruleForm3[this.ruleForm3.length - 1].sortnum + 1,
          spec: '',
          specTime: '',
          items: (this.ticketRadio === 0) ? [] : [{
            sortnum: 1,
            spec: '',
            specTime: '',
            c_price: '',
            s_price: '',
            priceagain: '',
            salenum: '',
            checkAutoUpdate: false,
            autoUpdateLow: '',
            autoUpdateSaleNum: '',
            ten_million: '',
            million: '',
            thousands: '',
            hundreds: '',
            tens: '',
            ones: '',
            groupTicketRadio: 0,
            groupTicketNum: 1,
            apiParams: '',
            invoiceRadio: '',
            handling: '',
            useConditions: 1
          }],
          c_price: '',
          s_price: '',
          priceagain: '',
          salenum: '',
          checkAutoUpdate: false,
          autoUpdateLow: '',
          autoUpdateSaleNum: '',
          ten_million: '',
          million: '',
          thousands: '',
          hundreds: '',
          tens: '',
          ones: '',
          groupTicketRadio: 0,
          groupTicketNum: 1,
          apiParams: '',
          invoiceRadio: '',
          handling: '',
          useConditions: 1
        });
      } else {
        this.ruleForm3.push({
          sortnum: (this.ruleForm3.length === 0) ? 1 : this.ruleForm3[this.ruleForm3.length - 1].sortnum + 1,
          spec: '',
          items: (this.ticketRadio === 0) ? [] : [{
            sortnum: 1,
            spec: '',
            c_price: '',
            s_price: '',
            priceagain: '',
            salenum: '',
            checkAutoUpdate: false,
            autoUpdateLow: '',
            autoUpdateSaleNum: '',
            ten_million: '',
            million: '',
            thousands: '',
            hundreds: '',
            tens: '',
            ones: '',
            groupTicketRadio: 0,
            groupTicketNum: 1,
            useConditions: 1
          }],
          c_price: '',
          s_price: '',
          priceagain: '',
          salenum: '',
          checkAutoUpdate: false,
          autoUpdateLow: '',
          autoUpdateSaleNum: '',
          ten_million: '',
          million: '',
          thousands: '',
          hundreds: '',
          tens: '',
          ones: '',
          groupTicketRadio: 0,
          groupTicketNum: 1,
          useConditions: 1
        });
      }
    },
    addTicket(index) {
      if (this.identity === 1) {
        this.ruleForm3[index].items.push({
          sortnum: (this.ruleForm3[index].items.length === 0) ? 1 : this.ruleForm3[index].items[this.ruleForm3[index].items.length - 1].sortnum + 1,
          spec: '',
          specTime: '',
          c_price: '',
          s_price: '',
          priceagain: '',
          salenum: '',
          checkAutoUpdate: false,
          autoUpdateLow: '',
          autoUpdateSaleNum: '',
          ten_million: '',
          million: '',
          thousands: '',
          hundreds: '',
          tens: '',
          ones: '',
          groupTicketRadio: 0,
          groupTicketNum: 1,
          apiParams: '',
          invoiceRadio: '',
          handling: '',
          useConditions: 1
        });
      } else {
        this.ruleForm3[index].items.push({
          sortnum: (this.ruleForm3[index].items.length === 0) ? 1 : this.ruleForm3[index].items[this.ruleForm3[index].items.length - 1].sortnum + 1,
          spec: '',
          c_price: '',
          s_price: '',
          priceagain: '',
          salenum: '',
          checkAutoUpdate: false,
          autoUpdateLow: '',
          autoUpdateSaleNum: '',
          ten_million: '',
          million: '',
          thousands: '',
          hundreds: '',
          tens: '',
          ones: '',
          groupTicketRadio: 0,
          groupTicketNum: 1,
          useConditions: 1
        });
      }
    },
    // step4
    onChange(val) {
      this.fix_fare = val;
    },
    addTag(newTag) {
      const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
      };
      this.tag_options.push(tag);
      this.tag_value.push(tag);
    },
    fullScreen(action) {
      const loading = this.$loading({
        lock: true,
        text: 'Loading',
        spinner: 'el-icon-loading',
        background: 'rgba(0, 0, 0, 0.7)'
      });
      if (action == 'close') {
        setTimeout(() => {
          loading.close();
        }, 500);
      }
    },
    handleSubmit() {
      this.$confirm('確定要送出商品資料？', {
        confirmButtonText: '確定',
        cancelButtonText: '取消',
        type: 'warning',
        center: true
      }).then(() => {
        var vm = this;
        var formData = new FormData();
        vm.fullScreen('open');

        if ( vm.isphysical == 1) {   // 實體商品
            formData.append('prod[shipping]', this.ruleForm4.fare);
            switch(this.ruleForm4.fare){
                case 'num':
                    for (var key in this.tableData) {
                        formData.append('shipping_fee[' + key + '][lower]', this.tableData[key]['min']);
                        formData.append('shipping_fee[' + key + '][upper]', this.tableData[key]['max']);
                        formData.append('shipping_fee[' + key + '][fee]', this.tableData[key]['price']);
                      }
                    break;
                case 'fix':
                    formData.append('shipping_fee[new_1][fee]', this.fix_fare);
                    break;
                default:
                    formData.append('shipping_fee[new_1][fee]', 0);
                    break;
            }
        } else {  // 虛擬商品
            formData.append('prod[expire_type]', this.ruleForm1.effectiveTimeRadio);
            switch(this.ruleForm1.effectiveTimeRadio){
                case 1 :
                    formData.append('prod[expire_daycount]', this.ruleForm1.effectiveTimeDay);
                    break;
                case 2 :
                    formData.append('prod[expire_due]', this.ruleForm1.effectiveTimeDate);
                    break;
                case 3 :
                    formData.append('prod[expire_start]', this.ruleForm1.effectiveTimeRange[0]);
                    formData.append('prod[expire_due]', this.ruleForm1.effectiveTimeRange[1]);
                    break;
            }
            formData.append('prod[bookable]', this.ruleForm4.bookUseTime);
            formData.append('prod[address]', this.ruleForm4.address);
            formData.append('prod[zipcode]', this.$refs.twzipcode.zipcode);
            formData.append('prod[district]', this.$refs.twzipcode.district);
            formData.append('prod[county]', this.$refs.twzipcode.county);
            formData.append('prod[store]', this.ruleForm4.place);
            formData.append('shipping_fee[new_1][fee]', 0);
        }

        formData.append('prod[name]', this.ruleForm2.product_name);
        formData.append('prod[short]', this.ruleForm2.sale_content);
        formData.append('prod[tabs1]', this.ruleForm2.product_title1);
        formData.append('prod[tabs2]', this.ruleForm2.product_title2);
        formData.append('prod[tabs3]', this.ruleForm2.product_title3);
        formData.append('prod[desc1]', CKEDITOR.instances.product_content1.getData());
        formData.append('prod[desc2]', CKEDITOR.instances.product_content2.getData());
        formData.append('prod[desc3]', CKEDITOR.instances.product_content3.getData());
        formData.append('prod[on_search]', this.ruleForm4.onSearchRadio);
        formData.append('prod[status]', this.ruleForm4.stata_radio);

        for (var key in this.tag_value) {
          if (typeof this.tag_value[key]['id'] != 'undefined') {
            formData.append('prod_keyword[' + this.tag_value[key]['id'] + ']', this.tag_value[key]['name']);
          } else {
            formData.append('prod_keyword[' + this.tag_value[key]['code'] + ']', this.tag_value[key]['name']);
          }
        }

        // 規格
        for (var key in this.ruleForm3) {
          if (typeof this.ruleForm3[key]['spec_id'] === 'undefined') {
            var spec_key = 'new_' + key;
          } else {
            var spec_key = this.ruleForm3[key]['spec_id'];
          }
          formData.append('prod_spec[' + spec_key + '][name]', this.ruleForm3[key]['spec']);
          formData.append('prod_spec[' + spec_key + '][sort]', this.ruleForm3[key]['sortnum']);

            // 無票種
          if (this.specTypeChange == 0) {
            if (typeof this.ruleForm3[key]['price_id'] === 'undefined') {
              var price_key = 'new_' + key;
            } else {
              var price_key = this.ruleForm3[key]['price_id'];
            }
            var spec_price_key = 'prod_spec_price[' + spec_key + '][' + price_key + ']';
            formData.append(spec_price_key + '[sort]', 1);
            this.appendRuleForm3(spec_price_key, this.ruleForm3[key], formData);

            // 有票種
          } else {
              for (var items_key in this.ruleForm3[key].items) {
                var ruleForm3_item = this.ruleForm3[key].items[items_key];
                if (typeof ruleForm3_item['price_id'] === 'undefined') {
                  var price_key = 'new_' + key + '_' + items_key;
                } else {
                  var price_key = ruleForm3_item['price_id'];
                }
                var spec_price_key = 'prod_spec_price[' + spec_key + '][' + price_key + ']';
                formData.append(spec_price_key + '[sort]', ruleForm3_item['sortnum']);
                this.appendRuleForm3(spec_price_key, ruleForm3_item, formData);
              }
          }
        }

        for (var i = 0; i < this.ruleForm1.product_imgs.length; i++) {
          if (typeof this.ruleForm1.product_imgs[i].file == 'undefined') {
            formData.append('prod_img[' + this.ruleForm1.product_imgs[i].sort + ']', this.ruleForm1.product_imgs[i].id);
          } else {
            formData.append('prod_img[' + this.ruleForm1.product_imgs[i].sort + ']', this.ruleForm1.product_imgs[i].file);
          }
        }
        formData.append('deleted_origin_imgs', JSON.stringify(this.ruleForm1.deleted_origin_imgs));
        formData.append('tag_prod[top_tag]', parseInt(this.ruleForm1.categoryValue));
        formData.append('tag_prod[sub_tag]', parseInt(this.ruleForm1.subCategoryValue));
        formData.append('_method', 'PUT');
        if (this.identity == 1) {
          formData.append('prod[onsale_time]', this.ruleForm1.prodSaleTime[0]);
          formData.append('prod[offsale_time]', this.ruleForm1.prodSaleTime[1]);
          formData.append('prod[onshelf_time]', this.ruleForm1.martTime[0]);
          formData.append('prod[offshelf_time]', this.ruleForm1.martTime[1]);
          if (vm.isphysical != 1) {
            formData.append('prod[api]', this.ruleForm4.apiNo);
          }
        }
        formData.append('prod[limit_type]', this.ruleForm1.buyNumValue);
        formData.append('prod[limit_num]', this.ruleForm1.buyNum);
        formData.append('prod[payment_linepay]', this.ruleForm1.checkedPayment.indexOf('LinePay') !== -1 ? 1 : 0);
        formData.append('prod[payment_credit_once]', this.ruleForm1.checkedPayment.indexOf('信用卡一次付清') !== -1 ? 1 : 0);
        formData.append('prod[payment_virtual_atm]', this.ruleForm1.checkedPayment.indexOf('ATM虛擬帳號') !== -1 ? 1 : 0);
        formData.append('prod[payment_applepay]', this.ruleForm1.checkedPayment.indexOf('ApplePay') !== -1 ? 1 : 0);
        formData.append('prod[payment_googlepay]', this.ruleForm1.checkedPayment.indexOf('GooglePay') !== -1 ? 1 : 0);
        formData.append('prod[payment_taiwanpay]', this.ruleForm1.checkedPayment.indexOf('台灣Pay') !== -1 ? 1 : 0);
        formData.append('prod[is_reviewing_edited]', backend_data.identity == 1 ? 1 : 0);

        axios.post(urls.vendor_prod_update, formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then(function(res) {
          let data = res.data;
          if (data.code == '00000') {
            vm.$notify.success({
              title: "成功",
              message: "儲存成功",
              duration: vm.duration
            });

            location.href = urls.vendor_prod_index;
          } else {
            vm.$notify.error({
              title: '儲存失敗',
              message: '系統有誤',
              duration: vm.duration,
            });
            console.log(data.message);
          }
          vm.fullScreen('close');
        })
        .catch(function(e) {
          if (typeof e.response !== 'undefined' && e.response.status == 422) {
            for (var key in e.response.data.errors) {
              vm.$notify.error({
                title: '資料格式有誤',
                message: e.response.data.errors[key],
                duration: vm.duration,
              });
            }
          } else {
            vm.$notify.error({
              title: '儲存失敗',
              message: '未知錯誤',
              duration: vm.duration,
            });
          }
          vm.fullScreen('close');
        });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: '已取消送出'
        });
      });
    },
    handleCategoryValue() {
      var vm = this;
      axios.get(urls.subtags + '/' + vm.ruleForm1.categoryValue).then(function(res) {
          let data = res.data;
          if (data.code == '00000') {
            let sub_tags = data.data;
            let option_sub_tags = [];
            for (key in sub_tags) {
              option_sub_tags.push({
                'value': sub_tags[key]['tag_id'],
                'label': sub_tags[key]['tag_name']
              });
            }
            vm.ruleForm1.subCategoryOptions = option_sub_tags;
            vm.ruleForm1.subCategoryValue = '';
          } else {
            vm.$notify.error({
              title: '取得子分類有誤',
              message: '系統有誤'
            });
          }
        })
        .catch(function(e) {
          vm.$notify.error({
            title: '取得子分類有誤',
            message: '未知錯誤'
          });
        });
    },
    close() {
      this.$confirm('確定要離開此頁面？', {
        confirmButtonText: '確定',
        cancelButtonText: '取消',
        type: 'warning',
        center: true
      }).then(() => {
        location.href = urls.vendor_prod_index;
      }).catch(() => {
        this.$message({
          type: 'info',
          message: '已取消關閉'
        });
      });
    },
    review() {
      this.$confirm('確定要送出審核？', {
        confirmButtonText: '確定',
        cancelButtonText: '取消',
        type: 'warning',
        center: true
      }).then(() => {
        var vm = this;
        axios.get(urls.update_review_status).then(function(res) {
          let data = res.data;
          if (data.code == '00000') {
            location.href = urls.vendor_prod_index;
          } else {
            vm.$notify.error({
              title: '審核有誤',
              message: '系統有誤'
            });
          }
        }).catch(() => {
          vm.$notify.error({
            title: '審核有誤',
            message: '系統有誤'
          });
        });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: '已取消送出審核'
        });
      });
    },
    changeSpecType(){},
    appendRuleForm3(spec_price_key, ruleForm3_item, formData){

        formData.append(spec_price_key + '[name]', ruleForm3_item['spec']);
        formData.append(spec_price_key + '[list]', ruleForm3_item['c_price']);
        formData.append(spec_price_key + '[value]', ruleForm3_item['s_price']);
        formData.append(spec_price_key + '[stock]', ruleForm3_item['salenum']);
        formData.append(spec_price_key + '[iscompany]', ruleForm3_item['groupTicketRadio']);
        formData.append(spec_price_key + '[company_qty]', ruleForm3_item['groupTicketNum']);
        formData.append(spec_price_key + '[stock_auto]', ruleForm3_item['checkAutoUpdate'] ? 1 : 0);
        if (ruleForm3_item['checkAutoUpdate']) {    // 自動更新庫存
          formData.append(spec_price_key + '[stock_low]', ruleForm3_item['autoUpdateLow']);
          formData.append(spec_price_key + '[stock_to]', ruleForm3_item['autoUpdateSaleNum']);
        }
        if ( this.isphysical != 1) {  // 票券
          formData.append(spec_price_key + '[use_note]', 1);
          formData.append(spec_price_key + '[use_note_value]', ruleForm3_item['useConditions']);
        }
        if (this.identity == 1) {   // 審核
            if (ruleForm3_item['specTime'] != '' && ruleForm3_item['specTime'] != null) {
                formData.append(spec_price_key + '[onsale_time]', ruleForm3_item['specTime'][0]);
                formData.append(spec_price_key + '[offsale_time]', ruleForm3_item['specTime'][1]);
            } else {
                formData.append(spec_price_key + '[onsale_time]', '');
                formData.append(spec_price_key + '[offsale_time]', '');
            }
            if ( this.isphysical != 1) {
                formData.append(spec_price_key + '[api_code]', ruleForm3_item['apiParams']);
            }
          formData.append(spec_price_key + '[recipient_type]', ruleForm3_item['invoiceRadio']);
          formData.append(spec_price_key + '[fee]', ruleForm3_item['handling']);
        }
    }
  }
});
