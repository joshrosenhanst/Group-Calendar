import { shallowMount } from '@vue/test-utils';
import AppModal from '../components/modal/AppModal.vue';
import MaterialIcon from '../components/icons/MaterialIcon.vue';

describe('AppModal.vue', () => {
  it('is a Vue instance', () => {
    const wrapper = shallowMount(AppModal, {
      stubs: {
        'material-icon': MaterialIcon
      }
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });

  // on click modal_background emit close-modal
  it('on click modal_background emit close-modal', () => {
    const wrapper = shallowMount(AppModal, {
      propsData: {
        active: true
      },
      stubs: {
        'material-icon': MaterialIcon
      }
    });

    // click modal_background
    wrapper.find(".modal_background").trigger("click");

    expect(wrapper.emitted('close-modal')).toBeTruthy();
  });

  
  // on click close button-icon emit close-modal
  it('on click close button-icon emit close-modal', () => {
    const wrapper = shallowMount(AppModal, {
      propsData: {
        active: true
      },
      stubs: {
        'material-icon': MaterialIcon
      }
    });

    // click modal_background
    wrapper.find(".modal_close .button-icon").trigger("click");

    expect(wrapper.emitted('close-modal')).toBeTruthy();
  });
});