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
          <td><a :href="videoLink(v)">{{ v.title }}</a></td>
          <td><a :href="channelLink(v)">{{ v.owner }}</a></td>
          <td>{{ published(v) }}</td>
          <td>
            <a :href="yLink(v)" target="_blank"><i class="fas fa-video" title="Visit video" ></i></a>
            <a :href="yChannelLink(v)" target="_blank"><i class="far fa-smile" title="Visit channel"  ></i></a>
          </td>
        </tr>
      </table>

      <div class="row justify-content-center">
        <ul role="navigation" class="pagination">
          <li class="page-item" v-bind:class="{ disabled: isPage(1)}">
            <span v-if="isPage(1)" class="page-link">‹</span>
            <a v-else :href="pageLink(results.current_page - 1)" class="page-link">‹</a>
          </li>
          <li v-for="i in nearPages.leading" class="page-item">
            <a :href="pageLink(i)"  class="page-link">{{ i }}</a>
          </li>
          <li v-if="nearPages.leading.length > 0" class="page-item">
            <span class="page-link">…</span>
          </li>          
          <li v-for="i in nearPages.near" class="page-item" v-bind:class="{ active: isPage(i) }">
            <a :href="pageLink(i)"  class="page-link">{{ i }}</a>
          </li>

          <li v-if="nearPages.trailing.length > 0" class="page-item">
            <span class="page-link">…</span>
          </li>
          
          <li v-for="i in nearPages.trailing" class="page-item">
            <a :href="pageLink(i)"  class="page-link">{{ i }}</a>
          </li>
          <li class="page-item" v-bind:class="{ disabled: isPage(results.last_page)}">
            <span v-if="isPage(results.last_page)" class="page-link">›</span>
            <a v-else :href="pageLink(results.current_page + 1)"  class="page-link">›</a>
          </li>
        </ul>
      </div>
      
    </div>
  </div>
</template>

<script>
import _ from 'lodash'
import moment from 'moment'
import numeral from 'numeral'
export default {
  props: ['results'],
  computed: {
    nearPages: function() {
      let evenPadding = 8
      let begin = Math.max(1, this.results.current_page - (evenPadding / 2))
      let used = this.results.current_page - begin
      let remaining = evenPadding - used
      let end = Math.min(this.results.last_page, this.results.current_page + remaining)
      let stillRemaining = (this.results.current_page + remaining) - this.results.last_page
      let newBegin = stillRemaining < 0 ? begin : Math.max(1, begin - stillRemaining)

      let trailLeadPossible = 2
      let trailingCount = Math.min(trailLeadPossible, this.results.last_page - end)
      let leadingCount = Math.min(trailLeadPossible, newBegin - 1)

      // Cut down on links in middle if we're going to have trailing or leading sections.
      if(trailingCount > 0) end -= 1
      if(leadingCount > 0) newBegin += 1
      
      // invariant: end >= newBegin
      let pageLinksCount = end - newBegin + 1

      return {
        leading: _.times(leadingCount, (i) => i+1),
        near: _.times(pageLinksCount, function(i) { return newBegin+i }),
        trailing: _.times(trailingCount, (i) => this.results.last_page - i).reverse()
      }
    }
  },
  methods: {
    isPage: function(n) {
      return this.results.current_page === n
    },
    videoLink: (v) => ('/videos/' + v.id),
    channelLink: (v) => ('/channels/' + v.channel_id),
    published: (v) => moment(v.published_at).format('MMM \'YY'),
    formatted: function(n) {
      return numeral(n).format('0,0a')
    },
    pageLink: (i) => '/?page=' + i,
    yChannelLink: (v) => ("https://www.youtube.com/channel/" + v.channel_id),
    yLink: function(v) {
      return "https://www.youtube.com/watch?v=" + v.vid;
    }    
  }
}
</script>

<style>
</style>
