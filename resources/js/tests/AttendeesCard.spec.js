import { shallowMount } from '@vue/test-utils';
import AttendeesCard from '../components/attendees/AttendeesCard.vue';
import MaterialIcon from '../components/icons/MaterialIcon.vue';

const attendees = [
  {id: 1, name: "Charles Test", avatar: "avatar_image1.png", pivot: {
    status: 'pending'
  }},
  {id: 2, name: "Maxine Test", avatar: "avatar_image2.png", pivot: {
    status: 'unavailable'
  }}
];

describe('AttendeesCard.vue', () => {
  it('is a Vue instance', () => {
    const wrapper = shallowMount(AttendeesCard, {
      propsData: { 'attendees': [] },
      stubs: {
        'material-icon': MaterialIcon
      }
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });

  it('renders list_items for each attendee in props.attendees', () => {

    const wrapper = shallowMount(AttendeesCard, {
      propsData: { attendees },
      stubs: {
        'material-icon': MaterialIcon
      }
    });

    expect(wrapper.findAll('.list_item')).toHaveLength(attendees.length);
  });

  it('renders an empty display if props.attendees is empty', () => {

    const wrapper = shallowMount(AttendeesCard, {
      propsData: { 'attendees': [] },
      stubs: {
        'material-icon': MaterialIcon
      }
    });

    expect(wrapper.html()).toContain('<h2>No Attendees</h2>');
  });
});