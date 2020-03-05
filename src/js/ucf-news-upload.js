/* global wp */

(function ($) {

  $('.ucf_news_fallback_image_upload').click((e) => {
    e.preventDefault();

    const uploader = wp.media({
      title: 'News Fallback Image',
      button: {
        text: 'Upload Image'
      },
      multiple: false
    })
      .on('select', () => {
        const attachment = uploader.state().get('selection').first().toJSON();
        $('.ucf_news_fallback_image_preview').attr('src', attachment.url);
        $('.ucf_news_fallback_image').val(attachment.id);
      })
      .open();
  });

}(jQuery));
