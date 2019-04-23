
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

import channelDisplay from './components/ChannelDisplay.vue';
import videoList from './components/VideoList.vue';
import videoForm from './components/VideoForm.vue';
import videoSummary from './components/VideoSummary.vue';

Vue.component('video-form', videoForm)
Vue.component('video-list', videoList)

Vue.use(VueRouter)

let rootProps = null

document.addEventListener('DOMContentLoaded', function() {

  const propsLoader = function() {
    if(rootProps) return rootProps

    rootProps = {
      jQuery: jQuery
    }

    const initialLoad = (typeof __bootstrap !== 'undefined') ? __bootstrap : null
    const videosRegexp = new RegExp(/videos\/\d+/)
    if(location.pathname.startsWith("/channels/")) {
      rootProps['videos'] = initialLoad
    } else if(videosRegexp.test(location.pathname)) {
      rootProps['video'] = initialLoad
    } else {
      rootProps['results'] = initialLoad
    }

    return rootProps
  }

  const Home = { props: ["jQuery", "results", "page"],
                 template: `
    <div class="row" >
      <div class="col" >
        <h3>YouTube Video Fervor Calculator</h3>    

        <p>
            This website calculates enthusiasm for a YouTube video.
            Such enthusiasm is arbitrarily defined here as a
            notion of how good a YouTube video is, with less importance on how
            popular it may be. Some videos may be good videos even
            though hardly anyone has heard about them.
            The importance of a video's likes and
            dislikes are used to account for quality of the video.
        </p>

        <video-form v-bind:$="jQuery"></video-form>
        <video-list v-bind:$="jQuery" v-bind:page="page" v-bind:initialLoad="results"></video-list>
      </div>
    </div>
  `}

  const router = new VueRouter({
    mode: 'history',
    base: __dirname,
    routes: [
      { path: '/', component: Home, props: (route) => {
        return {
          results: propsLoader()['results'],
          jQuery: propsLoader()['jQuery'],
          ...route.query
        }
      } },
      { path: '/channels/:id', component: channelDisplay, props: (route) => {
        return { videos: propsLoader()['videos'], ...route.query }
      } },
      { path: '/videos/:id', component: videoSummary, props: (route) => {
        return { initialLoad: propsLoader()['video'], ...route.params }
      } },
    ]
  })
  
  const app = new Vue({
    router,
    el: '#main-container',
    template: `
      <router-view class="view"></router-view>
`
  });

});
