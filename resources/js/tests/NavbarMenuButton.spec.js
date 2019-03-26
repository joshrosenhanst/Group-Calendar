import { shallowMount, mount } from '@vue/test-utils';
import NavbarMenuButton from '../components/dropdown/NavbarMenuButton.vue';
import MaterialIcon from '../components/icons/MaterialIcon.vue';

const stubs = {
  'material-icon': MaterialIcon
};
const propsData = {
  whitelist: "#sidebars"
};

describe('NavbarMenuButton.vue', () => {
  // check if the component is created
  it('is a Vue instance', () => {
    const wrapper = shallowMount(NavbarMenuButton, {
      propsData,
      stubs
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });

  // click the navbar_menu_button emits navbar-menu-toggle
  it('click the navbar_menu_button emits navbar-menu-toggle', () => {
    const wrapper = shallowMount(NavbarMenuButton, {
      propsData,
      stubs
    });

    wrapper.find({ ref: "trigger" }).trigger("click");
    expect(wrapper.emitted('navbar-menu-toggle')).toBeTruthy();
  });
});