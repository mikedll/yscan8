
import { mount, createLocalVue } from '@vue/test-utils'
import VueRouter from 'vue-router'
import VideoSummary from '../resources/js/components/VideoSummary.vue'

describe('VideoSummary', () => {
  let localVue, router

  beforeEach(() => {
    localVue = createLocalVue()
    localVue.use(VueRouter)
    router = new VueRouter()
  })
             
  test('summarizes a video\'s stats', () => {
    let mock$ = function() {}
    let video = {
      id: 1,
      vid: 'MpeaSNERwQA',
      title: "Some video"
    }
    const wrapper = mount(VideoSummary, { localVue, router, propsData: { initialLoad: video, $: mock$ } })

    expect(wrapper.find('h3').html()).toContain(video.title)
  })
})
