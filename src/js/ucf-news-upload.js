var ucf_news_upload = function($) {
  $('.ucf_news_fallback_image_upload').click(function(e) {
    e.preventDefault();

    var uploader = wp.media({
      title: 'News Fallback Image',
      button: {
        text: 'Upload Image'
      },
      multiple: false
    })
    .on('select', function() {
      var attachment = uploader.state().get('selection').first().toJSON();
      $('.ucf_news_fallback_image_preview').attr('src', attachment.url);
      $('.ucf_news_fallback_image').val(attachment.id);
    })
    .open();
  });
};

jQuery(document).ready(function($) {
  ucf_news_upload($);
});
