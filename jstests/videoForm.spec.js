import { mount } from '@vue/test-utils'
import VideoForm from '../resources/js/components/VideoForm.vue'

describe('VideoForm', () => {
  test('calls server to make video on form submit', () => {
    let mock$ = function(q) {}
    
    let passedParams = null;
    let called = false
    mock$.ajax = function(options) {
      called = true
      passedParams = options
    }
    let mockLocation = {}

    
    const wrapper = mount(VideoForm, { propsData: {$: mock$, location: mockLocation} })
    wrapper.find('form').trigger('submit')
    expect(called).toBeTruthy()
    expect(passedParams.method).toBe('POST')
    expect(passedParams.success).toBeDefined()

    let mockSuccessData = {
      id: 3
    }

    passedParams.success(mockSuccessData)
    expect(mockLocation.path).toBe('/videos/3')
  })
})
