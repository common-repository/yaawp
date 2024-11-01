(function() {

        tinymce.create('tinymce.plugins.yaawp', {
                init: function ( ed, url ) {

                        ed.addCommand('ttPopup', function ( a, params ) {
                                var popup = params.identifier;
                                
                                tb_show('Shortcode einfügen', '/wp-content/plugins/yaawp/popup.php?popup=' + popup + '&width=' + 800 + '&height=' + 600);
                        });

                },
                createControl: function ( btn, e ) {
                        if ( btn == 'yaawp' ) {       
                                var a = this;

                                btn = e.createMenuButton('tt_button',
                                {
                                        title: 'Shortcode einfügen',
                                        image: '/wp-content/plugins/yaawp/assets/img/btn.png',
                                        icons: false
                                });
                                
                                btn.onRenderMenu.add(function (c, b) {       
                                        a.addWithPopup( b, 'Statisch', 'statisch' );
                                });
                                
                                return btn;
                        }
                        
                        return null;
                },
                addWithPopup: function ( ed, title, id ) {
                        ed.add({
                                title: title,
                                onclick: function () {
                                        tinyMCE.activeEditor.execCommand('ttPopup', false, {
                                                title: title,
                                                identifier: id
                                        })
                                }
                        })
                },
                addImmediate: function ( ed, title, sc) {
                        ed.add({
                                title: title,
                                onclick: function () {
                                        tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, sc )
                                }
                        })
                }
        });
        
        tinymce.PluginManager.add('yaawp', tinymce.plugins.yaawp);
})();
