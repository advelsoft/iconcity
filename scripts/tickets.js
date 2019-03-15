$('document').ready(function () {
    var editor = new TINY.editor.edit('editor', {
        id: 'reply',
        width: '100%',
        height: 160,
        cssclass: 'tinyeditor',
        controlclass: 'tinyeditor-control',
        rowclass: 'tinyeditor-header',
        dividerclass: 'tinyeditor-divider',
        controls: ['bold', 'italic', 'underline', 'strikethrough', '|', 'orderedlist',
			'unorderedlist', '|', 'outdent', 'indent', '|', 'leftalign', 'centeralign',
			'rightalign', 'blockjustify', '|', 'link', 'unlink'],
        footer: false,
        xhtml: true,
        cssfile: '../../../../content/css/tinyeditor.css',
        bodyid: 'editor',
        footerclass: 'tinyeditor-footer',
        toggle: { text: 'source', activetext: 'wysiwyg', cssclass: 'toggle' },
        resize: { cssclass: 'resize' }
    });


    var all_extensions_allowed = false;
    var allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'zip', 'pdf'];


    $('button[name=upload_file]').click(function (evt) {
        evt.preventDefault();

        var new_file = '<div class="file">';
        new_file += '	<button name="selected_file" class="btn btn-upload-file btn-light-blue">Select file to upload...</button>';
        new_file += '	<button name="delete_file" class="btn btn-upload-file btn-red btn-delete"><i class="glyphicon glyphicon-remove"></i></button>';
        new_file += '	<input type="file" name="files[]" style="display:none;" />';
        new_file += '</div>';

        $(this).before(new_file);
    });


    $(document).delegate('button[name=selected_file]', 'click', function (evt) {
        // Bug fixer
        if (evt.clientX != 0 && evt.clientY != 0) {
            evt.preventDefault();
            $(this).parent().children('input[type=file]').click();
        }
    });


    $(document).delegate('input[type=file]', 'change', function (evt) {
        var val = $(this).val().split('\\').pop();

        // Get extension and check if it's allowed...
        var ext = val.toLowerCase().split('.').pop();
        if (all_extensions_allowed == false) {
            if (allowed_extensions.indexOf(ext) == -1) {
                var allowed_ext = allowed_extensions.join(', ');
                alert(ext + ' is not a valid file extension. You can only upload the following: ' + allowed_ext);
            }
        }

        $(this).parent().children('button[name=selected_file]').html(val);
    });


    $(document).delegate('button[name=delete_file]', 'click', function (evt) {
        evt.preventDefault();
        $(this).parent().remove();
    });


    $('form[name=new-reply]').submit(function (evt) {
        editor.post();
        var message = editor.t.value;

        if (message.length <= 10) {
            evt.preventDefault();
            error('Ticket message must be more than 10 characters long', '.tinyeditor');
            return false;
        }


        // Delete empty files
        var nfiles = $('input[type=file]').length;
        var astr = [];
        for (var i = 1; i <= nfiles; i++) {
            var val = $('.file:nth-child(' + i + ') input[type=file]').val();
            if (val == '')
                astr.push('.file:nth-child(' + i + ')');
            else {
                // Get extension and check if it's allowed...
                var ext = val.toLowerCase().split('.').pop();
                if (all_extensions_allowed == false) {
                    if (allowed_extensions.indexOf(ext) == -1) {
                        var allowed_ext = allowed_extensions.join(', ');
                        error('One or more files have an invalid extension. The only allowed extensions are: ' + allowed_ext);
                        evt.preventDefault();
                        return false;
                    }
                }
            }
        }
        var str = astr.join(', ');
        $(str).remove();
    });

    $('.btn[name=delete-ticket]').click(function (evt) {
        evt.preventDefault();
        alert('This action is disabled for the Demo');
    });
});
