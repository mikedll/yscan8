<template>
  <form action="/videos" method='POST' class="new-video" v-on:submit.prevent="onSubmit">
    <input type="hidden" name="_token"/>
    <br/>
    <div class="form-group">
      <input v-model="newVideo" type="text" name="video" class="form-control" placeholder="New Video Link" />
    </div>
  </form>
</template>

<script>
  
export default {
  props: {
    $: {
      type: Function,
      required: true,
    }
  },
  data: function() {
    return { newVideo: '', csrfToken: '' }
  },
  mounted: function() {
    this.csrfToken = this.$('meta[name=csrf-token]').attr('content')
  },
  methods: {
    onSubmit: function(e) {
      this.$.ajax({
        method: "POST",
        url: "/videos",
        data: {
          video: this.newVideo,
          _token: this.csrfToken
        },
        success: (data) => {
          this.$router.push({path: '/videos/' + data.id})
        }
      })      
    }
  }
}
</script>

<style>
</style>
