
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

import channelDisplay from './components/channel_display.vue';
import videoList from './components/video_list.vue';
import videoForm from './components/video_form.vue';

document.addEventListener('DOMContentLoaded', function() {
  const app = new Vue({
    el: '#main-container',
    components: {
      channelDisplay, videoList, videoForm
    },
    data: function() {
      return {
        [location.pathname.startsWith("/channels/") ? 'videos' : 'results']: (typeof __bootstrap !== 'undefined') ? __bootstrap : null
      }
    }
  });
});
