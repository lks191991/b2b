<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<script>
    $(document).ready(function () {
        var textarea = $('.text-editor').attr('id');
        CKEDITOR.replace(textarea, {
            filebrowserBrowseUrl: "{{route('media.image.browse')}}",
            filebrowserUploadUrl: '/browser/upload/type/all',
            filebrowserImageBrowseUrl: "{{route('media.image.browse')}}",
            filebrowserImageUploadUrl: "{{route('media.upload',['_token' => csrf_token() ])}}",
            filebrowserWindowWidth: 800,
            filebrowserWindowHeight: 500,
            allowedContent: true,
            removeFormatAttributes: '',
            on: {
                instanceReady: function() {
                    this.dataProcessor.htmlFilter.addRules( {
                        elements: {
                            img: function( el ) {
                                // Add an attribute.
                                if ( !el.attributes.alt )
                                    el.attributes.alt = '';

                                // Add some class.
                                el.addClass( 'img-fluid' );
                            }
                        }
                    } );            
                }
            }
        });
		
		$('.text-editor-all').each(function() {
    CKEDITOR.replace(this, {
        filebrowserBrowseUrl: "{{ route('media.image.browse') }}",
        filebrowserUploadUrl: '/browser/upload/type/all',
        filebrowserImageBrowseUrl: "{{ route('media.image.browse') }}",
        filebrowserImageUploadUrl: "{{ route('media.upload',['_token' => csrf_token() ]) }}",
        filebrowserWindowWidth: 800,
        filebrowserWindowHeight: 500,
        allowedContent: true,
        removeFormatAttributes: '',
        on: {
            instanceReady: function() {
                this.dataProcessor.htmlFilter.addRules({
                    elements: {
                        img: function(el) {
                            // Add an attribute.
                            if (!el.attributes.alt) el.attributes.alt = '';

                            // Add some class.
                            el.addClass('img-fluid');
                        }
                    }
                });
            }
        }
    });
});

		var textarea2 = $('.text-editor2').attr('id');
        CKEDITOR.replace(textarea2, {
            filebrowserBrowseUrl: "{{route('media.image.browse')}}",
            filebrowserUploadUrl: '/browser/upload/type/all',
            filebrowserImageBrowseUrl: "{{route('media.image.browse')}}",
            filebrowserImageUploadUrl: "{{route('media.upload',['_token' => csrf_token() ])}}",
            filebrowserWindowWidth: 800,
            filebrowserWindowHeight: 500,
            allowedContent: true,
            removeFormatAttributes: '',
            on: {
                instanceReady: function() {
                    this.dataProcessor.htmlFilter.addRules( {
                        elements: {
                            img: function( el ) {
                                // Add an attribute.
                                if ( !el.attributes.alt )
                                    el.attributes.alt = '';

                                // Add some class.
                                el.addClass( 'img-fluid' );
                            }
                        }
                    } );            
                }
            }
        });

        var short_textarea = $('.short-text-editor').attr('id');
        CKEDITOR.replace(short_textarea, {
            allowedContent: true,
            removeFormatAttributes: '',
            toolbarGroups: [{
                    "name": "basicstyles",
                    "groups": ["basicstyles"]
                },
                {
                    "name": "links",
                    "groups": ["links"]
                },
                {
                    "name": "paragraph",
                    "groups": ["list", "blocks"]
                },
                {
                    "name": "styles",
                    "groups": ["styles"]
                },
            ],
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
        });

        var email_body_editor = $('.email-body-editor').attr('id');
        CKEDITOR.replace(email_body_editor, {
            allowedContent: true,
            removeFormatAttributes: '',
            toolbarGroups : [
    { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
    { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
    { name: 'links' },
    { name: 'insert' },
    { name: 'forms' },
    { name: 'tools' },
    { name: 'document',       groups: [ 'mode', 'document', 'doctools' ] },
    { name: 'others' },
    '/',
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
    { name: 'styles' },
    { name: 'colors' },
    { name: 'about' }
],
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: ''
        });
		
		var short_textarea2 = $('.short-text-editor2').attr('id');
        CKEDITOR.replace(short_textarea2, {
            allowedContent: true,
            removeFormatAttributes: '',
            toolbarGroups: [{
                    "name": "basicstyles",
                    "groups": ["basicstyles"]
                },
                {
                    "name": "links",
                    "groups": ["links"]
                },
                {
                    "name": "paragraph",
                    "groups": ["list", "blocks"]
                },
                {
                    "name": "styles",
                    "groups": ["styles"]
                },
            ],
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
        });
		
		var short_textarea3 = $('.short-text-editor3').attr('id');
        CKEDITOR.replace(short_textarea3, {
            allowedContent: true,
            removeFormatAttributes: '',
            toolbarGroups: [{
                    "name": "basicstyles",
                    "groups": ["basicstyles"]
                },
                {
                    "name": "links",
                    "groups": ["links"]
                },
                {
                    "name": "paragraph",
                    "groups": ["list", "blocks"]
                },
                {
                    "name": "styles",
                    "groups": ["styles"]
                },
            ],
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
        });
		
		var short_textarea4 = $('.short-text-editor4').attr('id');
        CKEDITOR.replace(short_textarea4, {
            allowedContent: true,
            removeFormatAttributes: '',
            toolbarGroups: [{
                    "name": "basicstyles",
                    "groups": ["basicstyles"]
                },
                {
                    "name": "links",
                    "groups": ["links"]
                },
                {
                    "name": "paragraph",
                    "groups": ["list", "blocks"]
                },
                {
                    "name": "styles",
                    "groups": ["styles"]
                },
            ],
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
        });
		
		var short_textarea5 = $('.short-text-editor5').attr('id');
        CKEDITOR.replace(short_textarea5, {
            allowedContent: true,
            removeFormatAttributes: '',
            toolbarGroups: [{
                    "name": "basicstyles",
                    "groups": ["basicstyles"]
                },
                {
                    "name": "links",
                    "groups": ["links"]
                },
                {
                    "name": "paragraph",
                    "groups": ["list", "blocks"]
                },
                {
                    "name": "styles",
                    "groups": ["styles"]
                },
            ],
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
        });
    });
</script>

<script>
        $(document).ready(function() {
            // Ensure CKEditor is defined before initializing
            if (typeof CKEDITOR !== 'undefined') {
                CKEDITOR.replace('email_body', {
                    allowedContent: true,
                    removeFormatAttributes: '',
                    toolbarGroups: [
                        { "name": "basicstyles", "groups": ["basicstyles"] },
                        { "name": "links", "groups": ["links"] },
                        { "name": "paragraph", "groups": ["list", "blocks"] },
                        { "name": "styles", "groups": ["styles"] }
                    ],
                    // Remove the redundant buttons from toolbar groups defined above.
                    removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
                });
            } else {
                console.error('CKEditor is not defined');
            }
        });
    </script>