
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

  test('looks for data if initial load is not provided', () => {
    const mock$ = function(){}
    let passedParams, called = false
    mock$.ajax = (params) => { called = true
                               passedParams = params }
    const wrapper = mount(VideoSummary, { localVue, router, propsData: { id: "4", $: mock$ } })
    expect(passedParams.method).toBe('GET')
    expect(passedParams.url).toBe('/videos/4')
  })
    
  test('summarizes a video\'s stats', () => {
    let mock$ = function() {}, called = false
    mock$.ajax = () => { called = true }
    let video = {
      id: 1,
      vid: 'MpeaSNERwQA',
      title: "Some video"
    }
    const wrapper = mount(VideoSummary, { localVue, router, propsData: { initialLoad: video, $: mock$ } })
    expect(called).toBeFalsy()
    expect(wrapper.find('h3').html()).toContain(video.title)
  })
})
