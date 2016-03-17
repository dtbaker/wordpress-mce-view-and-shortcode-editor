/* global tinymce */
( function() {
	tinymce.PluginManager.add( 'dtbaker_mce_banner', function( editor ) {
		editor.addButton( 'dtbaker_mce_banner_button', {
			text: 'Banner',
			icon: false,
			onclick: function() {
				wp.mce.boutique_banner.popupwindow(editor);
			}
		});
	});
})();
