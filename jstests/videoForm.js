
import Vue from 'vue'
import VideoForm from '../resources/js/components/VideoForm.vue'

let Constructor = Vue.extend(VideoForm)


let mockEvent = {}
let mock$ = {}
let passedParams = null;
let called = false
mock$.ajax = function(options) {
  called = true
  passedParams = options
}
let mockLocation = {}

const vm = new Constructor({ propsData: {$: mock$, location: mockLocation} })

let ajaxParams = {
  method: 'POST'
}
vm.onSubmit(mockEvent)
if(!called) {
  throw "Did not call $.ajax"
}

if(passedParams.method !== ajaxParams.method) {
  throw "Expected POST method in ajax call but got " + passedParams.method
}

// expect(mock$).to.receive(ajax).with(ajaxParams)

let mockSuccessData = {
  videoPath: '/videos/3'
}

passedParams.success(mockSuccessData)

// expect(mockLocation).to.receive('path').equal('/videos/3')
if(mockLocation.path !== '/videos/3') {
  throw "Happy path failed"
}
