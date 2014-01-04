jQuery(function($) {
    $('.vm14_custom_blurb_media_link').each(function() {
        var link = $(this),
            input = link.parent().find('.vm14_custom_blurb_media_id'),
            img = link.parent().find('.vm14_custom_blurb_media_img');
        
        link.click(function() {
            var frame = wp.media({
                title: 'Select image',
                multiple: false,
                button: { text: 'Select' }
            });

            frame.on('close', function() {
                var attachments = frame.state().get('selection');

                if (attachments.length == 1) {
                    var model = attachments.models[0];

                    input.attr('value', model.id);
                    img.attr('src', model.attributes.url);
                }

                console.log(attachments.models);
            });

            frame.open();

            return false;
        });
    });
});
