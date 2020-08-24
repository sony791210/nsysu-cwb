@extends('layouts.admin.main')

@section('content')


  <div class="bar">
    <div class="bar-left">
      <h3 v-if="!isEdit" class="title">@lang('admin/nav.createDiningCarNews')</h3>
      <h3 v-else-if="isEdit" class="title">@lang('admin/nav.editDiningCarNews')</h3>
    </div>
    <div class="bar-right"></div>
    
  </div>
  <div class="create-news-page">
    <el-form label-position="right" label-width="120px" :model="ruleForm">

  
      <el-form-item label="標題" required>
        <el-input v-model="ruleForm.title" placeholder="" :maxlength="25" :disabled="viewOnly"></el-input>
      </el-form-item>
  
      <el-form-item label="發布時間" required>
        <el-date-picker
          v-model="ruleForm.releaseTime"
          type="datetime"
          placeholder="選擇發布時間"
          format="yyyy-MM-dd HH:mm"
          value-format="yyyy-MM-dd HH:mm:ss"
          >
        </el-date-picker>
      </el-form-item>
   


      <el-form-item label="封面圖" required v-if="!isMobile">
        <div style="color:red;">可上傳一張封面圖片。格式：JPEG，圖片比例3:2。</div>
        <img-cropper-upload
        :img-list="ruleForm.news_imgs"
        :fixed-number="cropOption.fixedNumber"
        :auto-crop-width="cropOption.autoCropWidth"
        :auto-crop-height="cropOption.autoCropHeight"
        :limit=1 :img-type="['jpg']"
        id="cover-img" get-id="cover-img">
        </img-cropper-upload>
      </el-form-item>

      <el-form-item label="封面圖" required v-if="isMobile">
        <div style="color:red;">
            手機版不支援上傳圖片功能，請至電腦版上傳圖片。
        </div>
      </el-form-item>
  
      <el-form-item label="內容" required>
        <div v-if="isMobile" style="padding:20px 0;color:#236278;">
          (手機版增加圖片等部分功能不支援，如需完整功能請至電腦版。)
        </div>
        <textarea id="news_content" rows="10" cols="80" v-model="ruleForm.content" :disabled="viewOnly"></textarea>
      </el-form-item>
  
      <el-form-item label="狀態">
        <el-radio-group v-model="ruleForm.stataRadio" :disabled="viewOnly">
          <el-radio :label="1">開啟</el-radio>
          <el-radio :label="0">關閉</el-radio>
        </el-radio-group>
      </el-form-item>
  
      
    </el-form>

    <!-- button -->
    <next-btm :getstep="steps+1" :steplength="stepLength" @close="close" @dovalidate="dovalidate"></next-btm>
  
  </div>
  
@endsection

@section('script')
<script>
console.log(siteUrl);
$(function() {
  var ckeditorConfig = {
    language: 'zh-TW',
    height: 250,
    filebrowserImageBrowseUrl: siteUrl + '/laravel-filemanager?type=Images',
  };
  CKEDITOR.replace('news_content', ckeditorConfig);
})

var backend_data = {!! $data !!};

var app = new Vue({
    el: '#app',
    data() {
        return {
            steps: 0,
            stepLength:1,
            isMobile: false,
            isEdit:  backend_data.isEdit ,
            viewOnly: false,
            ruleForm:{
                content :'',
                title: backend_data.title,
                releaseTime: backend_data.release_time,
                news_imgs:backend_data.image,
                stataRadio:backend_data.status,
                content:backend_data.content,
                action :'create',
                id:backend_data.id
            },
            cropOption: {
                img: '',
                autoCropWidth: 480,
                autoCropHeight: 320,
                fixedNumber: [290, 178.95]
            },
        }
    },
    mounted() {
      let vm=this;
      console.log(vm.backend_data);

    },
    methods: {
        onHref(url) {
            location.href = url;
        },
        edit(row) {
            location.href = row.editUrl;
        },
        resetForm() {
            this.form = {
                name: '',
                displayName: '',
                email: ''
            };
        },
        dovalidate(){
          if(this.ruleForm.title === ''){
            this.errorMsg('請填寫標題');
          }
          else if(this.ruleForm.releaseTime === ''){
            this.errorMsg('請選擇發布時間');
          }
          else if(!this.isMobile && this.ruleForm.news_imgs.length < 1){
            this.errorMsg('請選擇上傳封面圖');
          }
          else if(!this.isMobile && this.ruleForm.news_imgs.length !== 1){
            this.errorMsg('只能上傳一張封面圖');
          }
          else if(CKEDITOR.instances.news_content.getData() === ''){
            this.errorMsg('請填寫內容');
          }
          else if(this.ruleForm.stataRadio === ''){
            this.errorMsg('請選擇狀態');
          }
          else{
            this.handleSubmit();
          }//end if
          
          
        },//dovalidate
        errorMsg(msg, dur = 0){
          this.$notify.error({
            message: msg,
            offset: 100,
            duration: this.duration + dur
          });
        },//end errorMsg
        close(){

        },//close
        handleSubmit(){
          
          var vm = this;
          console.log(vm.ruleForm.news_imgs);
          var formData = new FormData();
          
          formData.append('news[title]', vm.ruleForm.title);
          formData.append('news[release_time]', vm.ruleForm.releaseTime);
          formData.append('img[id]', vm.ruleForm.news_imgs[0].id || '');
          formData.append('img[file]', vm.ruleForm.news_imgs[0].file || '');
          formData.append('news[content]', CKEDITOR.instances.news_content.getData());
          formData.append('news[status]', vm.ruleForm.stataRadio);
          formData.append('news[id]', vm.ruleForm.id);
          axios.post(backend_data.urls.submitNewsfeed, formData).then(function(res) {
            let data = res.data;
            if (data.code == '00000') {
              vm.$notify.info({
                title: '儲存成功',
                message: '儲存成功'
              });
              location.href = backend_data.urls.index;
          } else {
            vm.$notify.error({
              title: '儲存失敗',
              message: '系統有誤'
            });
            console.log(data.message);
            vm.fullScreen('close');
          }
        }).catch(function(){
            vm.$notify.error({
              title: '儲存失敗',
              message: '系統有誤'
            });
            vm.fullScreen('close');
        });
      },//end handleSubmit
        
    }//methods
});
</script>
@endsection
