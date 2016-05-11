/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

 CKEDITOR.editorConfig = function( config ) {
 	// Define changes to default configuration here.
 	// For the complete reference:
 	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

 	// The toolbar groups arrangement, optimized for two toolbar rows.
 	config.toolbarGroups = [
 		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
 		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
 		{ name: 'links' },
 		{ name: 'insert', groups: ['image'] },
 		{ name: 'forms' },
 		{ name: 'tools' },
 		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
 		{ name: 'others' },
 		'/',
 		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
 		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
 		{ name: 'styles' },
 		{ name: 'colors' },
 		{ name: 'about' }
 	];
 	config.resize_dir = 'both';
 	config.toolbar =
 	[
 	    ['Source','Cut','Copy','Paste','PasteText','PasteFromWord'],
 	    ['Find','Replace','-','SelectAll','RemoveFormat'],
 	    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
 	    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
 	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
 	    ['BidiLtr', 'BidiRtl' ],
 	    ['Image','Flash','Table','HorizontalRule','SpecialChar','PageBreak','Iframe'],
 	    ['Link','Unlink','Anchor'],
 	    ['Styles','Format','Font','FontSize'],
 	    ['TextColor','ShowBlocks','Maximize']
 	];

 	// Remove some buttons, provided by the standard plugins, which we don't
 	// need to have in the Standard(s) toolbar.
 	config.removeButtons = '';

 	config.contentsCss = '/a/ck.css';
 	config.docType = '<!DOCTYPE html>';
 	config.emailProtection = 'encode';
 	config.entities_latin = false;
 	config.entities_greek = false;
 	config.extraPlugins = 'justify,widget,lineutils,image2,maximize';
 	config.forcePasteAsPlainText = true;
 	config.pasteFromWordPromptCleanup = true;

 	config.filebrowserBrowseUrl = '/filemanager/index.html';
 	// config.filebrowserUploadUrl = '/filemanager/connectors/php/filemanager.php';
 	config.filebrowserImageBrowseUrl = '/filemanager/index.html';
 	// config.filebrowserImageUploadUrl = '/filemanager/connectors/php/filemanager.php';
 	config.filebrowserWindowWidth  = 900;
 	config.filebrowserWindowHeight = 500;

 	config.removeDialogTabs = 'link:upload;image:Upload';
 	config.allowedContent = true;
 };

CKEDITOR.on('instanceReady', function(ev){

	// Output self closing tags the HTML4 and HTML5 way

	ev.editor.dataProcessor.writer.selfClosingEnd = '>';
});
