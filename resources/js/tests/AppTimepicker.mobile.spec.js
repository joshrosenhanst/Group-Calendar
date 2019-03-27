import { shallowMount } from '@vue/test-utils';
import AppTimepicker from '../components/timepicker/AppTimepicker.vue';

describe('AppDatepicker.vue mobile browser version', () => {
  // set the navigator.userAgent value for this test to an iPhone. AppTimepicker checks the navigator.userAgent value for the computed `isMobile` value.
  navigator.__defineGetter__('userAgent', function () {
    return "Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1";
  });

  // render date input and dont render calendar_container if IsMobile is true
  it('render date input and dont render calendar_container if IsMobile is true', () => {
    const wrapper = shallowMount(AppTimepicker);
    expect(wrapper.find({ ref: "input" }).attributes('type')).toBe("time");
    expect(wrapper.find({ ref: "timepicker_container" }).exists()).toBe(false);
  });

});