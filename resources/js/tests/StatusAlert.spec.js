import { shallowMount, mount } from '@vue/test-utils';
import StatusAlert from '../components/status/StatusAlert.vue';
import MaterialIcon from '../components/icons/MaterialIcon.vue';

describe('StatusAlert.vue', () => {
  it('is a Vue instance', () => {
    const wrapper = shallowMount(StatusAlert, {
      stubs: {
        'material-icon': MaterialIcon
      }
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });
});