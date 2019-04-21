
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import channelDisplay from './components/ChannelDisplay.vue';
import videoList from './components/VideoList.vue';
import videoForm from './components/VideoForm.vue';
import videoSummary from './components/VideoSummary.vue';

document.addEventListener('DOMContentLoaded', function() {
  const app = new Vue({
    el: '#main-container',
    components: {
      channelDisplay, videoList, videoForm, videoSummary
    },
    data: function() {
      let ret = {
        location: location,
        jQuery: jQuery
      }

      const initialLoad = (typeof __bootstrap !== 'undefined') ? __bootstrap : null
      const videosRegexp = new RegExp(/videos\/\d+/)
      if(location.pathname.startsWith("/channels/")) {
        ret['videos'] = initialLoad
      } else if(videosRegexp.test(location.pathname)) {
        ret['video'] = initialLoad
      } else {
        ret['results'] = initialLoad
      }

      return ret
    }
  });
});
