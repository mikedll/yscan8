<template>

  <div>
    <div>
      <table class="table">
        <thead>
          <tr>
            <th>Views</th>
            <th>Likes</th>
            <th>Dislikes</th>
            <th>
              Score
              <i class="fas fa-question-circle" title="Equation: (log(base10,views) * likes/dislikes)"></i>
            </th>
            <th>Video Title</th>
            <th>Owner</th>
            <th>Published</th>
            <th><i class="fab fa-youtube" title="Links"></i></th>
          </tr>
        </thead>
        
        <tr v-for="v in results.data" v-bind:key="v.id">
          <td>{{ formatted(v.views) }} </td>
          <td>{{ formatted(v.likes) }} </td>
          <td>{{ formatted(v.dislikes) }}</td>
          <td>{{ v.score }}</td>
          <td><a :href="yLink(v)">{{ v.title }}</a></td>
          <td><a :href="channelLink(v)">{{ v.owner }}</a></td>
          <td>{{ published(v) }}</td>
          <td>
            <a :href="yLink(v)" target="_blank"><i class="fas fa-video" title="Visit video" ></i></a>
            <a :href="yChannelLink(v)" target="_blank"><i class="far fa-smile" title="Visit channel"  ></i></a>
          </td>
        </tr>
      </table>
      
    </div>
  </div>
</template>

<script>
import moment from 'moment'
import numeral from 'numeral'
export default {
  props: ['results'],
  methods: {
    videoLink: (v) => ('/videos/' + v.id),
    channelLink: (v) => ('/channels/' + v.channel_id),
    published: (v) => moment(v.published_at).format('MMM \'YY'),
    formatted: function(n) {
      return numeral(n).format('0,0a')
    },
    yChannelLink: (v) => ("https://www.youtube.com/channel/" + v.channel_id),
    yLink: function(v) {
      return "https://www.youtube.com/watch?v=" + v.vid;
    }    
  }
}
</script>

<style>
</style>
