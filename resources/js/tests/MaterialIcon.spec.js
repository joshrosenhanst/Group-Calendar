import { shallowMount, mount } from '@vue/test-utils';
import MaterialIcon from '../components/icons/MaterialIcon.vue';

describe('MaterialIcon.vue', () => {
  // check if the component is created
  it('is a Vue instance', () => {
    const wrapper = shallowMount(MaterialIcon, {
      propsData: {
        name: "alert"
      }
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });
});