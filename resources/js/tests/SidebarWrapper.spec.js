import { shallowMount, mount } from '@vue/test-utils';
import SidebarWrapper from '../components/sidebar/SidebarWrapper.vue';

describe('SidebarWrapper.vue', () => {
  it('is a Vue instance', () => {
    const wrapper = shallowMount(SidebarWrapper);
    expect(wrapper.isVueInstance()).toBeTruthy();
  });

  it('has sidebars-open class when active is true', () => {
    const wrapper = shallowMount(SidebarWrapper, {
      propsData: { 
        active: true
      }
    });

    expect(wrapper.classes('sidebars-open')).toBe(true);
  });
});