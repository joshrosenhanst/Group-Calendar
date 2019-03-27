import { shallowMount, mount } from '@vue/test-utils';
import NotificationDisplay from '../components/notifications/NotificationDisplay.vue';
import MaterialIcon from '../components/icons/MaterialIcon.vue';

const notifications = [{"id":"c9079092-b5b7-4da1-b967-453876a76879","type":"App\\Notifications\\EventCreated","notifiable_type":"App\\Group","notifiable_id":2,"data":{"text":"<strong>Admin User</strong> created an event in <strong>Movie Club</strong>","url":"http://groupcalendar.test/events/25","creator_id":1,"icon":"calendar-plus"},"read_at":null,"created_at":"2019-03-26 21:01:08","updated_at":"2019-03-26 21:01:08","created_text":"1 second ago"}];

const propsData = {
  notifications,
  user_id: 1
};

describe('NotificationDisplay.vue', () => {
  it('is a Vue instance', () => {
    const wrapper = shallowMount(NotificationDisplay, {
      propsData,
      stubs: {
        'material-icon': MaterialIcon
      }
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });

  it('renders dropdown_items for each notification in props.notifications', () => {
    const wrapper = mount(NotificationDisplay, {
      propsData,
      stubs: {
        'material-icon': MaterialIcon
      }
    });

    expect(wrapper.findAll('.dropdown_items')).toHaveLength(notifications.length);
  });

  it('renders an empty display if props.notifications is empty', () => {
    const wrapper = shallowMount(NotificationDisplay, {
      propsData: { 
        notifications: [],
        user_id: 1
       },
      stubs: {
        'material-icon': MaterialIcon
      }
    });

    expect(wrapper.html()).toContain("<h2>No Unread Notifications</h2>");
  });
});