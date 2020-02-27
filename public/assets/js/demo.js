$('document').ready(function() {
    $('button#encrypt').on('click', function(e) {
        e.preventDefault();
        
        let string = $('input#generateKey').val();
        if ($('input#generateKey').val() === '') return false;
        
        console.log('Encrypting string ' + string);

        $.ajax({
            url: '/crypt/' + string + '/encrypt',
            type: 'GET',
            success: function(data) {
                $('div#encrypt-alert').remove();
                $('input#decryptKey').val(data.output);
                $('input#generateKey').closest('.form-group').after('<div id="encrypt-alert" class="alert alert-success">Key generated</div>');
            }
        });
    });

    $('button#decrypt').on('click', function(e) {
        e.preventDefault();

        let string = $('input#decryptKey').val();
        if ($('input#decryptKey').val() === '') return false;

        console.log('Decrypting string ' + string);

        $.ajax({
            url: '/crypt/' + string + '/decrypt',
            type: 'GET',
            success: function(data) {
                $('div#decrypt-alert').remove();

                if (data.output === false) {
                    $('input#decryptKey').closest('.form-group').after('<div id="decrypt-alert" class="alert alert-danger">Invalid Key</div>');
                } else {
                    $('input#decryptKey').closest('.form-group').after('<div id="decrypt-alert" class="alert alert-success">Key validated: ' + data.output + '</div>');
                }
            }
        });
    });
});
