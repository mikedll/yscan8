import sinon from 'sinon'
import { mount, createLocalVue } from '@vue/test-utils'
import VueRouter from 'vue-router'
import VideoForm from '../resources/js/components/VideoForm.vue'

describe('VideoForm', () => {
  let localVue, router

  beforeEach(() => {
    localVue = createLocalVue()
    localVue.use(VueRouter)
    router = new VueRouter()
  })
             
  test('calls server to make video on form submit', () => {
    let $ = sinon.fake.returns({ attr: sinon.fake.returns('') })
    $.ajax = sinon.fake()
    
    const wrapper = mount(VideoForm, { localVue, router, propsData: {$} })
    wrapper.find('form').trigger('submit')
    expect($.ajax.calledWithMatch({method: 'POST', url: '/videos'})).toBeTruthy()
    expect($.ajax.getCall(0).args[0].success).toBeDefined()

    $.ajax.getCall(0).args[0].success({id: "3"})
    expect(wrapper.vm.$route.path).toBe('/videos/3')
  })
})
