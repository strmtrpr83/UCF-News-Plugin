jQuery(($) => {
  $('.section-input').suggest(`${ajaxurl}?action=ucf-news-sections`, {
    delay: 500,
    minchars: 2,
    multiple: true
  });
  $('.topic-input').suggest(`${ajaxurl}?action=ucf-news-topics`, {
    delay: 500,
    minchars: 2,
    multiple: true
  });
});
