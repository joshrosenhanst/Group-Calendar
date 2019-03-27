import { shallowMount, mount } from '@vue/test-utils';
import AppTimepicker from '../components/timepicker/AppTimepicker.vue';

const propsData = {
  value: "14:30"
};

const getTimeFromString = (text) => {
  let hour = text.substr(0,2);
  let minute = text.substr(3,2);

  let date = new Date();
  date.setHours(hour,minute);
  return date;
};

const formatNumber = (num) => {
  return ( num < 10 ? '0' : '' ) + num;
}

const timeFormatter = (date) => {
  let hours = date.getHours();
  let minutes = date.getMinutes();
  let ampm = "AM";

  if(hours > 11){
    ampm = "PM";
  }
  
  if(hours === 0){
    hours = 12;
  }

  if(hours > 12){
    hours -= 12;
  }

  return formatNumber(hours) + ":" + formatNumber(minutes) + " " + ampm;
}

const formatTime = (time) => {
  if (time && !isNaN(time)) {
    return timeFormatter(time, this)
  } else {
    return null
  }
}

const updateDate = (date,hour,minute,ampm) => {
  hour = parseInt(hour, 10);
  if(ampm === "PM"){
    if(hour !== 12){
      hour += 12;
    }
  }else{
    if(hour === 12){
      hour = 0;
    }
  }
  date.setHours(hour, minute);
  return date;
};

describe('AppTimepicker.vue', () => {
  it('is a Vue instance', () => {
    const wrapper = shallowMount(AppTimepicker, {
      propsData
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });

  // render text input field and hidden timepicker_container by default
  it('render text input field and hidden timepicker_container by default', () => {
    const wrapper = shallowMount(AppTimepicker, {
      propsData
    });
    expect(wrapper.find({ ref: "input" }).attributes('type')).toBe("text");
    expect(wrapper.find({ ref: "timepicker_container" }).exists()).toBe(true);
    expect(wrapper.find({ ref: "timepicker_container" }).isVisible()).toBe(false);
  });

  // toggle the timepicker_container on input click or focus
  it('toggle the timepicker_container on input click or focus', () => {
    const wrapper = shallowMount(AppTimepicker, {
      propsData
    });

    const input = wrapper.find({ ref: "input" });

    // click the timepicker input, which should open the timepicker_container
    input.trigger('click');
    expect(wrapper.find({ ref: "timepicker_container" }).isVisible()).toBe(true);

    // enter key which should close the timepicker_container
    input.trigger('keydown.enter');
    expect(wrapper.find({ ref: "timepicker_container" }).isVisible()).toBe(false);

    // focus the timepicker input, which should open the timepicker_container
    input.trigger('focus');
    expect(wrapper.find({ ref: "timepicker_container" }).isVisible()).toBe(true);
    
    // blur the timepicker input, which should close the timepicker_container
    input.trigger('blur');
    expect(wrapper.find({ ref: "timepicker_container" }).isVisible()).toBe(false);
  });

});