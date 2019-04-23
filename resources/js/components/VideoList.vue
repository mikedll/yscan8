<template>

  <div>
    <div v-if="checkCorrectPage">
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
          <td><router-link :to="videoLink(v)">{{ v.title }}</router-link></td>
          <td><router-link :to="channelLink(v)">{{ v.owner }}</router-link></td>
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
            <router-link v-else :to="pageLink(results.current_page - 1)" class="page-link">‹</router-link>
          </li>
          <li v-for="i in nearPages.leading" class="page-item">
            <router-link :to="pageLink(i)"  class="page-link">{{ i }}</router-link>
          </li>
          <li v-if="nearPages.leading.length > 0" class="page-item">
            <span class="page-link">…</span>
          </li>          
          <li v-for="i in nearPages.near" class="page-item" v-bind:class="{ active: isPage(i) }">
            <router-link :to="pageLink(i)"  class="page-link">{{ i }}</router-link>
          </li>

          <li v-if="nearPages.trailing.length > 0" class="page-item">
            <span class="page-link">…</span>
          </li>
          
          <li v-for="i in nearPages.trailing" class="page-item">
            <router-link :to="pageLink(i)"  class="page-link">{{ i }}</router-link>
          </li>
          <li class="page-item" v-bind:class="{ disabled: isPage(results.last_page)}">
            <span v-if="isPage(results.last_page)" class="page-link">›</span>
            <router-link v-else :to="pageLink(results.current_page + 1)"  class="page-link">›</router-link>
          </li>
        </ul>
      </div>
      
    </div>
    <div v-else>
      Loading...
    </div>
  </div>
</template>

<script>
import _ from 'lodash'
import moment from 'moment'
import numeral from 'numeral'
export default {
  props: {
    'initialLoad': Object,
    'page': String,
    '$': Function
  },
  data: function() {
    return {
      loading: false,
      results: this.initialLoad ? this.initialLoad : null
    }
  },
  mounted: function() {
    if(this.results === null) {
      this.reload()
    }
  },
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
    },
    checkCorrectPage: function() {
      if(this.loading) return false

      if(this.results !== null && this.results.current_page === this.loadedPage) return true

      this.reload()
      return false
    },
    loadedPage: function() {
      return this.page ? Number(this.page) : 1
    }
  },
  methods: {
    reload: function() {
      this.results = null
      this.loading = true

      $.ajax({
        method: 'GET',
        url: '/',
        dataType: 'JSON',
        data: {
          page: this.loadedPage
        },
        success: (data) => {
          this.loading = false
          this.results = data
        }
      })      
    },
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
