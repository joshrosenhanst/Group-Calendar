import { shallowMount } from '@vue/test-utils';
import MemberList from '../components/members/MemberList.vue';
import MaterialIcon from '../components/icons/MaterialIcon.vue';

const members = [
  {"id":52,"name":"Larry Smith","email":"larry@smith.testdev","notifications_last_read_at":null,"avatar_url":null,"demo":false,"account_setup":false,"created_at":"2019-03-21 12:50:47","updated_at":"2019-03-21 12:50:47","avatar":"img/default_user_avatar.jpg","join_date":"5 days ago","pivot":{"group_id":2,"user_id":52,"creator_id":1,"created_at":"2019-03-21 12:50:47","updated_at":"2019-03-21 12:50:47"}}
];
const propsData = {
  members,
  type: "members",
  empty_text: "No Members"
};

describe('MemberList.vue', () => {
  it('is a Vue instance', () => {
    const wrapper = shallowMount(MemberList, {
      propsData,
      stubs: {
        'material-icon': MaterialIcon
      }
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });

  it('renders list_items for each member in props.members', () => {
    const wrapper = shallowMount(MemberList, {
      propsData,
      stubs: {
        'material-icon': MaterialIcon
      }
    });

    expect(wrapper.findAll('.list_item')).toHaveLength(members.length);
  });

  it('renders an empty display if props.members is empty', () => {
    const wrapper = shallowMount(MemberList, {
      propsData: { 
        members: [],
        type: "members",
        empty_text: "No Members"
       },
      stubs: {
        'material-icon': MaterialIcon
      }
    });

    expect(wrapper.html()).toContain("<h2>No Members</h2>");
  });
});