CKEDITOR.plugins.add( 'bxembed', {
    icons: 'bxembed',
    init: function( editor ) {
        // Plugin logic goes here...

        // Define an editor command that opens our dialog window.
        editor.addCommand( 'bxEmbed', new CKEDITOR.dialogCommand( 'bxEmbedDialog' ) );

        editor.ui.addButton( 'bxEmbed', {
            label: 'Insert Embed',
            command: 'bxEmbed',
            toolbar: 'insert'
        });

        CKEDITOR.dialog.add( 'bxEmbedDialog', this.path + 'dialogs/bxEmbed.js' );
    }
});
