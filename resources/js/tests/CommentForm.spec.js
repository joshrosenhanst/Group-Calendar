import { shallowMount, mount } from '@vue/test-utils';
import CommentForm from '../components/comments/CommentForm.vue';
import MaterialIcon from '../components/icons/MaterialIcon.vue';

const props = {
  text: "This is the default comment",
  id: 12,
  textarea_id: 'comment_textarea_12',
  label: 'Update Comment'
};
const stubs = {
  'material-icon': MaterialIcon
};

describe('CommentForm.vue', () => {
  // check if the component is created
  it('is a Vue instance', () => {
    const wrapper = shallowMount(CommentForm, {
      propsData: props,
      stubs: stubs
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });

  // submitting with no text will create a form_error
  it('submitting with no text will create a form_error', () => {
    const wrapper = shallowMount(CommentForm, {
      propsData: props,
      stubs: stubs
    });
    wrapper.vm.formText = '';
    wrapper.trigger('submit');
    expect(wrapper.find('.form_error').exists()).toBe(true);
  });

  // submitting with text will emit submit-comment
  it('submitting with text will emit submit-comment', () => {
    const wrapper = shallowMount(CommentForm, {
      propsData: props,
      stubs: stubs
    });
    wrapper.vm.formText = 'This is an updated comment!';
    wrapper.trigger('submit');
    expect(wrapper.find('form_errors').exists()).toBe(false);
    expect(wrapper.emitted('submit-comment')).toBeTruthy();
  });

  // clicking cancel will emit cancel-comment
  it('submitting with text will emit submit-comment', () => {
    const wrapper = shallowMount(CommentForm, {
      propsData: props,
      stubs: stubs
    });
    wrapper.find(".button-cancel").trigger("click");
    expect(wrapper.emitted('cancel-comment')).toBeTruthy();
  });
});