<template>
  <div class="channel-display">

    <div v-if="videos">
      <div class="row">
        <div class="col">
          <h3>{{ heading }} <a target="_blank" :href="channelLink()" v-if="channelLink() !== ''"><i class="fab fa-youtube"></i></a></h3>

          Average Score: {{ averageScore }}
        </div>
      </div>

      <div class="row">
        <div class="col channel-videos-list">
          <div class="video-deck card-deck" v-for="(deck, deckIndex) in decks" v-bind:key="deckIndex">

            <div class="card border-dark bg-light video-card" v-for="v in deck" v-bind:key="v.id">
              <div class="card-body">
                <h5 class="card-title">
                  <router-link :to="videoLink(v)">{{ v.title }}</router-link>
                  <a target="_blank" :href="yLink(v)"><i class="fab fa-youtube"></i></a>
                </h5>
                <p class="card-text">
                  Score: {{ v.score }}
                </p>
              </div>

              <div class="card-footer">
                Published {{ published(v) }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <router-link to="/">Video List</router-link>
        </div>
      </div>
    
    </div>
    <div v-else>
      Loading...
    </div>
  </div>
</template>

<script>
import _ from 'lodash';
import moment from 'moment';

export default {
  props: {
    'initialLoad': Object,
    '$': Function,
    'id': String    
  },
  data: function() {
    return {
      'videos': this.initialLoad ? this.initialLoad : null
    }
  },
  mounted: function() {
    if(this.videos === null) {
      this.$.ajax({
        method: 'GET',
        url: '/channels/' + this.id,
        dataType: 'JSON',
        success: (data) => {
          this.videos = data
        }
      })
    }
  },
  computed: {
    averageScore: function() {
      if(this.videos.length === 0) return 0;
      const avg = _.sum(_.map(this.videos, v => { var s = parseFloat(v.score); return (isNaN(s) ? 0 : s) })) / this.videos.length;
      return Math.round(avg * 100) / 100;
    },
    decks: function() {
      var decks = [];
      var curDeck = [];
      
      for(var i=0; i < this.videos.length; i++) {
        curDeck.push(this.videos[i]);
        if(i % 3 === 2 || i == this.videos.length - 1) {
          decks.push(curDeck);
          curDeck = [];
        }
      }

      return decks;
    },
    heading: function() {
      if(this.videos.length === 0) return "No videos for this channel.";

      return this.videos[0].owner + " videos";
    }
  },
  methods: {
    published: function(v) {
      return moment(v.published_at).format('MMMM Do YYYY');
    },
    channelLink: function() {
      if(this.videos.length === 0) return "";
      return "https://www.youtube.com/channel/" + this.videos[0].channel_id;
    },
    videoLink: function(v) {
      return '/videos/' + v.id;
    },
    yLink: function(v) {
      return "https://www.youtube.com/watch?v=" + v.vid;
    }
  }
}
</script>

<style>
  .video-deck {
    margin-bottom: 1rem;
  }
</style>
