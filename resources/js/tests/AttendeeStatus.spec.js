import { shallowMount } from '@vue/test-utils';
import AttendeeStatus from '../components/attendees/AttendeeStatus.vue';
import MaterialIcon from '../components/icons/MaterialIcon.vue';

const attendance_options = ['going','pending','interested','unavailable'];
const stubs = {
  'material-icon': MaterialIcon
};

describe('AttendeeStatus.vue', () => {
  // check if the component instance is created properly
  it('is a Vue instance', () => {
    const wrapper = shallowMount(AttendeeStatus, {
      propsData: { 'status': null },
      stubs: stubs
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });

  // event detail is rendered if status is set
  it('.event_detail is visible if props.status is set', () => {
    const wrapper = shallowMount(AttendeeStatus, {
      propsData: { 'status': 'pending' },
      stubs: stubs
    });
    expect(wrapper.find('.event_detail').exists()).toBe(true);
  });

  // event detail is not rendered if status is null
  it('.event_detail is not visible if props.status is null', () => {
    const wrapper = shallowMount(AttendeeStatus, {
      propsData: { 'status': null },
      stubs: stubs
    });
    expect(wrapper.find('.event_detail').exists()).toBe(false);
  });

  // renders the correct status text when props.status is set
  it('renders the correct status text when props.status is set', () => {
    const wrapper = shallowMount(AttendeeStatus, {
      propsData: { 'status': 'unavailable' },
      stubs: stubs
    });
    expect(wrapper.find('.status_content').html()).toContain('Unavailable');
  }); 

  // attend_buttons are visible if status prop is null
  it('attend_buttons are visible if props.status is null', () => {
    const wrapper = shallowMount(AttendeeStatus, {
      propsData: { 'status': null },
      stubs: stubs
    });
    expect(wrapper.find('.attend_buttons').isVisible()).toBe(true);
  });

  // attend_buttons are not visible if status prop is null
  it('attend_buttons are not visible if props.status is set', () => {
    const wrapper = shallowMount(AttendeeStatus, {
      propsData: { 'status': 'pending' },
      stubs: stubs
    });
    expect(wrapper.find('.attend_buttons').isVisible()).toBe(false);
  });

  // clicking #change_attendee_status should show .attend_buttons if props.status is set
  it('clicking #change_attendee_status should show .attend_buttons if props.status is set', () => {
    const wrapper = shallowMount(AttendeeStatus, {
      propsData: { 'status': 'pending' },
      stubs: stubs
    });
    wrapper.find('#change_attendee_status').trigger('click');
    expect(wrapper.find('.attend_buttons').isVisible()).toBe(true);
  });

  // clicking a button should emit the new status. new status should be a valid value.
  it('clicking a button should emit the new status. new status should be a valid value.', () => {
    const wrapper = shallowMount(AttendeeStatus, {
      propsData: { 'status': 'pending' },
      stubs: stubs
    });
    wrapper.find('.attend_buttons .button').trigger('click');
    expect(wrapper.emitted().update).toBeTruthy();
    expect(attendance_options).toContain(wrapper.emitted('update')[0][0]);
  });
});