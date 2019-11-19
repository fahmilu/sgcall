/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
	config.enterMode = CKEDITOR.ENTER_P;
	config.shiftEnterMode = CKEDITOR.ENTER_BR;

	// Set the most common block elements.
	// config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	// config.removeDialogTabs = 'image:advanced;link:advanced';

	//youtube
	config.extraPlugins = 'youtube';

	//allow all chars by AM
	config.format_tags = 'p;h1;h2;h3;h4;h5;h6;pre;address;div';
	config.removePlugins = 'PasteFromWord,PasteText';
	config.allowedContent = true;
	config.pasteFromWordPromptCleanup = true;
	config.pasteFromWordRemoveFontStyles = true;
	config.forcePasteAsPlainText = true;
	config.ignoreEmptyParagraph = true;
	config.removeFormatAttributes = true;
};
