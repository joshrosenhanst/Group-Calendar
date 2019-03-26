import { shallowMount, mount } from '@vue/test-utils';
import CommentDeleteForm from '../components/comments/CommentDeleteForm.vue';
import MaterialIcon from '../components/icons/MaterialIcon.vue';

const stubs = {
  'material-icon': MaterialIcon
};

describe('CommentDeleteForm.vue', () => {
  // check if the component is created
  it('is a Vue instance', () => {
    const wrapper = shallowMount(CommentDeleteForm, {
      stubs: stubs
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });

  // submitting will emit submit-delete
  it('submitting will emit submit-delete', () => {
    const wrapper = shallowMount(CommentDeleteForm, {
      stubs: stubs
    });
    wrapper.trigger('submit');
    expect(wrapper.emitted('submit-delete')).toBeTruthy();
  });

  // clicking cancel will emit cancel-delete
  it('clicking cancel will emit cancel-delete', () => {
    const wrapper = shallowMount(CommentDeleteForm, {
      stubs: stubs
    });
    wrapper.find(".button-cancel").trigger("click");
    expect(wrapper.emitted('cancel-delete')).toBeTruthy();
  });
});