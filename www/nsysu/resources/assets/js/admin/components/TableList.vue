<template>
  <div class="table-list">
    <el-table :data="tableData" :header-cell-style="headerRowStyle" :row-style="tableRowStyle" border style="width: 100%" :default-sort= "{prop: tableProp, order: tableOrder}"
    v-loading="loading" element-loading-text="等我一下..." :default-expand-all="expandTableConfig.expandAll">
      <el-table-column fixed="left" type="selection" width="35" v-if="showCheckbox" align="center">
      </el-table-column>
      <el-table-column fixed="left" v-else width="1">
      </el-table-column>

      <el-table-column :fixed="fixedConfig.align" v-if="costomColConfig.show && fixedConfig.fixed" :label="costomColConfig.label" :align="costomColConfig.align" :width="costomColConfig.width" sortable>
        <template slot-scope="props">
          <slot name="costomBox" :row="props.row"></slot>
        </template>
      </el-table-column>

      <el-table-column v-if="costomColConfig.show && !fixedConfig.fixed" :label="costomColConfig.label" :align="costomColConfig.align" :width="costomColConfig.width" sortable>
        <template slot-scope="props">
          <slot name="costomBox" :row="props.row"></slot>
        </template>
      </el-table-column>

      <el-table-column v-if="expandTableConfig.show" :label="expandTableConfig.label" :align="expandTableConfig.align" :width="expandTableConfig.width" type="expand">
        <template slot-scope="props">
          <slot name="expandBox" :row="props.row"></slot>
        </template>
      </el-table-column>

      <div v-for="(row, key) in fields" :key="key">
        <el-table-column v-if="row.prop === 'sort'" :width="row.width" align="center" :label="row.label">
          <template slot-scope="props">
            <el-input v-if="row.isInput" type="number" placeholder="" v-model="props.row.sort" style="width:100%;" :min="1"></el-input>
            <span v-else style="width:100%;">{{row.isInput}}{{props.row.sort}}</span>
          </template>
        </el-table-column>
        <el-table-column v-else-if="row.prop === 'img'" :prop="row.prop" :label="row.label" sortable align="center" :width="row.width">
          <template slot-scope="props">
            <img :src="props.row.img" width="100%"></img>
          </template>
        </el-table-column>
        <el-table-column v-else-if="row.custom" :label="row.label" sortable align="center" :width="row.width">
          <template slot-scope="props">
            <slot :name="row.prop" :row="props.row"></slot>
          </template>
        </el-table-column>
        <el-table-column v-else :prop="row.prop" :label="row.label" sortable align="center" :width="row.width">
        </el-table-column>
      </div>

      <el-table-column fixed="right" label="操作" :width="operateWidth" v-if="showOperate" align="center">
        <template slot-scope="scope">
          <el-button class="icon-button" v-if="showView" @click.prevent="onShow(scope.row)" type="warning" icon="el-icon-view" size="mini" round>檢視</el-button>
          <el-button class="icon-button" v-if="showEdit" @click.prevent="onEdit(scope.row)" type="primary" icon="el-icon-edit" size="mini" round>編輯</el-button>
          <el-button class="icon-button" v-if="showCopy" @click.prevent="onCopy(scope.row)" type="info" icon="el-icon-document" size="mini" round>複製</el-button>
          <el-button class="icon-button" v-if="showDelete" @click.prevent="onDel(scope.row, scope.$index)" type="danger" icon="el-icon-delete" size="mini" round>刪除</el-button>
          <!-- 整體客製btn -->
          <el-button class="icon-button" v-if="costomBtnConfig.show" @click.prevent="onClickCostomBtn(scope.row)" :type="costomBtnConfig.type" :icon="costomBtnConfig.icon" size="mini" round>{{ costomBtnConfig.text }}</el-button>
          <!-- 各列客製btn -->
          <el-button class="icon-button" v-if="costomItemBtnConfig.show && scope.row.showBtn" @click.prevent="onClickCostomItemBtn(scope.row)" :type="costomItemBtnConfig.type" :icon="costomItemBtnConfig.icon" size="mini" round>{{ costomItemBtnConfig.text }}</el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>
<script>
    export default {
        props: {
          fields:{
            type: Array,
            required: true,
            default: function () {
                return [];
            }
          },
          tableData:{
            type: Array,
            required: true,
            default: function () {
                return [];
            }
          },
          showCheckbox:{
            type: Boolean,
            default: false
          },
          showOperate:{
            type: Boolean,
            default: true
          },
          showView:{
            type: Boolean,
            default: false
          },
          showEdit:{
            type: Boolean,
            default: false
          },
          showCopy:{
            type: Boolean,
            default: false
          },
          showDelete:{
            type: Boolean,
            default: false
          },
          showReview:{
            type: Boolean,
            default: false
          },
          showCancel:{
            type: Boolean,
            default: false
          },
          showDetail:{
            type: Boolean,
            default: false
          },
          showPrint:{
            type: Boolean,
            default: false
          },
          showSearch:{
            type: Boolean,
            default: false
          },
          showReturn:{
            type: Boolean,
            default: false
          },
          tableProp:{
            type: String,
            default: ''
          },
          tableOrder:{
            type: String,
            default: 'null'
          },
          multiHeader:{
            type: Boolean,
            default: false
          },
          page:{
            type: String,
            default: ''
          },
          loading:{
            type: Boolean,
            default: false
          },
          expandTable: {
              type: Object,
              required: false,
              default: function () {
                  return {};
              }
          },
          costomCol: {
              type: Object,
              required: false,
              default: function () {
                  return {};
              }
          },
          costomBtn: {
              type: Object,
              required: false,
              default: function () {
                  return {};
              }
          },
          operateWidth: {
            type: Number,
            default: 100
          },
          fixed: {
            type: Object,
            default: function () {
                return {};
            }
          },
          costomItemBtn: {
              type: Object,
              required: false,
              default: function () {
                  return {};
              }
          }
        },
        data() {
          return{
            expandTableConfig: {
                expandAll: false,
                show: false,
                align: 'left',
                label: '',
                width: ''
            },
            costomColConfig: {
                show: false,
                align: 'left',
                label: '',
                width: '',
            },
            costomBtnConfig: {
                show: false,
                type: 'info',
                icon: '',
                text: ''
            },
            fixedConfig: {
                fixed: false,
                align: 'right',
            },
            costomItemBtnConfig: {
                show: false,
                type: 'info',
                icon: '',
                text: ''
            },
          }
        },
        created: function() {
            this.expandTableConfig = Object.assign(this.expandTableConfig, this.expandTable);
            this.costomColConfig = Object.assign(this.costomColConfig, this.costomCol);
            this.costomBtnConfig = Object.assign(this.costomBtnConfig, this.costomBtn);
            this.fixedConfig = Object.assign(this.fixedConfig, this.fixed);
            this.costomItemBtnConfig = Object.assign(this.costomItemBtnConfig, this.costomItemBtn);
        },
        methods: {
          onShow(row){
            this.$emit('on-show', row);
          },
          onEdit(row) {
            this.$emit('on-edit', row);
          },
          onCopy(row) {
            this.$emit('on-copy', row);
          },
          onDel(row,index) {
            this.$emit('on-del', row, index);
          },
          onReview(row){
            this.$emit('on-review', row);
          },
          onReturn(row){
            this.$emit('on-return', row);
          },
          onCancel(row){
            this.$emit('on-cancel', row);
          },
          onDetail(row){
            this.$emit('on-detail', row);
          },
          onPrint(row){
            this.$emit('on-print', row);
          },
          onSearch(row){
            this.$emit('on-search', row);
          },
          onClickCostomBtn(row){
            this.$emit('click-costom-btn', row);
          },
          onClickCostomItemBtn(row) {
            this.$emit('click-costom-item-btn', row);
          },
          tableRowStyle({row, rowIndex}){
            return 'background-color: #f5f7fa';//#f7fbff
          },
          headerRowStyle({row, column, rowIndex, columnIndex}){
            return 'background-color: #548FCC; color: #ffffff;';
          }
        }
    }
</script>