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
    let mock$ = function(q) { return { attr: () => '' } }
    
    let passedParams = null;
    let called = false
    mock$.ajax = function(options) {
      called = true
      passedParams = options
    }
    
    const wrapper = mount(VideoForm, { localVue, router, propsData: {$: mock$} })
    wrapper.find('form').trigger('submit')
    expect(called).toBeTruthy()
    expect(passedParams.method).toBe('POST')
    expect(passedParams.success).toBeDefined()

    let mockSuccessData = {
      id: 3
    }

    passedParams.success(mockSuccessData)
    expect(wrapper.vm.$route.path).toBe('/videos/3')
  })
})
