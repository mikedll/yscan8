
import { mount } from '@vue/test-utils'
import VideoSummary from '../resources/js/components/VideoSummary.vue';

describe('VideoSummary', () => {
  test('summarizes a video\'s stats', () => {
    let video = {
      id: 1,
      vid: 'MpeaSNERwQA',
      title: "Some video"
    }
    const wrapper = mount(VideoSummary, { propsData: { video: video } })

    expect(wrapper.find('h3').html()).toContain(video.title)
  })
})
