<template>
  <form action="/videos" method='POST' class="new-video">
    <input type="hidden" name="_token"/>
    <br/>
    <div class="form-group">
      <input type="text" name="video" class="form-control" placeholder="New Video Link" />
    </div>
  </form>
</template>

<script>
  
import $ from 'jquery'
export default {
  mounted: function() {
    let csrf = $('meta[name=csrf-token]').attr('content')
    $('form.new-video').find('input[name=_token]').val(csrf)
  }
}
</script>

<style>
</style>
