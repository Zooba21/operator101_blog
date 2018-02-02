  $(function() {
    $('#myEditor').froalaEditor({toolbarInline: false})
  });

  $('#myEditor').froalaEditor({
  htmlRemoveTags: ['script', 'style', 'base']
});

$('#myEditorComments').froalaEditor({
    // Set custom buttons with separator between them.
    toolbarButtons: ['undo', 'redo' , '|', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting', 'insertTable',],
    toolbarButtonsXS: ['undo', 'redo' , '-', 'bold', 'italic', 'underline']
  })
;

$('#myEditorComments').froalaEditor({
htmlRemoveTags: ['script', 'style', 'base']
});
