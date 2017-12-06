<script type="text/javascript">
  $('[type="submit"]').click(function() {
    $('.ui.button').addClass('loading')
    $('button.ui.button').attr('disabled', true)
    $('a.ui.button').addClass('disabled')
    this.form.submit()
  })
</script>
