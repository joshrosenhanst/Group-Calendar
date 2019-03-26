import { shallowMount, mount } from '@vue/test-utils';
import AppDropdown from '../components/dropdown/AppDropdown.vue';

describe('AppDropdown.vue', () => {
  // check if the component is created
  it('is a Vue instance', () => {
    const wrapper = shallowMount(AppDropdown);
    expect(wrapper.isVueInstance()).toBeTruthy();
  });
});