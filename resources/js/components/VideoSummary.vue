<template>

  <div class="row">

    <div class="col" >
      
      <div v-if="video">
        <h3>{{ video.title }} <a :href="vLink()" target="_blank"><i class="fab fa-youtube" title="Visit video" ></i></a></h3>

          <div v-if="false" class="alert alert-info">          
          </div>

          <div v-if="false"  class="alert alert-danger">          
          </div>

        <br/>

        <strong>Video Owner</strong>: <router-link :to="channelLink()">{{ video.owner }}</router-link>
        <a :href="yChannelLink()" target="_blank"><i class="fab fa-youtube" title="Visit channel"></i></a>
        <br/>
        <br/>

        <strong>Views</strong>: {{ formatted(video.views) }}
        <br/>
        <strong>Likes</strong>: {{ formatted(video.likes) }}
        <br/>
        <strong>Dislikes</strong>: {{ formatted(video.dislikes) }}
        <br/>
        <strong>Like-to-dislike ratio</strong>: {{ formattedDec(video.likes / video.dislikes) }}
        <br/>
        <strong>Calculation</strong>: log_10({{ video.views }}) * {{ formattedDec(video.likes / video.dislikes) }}
        <a target="_blank" :href="gQuery()">See calculation on <i class="fab fa-google" ></i> Google</a>.
        <br/>
        <strong>Score</strong>: {{ video.score }}

        <br/>
        <br/>
        <a href="#" @click="$router.go(-1)">‹ Back</a>
      </div>
      
      <div v-else>
        Loading...
      </div>
     
    </div>
  </div>    

</template>

<script>
import numeral from 'numeral'

export default {
  props: {
    id: String,
    initialLoad: Object,
    $: Function
  },
  data: function() {
    return {
      video: this.initialLoad ? this.initialLoad : null
    }
  },
  mounted: function() {
    if(this.video === null || this.video.id != Number(this.id)) {
      this.video = null
      this.$.ajax({
        method: 'GET',
        url: '/videos/' + this.id,
        dataType: 'JSON',
        success: (data) => {
          this.video = data
        }
      })
    }
  },
  methods: {
    vLink: function() { return "https://www.youtube.com/watch?v=" + this.video.vid },
    channelLink: function(v) { return '/channels/' + this.video.channel_id },
    yChannelLink: function(v) { return 'https://www.youtube.com/channel/' + this.video.channel_id },
    yLink: function(v) { return "https://www.youtube.com/watch?v=" + this.video.vid },
    formatted: function(n) {
      return numeral(n).format('0,0a')
    },
    formattedDec: function(n) {
      return numeral(n).format('0,0.00')
    },
    gQuery: function() {
      const s = 'log_10(' + this.video.views + ') * (' + this.video.likes + ' / ' + this.video.dislikes + ')'
      return 'http://www.google.com/search?q=' + encodeURI(s);
    }

  }
}
</script>

<style>
</style>
