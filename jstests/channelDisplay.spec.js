
import { mount, createLocalVue } from '@vue/test-utils'
import sinon from 'sinon'
import VueRouter from 'vue-router'
import ChannelDisplay from '../resources/js/components/ChannelDisplay.vue'

describe('ChannelDisplay', () => {

  let localVue, router
  
  beforeEach(() => {
    localVue = createLocalVue()
    localVue.use(VueRouter)
    router = new VueRouter()
  })
  
  test('render video deck for each video', () => {
    let initialLoad = [{'channel_id': 'Unldf4', likes: 30, dislikes: 1, views: 300 }]
    
    let wrapper = mount(ChannelDisplay, { localVue, router, propsData: { id: 'Unldf4', initialLoad } })

    expect(wrapper.find('.channel-videos-list')).toBeDefined()
    expect(wrapper.find('.channel-videos-list').html()).toContain('<div class="video-deck card-deck">')
  })

  test('looks for data if id does not match first video channel_id', () => {
    let initialLoad = [{'channel_id': 'WRONGID', likes: 30, dislikes: 1, views: 300 }]

    let $ = sinon.fake()
    $.ajax = sinon.fake()
    let wrapper = mount(ChannelDisplay, { localVue, router, propsData: { id: 'REQUESTEDID', $, initialLoad } })
    expect($.ajax.calledWithMatch({url: '/channels/REQUESTEDID'})).toBeTruthy()
  })
  
})
