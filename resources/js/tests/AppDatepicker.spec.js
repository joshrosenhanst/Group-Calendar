import { shallowMount, mount } from '@vue/test-utils';
import AppDatepicker from '../components/datepicker/AppDatepicker.vue';
import MaterialIcon from '../components/icons/MaterialIcon.vue';

/*
  events: Object collection of `event` objects mapped by date. Formatted as: {date: [array of event objects on date]}
    event: Object with event details
*/
const events = {"2019-03-15T00:00:00-04:00":[{"name":"A test event!","summary":"Fri 3:30 PM","color":"#0C9911"}],"2019-03-18T00:00:00-04:00":[{"name":"New event","summary":"Mon 2:42 PM","color":"#0C9911"},{"name":"This is a new event","summary":"Mon 3:13 PM","color":"#0C9911"},{"name":"test event!","summary":"Mon 3:24 PM","color":"#0C9911"},{"name":"a new test event","summary":"Mon 3:26 PM","color":"#0C9911"},{"name":"test event #4","summary":"Mon 3:33 PM","color":"#0C9911"},{"name":"a new event!","summary":"Mon 3:41 PM","color":"#0C9911"},{"name":"a new event!!!!","summary":"Mon 3:42 PM","color":"#0C9911"}],"2019-03-21T00:00:00-04:00":[{"name":"test notification event","summary":"Thu 11:40 AM","color":"#0C9911"},{"name":"test event","summary":"Thu 6:43 PM","color":"#0C9911"},{"name":"New event!","summary":"Thu 8:49 PM","color":"#0C9911"},{"name":"new event","summary":"Thu 5:50 PM","color":"#23CC56"}],"2019-03-23T00:00:00-04:00":[{"name":"Cleaned Up Event","summary":"Sat 4:30 PM","color":"#0C9911"}],"2019-03-29T00:00:00-04:00":[{"name":"test event","summary":"Fri 5:45 PM - Sat 05:45 PM","color":"#0C9911"}],"2019-04-10T00:00:00-04:00":[{"name":"Look at this sweet new event","summary":"Wed 12:30 PM","color":"#0C9911"}],"2019-04-25T00:00:00-04:00":[{"name":"My Test Event :)","summary":"Thu 7:30 PM - 08:30 PM","color":"#0C9911"}],"2019-05-15T00:00:00-04:00":[{"name":"This is a test event with no end date","summary":"Wed 4:30 PM - Fri 02:26 PM","color":"#0C9911"}],"2019-06-30T00:00:00-04:00":[{"name":"Even Newer Event w\/ no end date + time","summary":"Sun 12:15 PM","color":"#0C9911"},{"name":"IE event","summary":"Sun 11:15 AM - Fri 02:30 PM","color":"#0C9911"}],"2019-04-08T00:00:00-04:00":[{"name":"Test Event - no js!!","summary":"Mon 12:30 PM - Tue 04:30 PM","color":"#23CC56"}],"2019-04-18T00:00:00-04:00":[{"name":"Max Powers","summary":"Thu 12:30 PM - Fri 12:30 PM","color":"#23CC56"}],"2019-04-19T00:00:00-04:00":[{"name":"This is a test event","summary":"Fri 2:57 PM","color":"#23CC56"}],"2019-06-14T00:00:00-04:00":[{"name":"new event","summary":"Fri 2:58 PM","color":"#23CC56"}]};
const todays_date = new Date().toISOString();
const stubs = {
  'material-icon': MaterialIcon
};
const parseDate = (date) => {
  return new Date(Date.parse(date));
};

const formatDate = (date) => {
  if (date && !isNaN(date)) {
    const yyyyMMdd = date.getFullYear() +
        '/' + (date.getMonth() + 1) +
        '/' + date.getDate()
    const d = new Date(yyyyMMdd);
    return date.toLocaleDateString();
  } else {
    return null
  }
};

describe('AppDatepicker.vue', () => {
  // check if the component is created
  it('is a Vue instance', () => {
    const wrapper = shallowMount(AppDatepicker, {
      stubs: stubs
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });

  // render text input field and hidden calendar_container by default
  it('render text input field and hidden calendar_container by default', () => {
    const wrapper = shallowMount(AppDatepicker, {
      stubs: stubs
    });
    expect(wrapper.find({ ref: "input" }).attributes('type')).toBe("text");
    expect(wrapper.find({ ref: "calendar_container" }).exists()).toBe(true);
    expect(wrapper.find({ ref: "calendar_container" }).isVisible()).toBe(false);
  });

  // toggle the calendar_container on input click or focus
  it('toggle the calendar_container on input click or focus', () => {
    const wrapper = shallowMount(AppDatepicker, {
      stubs: stubs
    });
    // click the datepicker input, which should open the calendar
    wrapper.find({ ref: "input" }).trigger('click');
    expect(wrapper.find({ ref: "calendar_container" }).isVisible()).toBe(true);

    // click the <body>, which should close the calendar
    document.body.click();
    expect(wrapper.find({ ref: "calendar_container" }).isVisible()).toBe(false);

    // focus the datepicker input, which should open the calendar
    wrapper.find({ ref: "input" }).trigger('focus');
    expect(wrapper.find({ ref: "calendar_container" }).isVisible()).toBe(true);
    
    // blur the datepicker input, which should close the calendar
    wrapper.find({ ref: "input" }).trigger('blur');
    expect(wrapper.find({ ref: "calendar_container" }).isVisible()).toBe(false);
  });

  // arrow keys change the input value
  it('arrow keys change the dateSelected value', () => {
    const wrapper = shallowMount(AppDatepicker, {
      propsData: {
        value: todays_date
      },
      stubs: stubs
    });

    const input = wrapper.find({ ref: "input" });
    input.trigger("focus");
    let focused_date = parseDate(todays_date);
    expect(wrapper.vm.dateSelected).toEqual(focused_date);

    // subtract one day
    input.trigger('keydown.left');
    focused_date.setDate( focused_date.getDate() - 1 );
    expect(input.element.value).toEqual(formatDate(focused_date));

    // subtract one week
    input.trigger('keydown.up');
    focused_date.setDate( focused_date.getDate() - 7 );
    expect(input.element.value).toEqual(formatDate(focused_date));

    // add one day
    input.trigger('keydown.right');
    focused_date.setDate( focused_date.getDate() + 1);
    expect(input.element.value).toEqual(formatDate(focused_date));

    // add one week
    input.trigger('keydown.down');
    focused_date.setDate( focused_date.getDate() + 7);
    expect(input.element.value).toEqual(formatDate(focused_date));
  });

  // clicking a calendar day changes the dateSelected value
  it('clicking a calendar day changes the dateSelected value', () => {
    const wrapper = mount(AppDatepicker, {
      propsData: {
        value: todays_date
      },
      stubs: stubs
    });
    
    const input = wrapper.find({ ref: "input" });
    const calendar_container = wrapper.find({ ref: "calendar_container" });
    input.trigger("focus");
    let focused_date = parseDate(todays_date);
    calendar_container.find(".datepicker_day.is-selectable:not(.is-today)").trigger("click");
    expect(wrapper.vm.dateSelected).not.toEqual(focused_date);
  });
});