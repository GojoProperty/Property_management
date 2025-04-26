$(function() {
  'use strict';

  // Initialize TinyMCE editor
  if ($("#tinymceExample").length) {
    tinymce.init({
      selector: '#tinymceExample',
      min_height: 350,
      plugins: [
        'advlist', 'autoresize', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'pagebreak',
        'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen',
      ],
      toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
      image_advtab: true,
      templates: [
        { title: 'Test template 1', content: 'Test 1' },
        { title: 'Test template 2', content: 'Test 2' }
      ],
    
      // Keep the default TinyMCE skin and styles
      skin: 'oxide',
      content_css: 'default',
    
      // Customize editor content area
      content_style: `
        body { background-color: #F8F9FA !important; color: #4CAF50 !important; font-size: 14px !important; }
      `,
    });
    
  }
});
