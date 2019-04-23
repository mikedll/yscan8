import sinon from 'sinon'
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

  test('render links to youtube video and youtube channel', () => {
  })
  
  test('looks for data if initial load is not provided', () => {
    let $ = sinon.fake()
    $.ajax = sinon.fake()
    const wrapper = mount(VideoSummary, { localVue, router, propsData: { id: "4", $ } })
    expect($.ajax.calledWithMatch({method: 'GET', url: '/videos/4'})).toBeTruthy()
  })
    
  test('looks for data if initial load does not match request id', () => {
    let $ = sinon.fake()
    $.ajax = sinon.fake()
    let initialLoad = { id: 2 }
    const wrapper = mount(VideoSummary, { localVue, router, propsData: { id: "4", $, initialLoad } })
    expect($.ajax.calledWithMatch({method: 'GET', url: '/videos/4'})).toBeTruthy()
  })
    
  test('summarizes a video\'s stats', () => {
    let $ = sinon.fake()
    $.ajax = sinon.fake()
    let video = {
      id: 1,
      vid: 'MpeaSNERwQA',
      title: "Some video"
    }
    const wrapper = mount(VideoSummary, { localVue, router, propsData: { initialLoad: video, $ } })
    expect($.ajax.called).toBeFalsy()
    expect(wrapper.find('h3').html()).toContain(video.title)
  })
})
