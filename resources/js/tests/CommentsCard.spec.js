import { shallowMount, mount } from '@vue/test-utils';
import CommentsCard from '../components/comments/CommentsCard.vue';
import MaterialIcon from '../components/icons/MaterialIcon.vue';

/* 
  Comments array: 2 comments created by Admin User (id=1), 1 comment created by Gideo Heathcote (id=32) 
*/
const comments = [
  {"id":79,"user_id":32,"text":"Gideon's comment.","commentable_type":"App\\Event","commentable_id":18,"created_at":"2019-03-26 13:25:04","updated_at":"2019-03-26 13:25:04","created_text":"1 second ago","updated_text":"1 second ago","edited":false,"user":{
    "id":32,"name":"Gideon Heathcote","email":"eldred.hayes@example.net","notifications_last_read_at":null,"avatar_url":"pexels-photo-1663417.jpg","demo":true,"account_setup":true,"created_at":"2019-03-18 14:42:30","updated_at":"2019-03-18 14:42:30","avatar":"storage/avatars/pexels-photo-1663417.jpg","join_date":null}
  },
  {"id":76,"user_id":1,"text":"this is a very long comment that ashoild wrap all the way around I am having trouble typing very quickly","commentable_type":"App\\Event","commentable_id":18,"created_at":"2019-03-21 21:24:01","updated_at":"2019-03-21 21:24:01","created_text":"4 days ago","updated_text":"4 days ago","edited":false,"user":{
    "id":1,"name":"Admin User","email":"admin@groupcalendar.test","notifications_last_read_at":"2019-03-22 15:30:44","avatar_url":null,"demo":false,"account_setup":true,"created_at":"2019-03-18 14:42:29","updated_at":"2019-03-22 15:30:44","avatar":"img/default_user_avatar.jpg","join_date":null}
  },
  {"id":75,"user_id":1,"text":"this is a comment","commentable_type":"App\\Event","commentable_id":18,"created_at":"2019-03-21 21:04:59","updated_at":"2019-03-21 21:04:59","created_text":"4 days ago","updated_text":"4 days ago","edited":false,"user":{
    "id":1,"name":"Admin User","email":"admin@groupcalendar.test","notifications_last_read_at":"2019-03-22 15:30:44","avatar_url":null,"demo":false,"account_setup":true,"created_at":"2019-03-18 14:42:29","updated_at":"2019-03-22 15:30:44","avatar":"img/default_user_avatar.jpg","join_date":null}
  }
];
/*
  auth_user: Dr. Norbert Cummerata (id=6), creator of 0 comments in comments array.
*/
const auth_user = {"id":6,"name":"Dr. Norbert Cummerata","email":"parker65@example.org","notifications_last_read_at":null,"avatar_url":"luxury-yacht-boat-speed-water-163236.jpg","demo":true,"account_setup":true,"created_at":"2019-03-18 14:42:29","updated_at":"2019-03-18 14:42:29","avatar":"storage/avatars/luxury-yacht-boat-speed-water-163236.jpg","join_date":null};

/*
  comment_creator: Admin User (id=1), creator of 2 comments
*/
const comment_creator = {
  "id":1,"name":"Admin User","email":"admin@groupcalendar.test","notifications_last_read_at":"2019-03-22 15:30:44","avatar_url":null,"demo":false,"account_setup":true,"created_at":"2019-03-18 14:42:29","updated_at":"2019-03-22 15:30:44","avatar":"img/default_user_avatar.jpg","join_date":null
};

const stubs = {
  'material-icon': MaterialIcon
};
const defaults_no_comments = {
  'comments': [],
  'title': null,
  'asset_url': 'http://groupcalendar.test',
  'user': auth_user,
  'user_admin': false
};
const defaults_with_comments = {
  'comments': comments,
  'title': null,
  'asset_url': 'http://groupcalendar.test',
  'user': auth_user,
  'user_admin': false
};
const defaults_with_comments_admin = {
  'comments': comments,
  'title': null,
  'asset_url': 'http://groupcalendar.test',
  'user': auth_user,
  'user_admin': true
};
const defaults_with_comments_creator = {
  'comments': comments,
  'title': null,
  'asset_url': 'http://groupcalendar.test',
  'user': comment_creator,
  'user_admin': false
};

describe('CommentsCard.vue', () => {
  // check if the component is created
  it('is a Vue instance', () => {
    const wrapper = shallowMount(CommentsCard, {
      propsData: defaults_no_comments,
      stubs: stubs
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });

  // renders .list_items for each comment in props.comments
  it('renders list_items for each comment in props.comments', () => {
    const wrapper = mount(CommentsCard, {
      propsData: defaults_with_comments,
      stubs: stubs
    });

    expect(wrapper.findAll('.list_item')).toHaveLength(comments.length);
  });

  // renders an empty display if props.comments is empty
  it('renders an empty display if props.comments is empty', () => {
    const wrapper = shallowMount(CommentsCard, {
      propsData: defaults_no_comments,
      stubs: stubs
    });

    expect(wrapper.html()).toContain('<h2>No Comments Found</h2>');
  });

  // does not render edit and delete links for non admin/non creator
  it('does not render edit and delete links for non admin/non creator', () => {
    const wrapper = mount(CommentsCard, {
      propsData: defaults_with_comments,
      stubs: stubs
    });
    
    expect(wrapper.findAll('[href="#edit_comment"]')).toHaveLength(0);
    expect(wrapper.findAll('[href="#delete_comment"]')).toHaveLength(0);
  });

  // renders edit and delete links on all comments for admin user
  it('renders edit and delete links on all comments for admin user', () => {
    const wrapper = mount(CommentsCard, {
      propsData: defaults_with_comments_admin,
      stubs: stubs
    });
    
    expect(wrapper.findAll('[href="#edit_comment"]')).toHaveLength(comments.length);
    expect(wrapper.findAll('[href="#delete_comment"]')).toHaveLength(comments.length);
  });

  // renders edit and delete links on own comments for comment creator
  it('renders edit and delete links on own comments for comment creator', () => {
    const wrapper = mount(CommentsCard, {
      propsData: defaults_with_comments_creator,
      stubs: stubs
    });

    const own_comments = comments.filter(comment => comment.user_id === defaults_with_comments_creator.user.id);
    
    expect(wrapper.findAll('[href="#edit_comment"]')).toHaveLength(own_comments.length);
    expect(wrapper.findAll('[href="#delete_comment"]')).toHaveLength(own_comments.length);
  });
});