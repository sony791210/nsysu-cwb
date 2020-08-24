/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {

    // config.extraPlugins = 'font,a11yhelp,colorbutton,colordialog,find,selectall,print,pastefromword,preview,showblocks,smiley,tableresize,tableselection,bidi,copyformatting,table,iframe,iframedialog,liststyle,newpage,templates';
	// config.toolbarGroups = [
    //     { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
    //     { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
    //     { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
    //     { name: 'forms', groups: [ 'forms' ] },
    //     '/',
    //     { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    //     { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
    //     { name: 'links', groups: [ 'links' ] },
    //     { name: 'insert', groups: [ 'insert' ] },
    //     '/',
    //     { name: 'font', groups: [ 'styles' ] },
    //     // { name: 'styles', groups: [ 'styles' ] },
    //     { name: 'colors', groups: [ 'colors' ] },
    //     { name: 'tools', groups: [ 'tools' ] },
    //     { name: 'others', groups: [ 'others' ] },
    //     // { name: 'about', groups: [ 'about' ] }
    // ];
    config.toolbar = [['Image']]
    // config.toolbar = [
	// 	{ 
	// 		name: 'basicstyles', 
	// 		groups: [ 'basicstyles', 'cleanup' ], 
	// 		items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] 
	// 	},
	// 	{ 
	// 		name: 'colors', 
	// 		items: [ 'TextColor', 'BGColor' ] 
	// 	},
	// 	{ 
	// 		name: 'styles', 
	// 		items: [ 'Styles', 'Format'] 
    //     },
    //     '/',
	// 	{ 
	// 		name: 'fonts', 
	// 		items: [ 'Font', 'FontSize' ] 
    //     },
    //     '/',
    //     '/',
	// 	{ 
	// 		name: 'paragraph', 
	// 		groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], 
	// 		items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
	// 	{ 
	// 		name: 'links', 
	// 		items: [ 'Link', 'Unlink', 'Anchor' ] 
	// 	},
	// 	'/',
	// 	{ 
	// 		name: 'document', 
	// 		groups: [ 'mode', 'document', 'doctools' ], 
	// 		items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] 
	// 	},
	// 	{ 
	// 		name: 'clipboard', 
	// 		groups: [ 'clipboard', 'undo' ], 
	// 		items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] 
	// 	},
	// 	{ 
	// 		name: 'editing', 
	// 		groups: [ 'find', 'selection', 'spellchecker' ], 
	// 		items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
	// 	{ 
	// 		name: 'forms', 
	// 		items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] 
	// 	},
	// 	{ 
	// 		name: 'insert', 
	// 		items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] 
	// 	},
	// 	{ 
	// 		name: 'tools', 
	// 		items: [ 'Maximize', 'ShowBlocks' ] 
	// 	},
	// 	{ 
	// 		name: 'others', 
	// 		items: [ '-' ] 
	// 	},
	// 	// { 
	// 	// 	name: 'about', 
	// 	// 	items: [ 'About' ] 
	// 	// }
	// ];

    // config.removeButtons = 'Form,Radio,TextField,Checkbox,Textarea,Select,Button,ImageButton,HiddenField,Save,NewPage,Preview,Print,Language,Blockquote,CreateDiv,BidiLtr,BidiRtl,Flash,Table,HorizontalRule,Smiley,PageBreak,Iframe';
};
