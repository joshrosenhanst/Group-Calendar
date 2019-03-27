import { shallowMount, mount } from '@vue/test-utils';
import TabWrapper from '../components/tabs/TabWrapper.vue';

const tabItems = [
  'first_tab', 'second_tab'
];
const propsData = {
  tabItems
};

const slots = {
  'first_tab': "<span>Tab 1</span>",
  'second_tab': "<span>Tab 2</span>"
};

describe('TabWrapper.vue', () => {
  it('is a Vue instance', () => {
    const wrapper = shallowMount(TabWrapper, {
      propsData
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });

  it('renders the tabs correctly', () => {
    const wrapper = shallowMount(TabWrapper, {
      propsData,
      slots
    });
    const tabs = wrapper.findAll("li a");
    expect(tabs).toHaveLength(tabItems.length);

    for(let i=0;i<tabs.length;i++){
      expect(tabs.wrappers[i].html()).toContain(slots[tabItems[i]]);
    }
  });

  it('properly sets the tab on selectTab', () => {
    const wrapper = shallowMount(TabWrapper, {
      propsData,
      slots
    });

    // click second tab
    wrapper.findAll("li").at(1).find("a").trigger("click");
    expect(wrapper.emitted('select-tab')).toBeTruthy();

    expect(wrapper.find(".tab_active").html()).toContain(slots["second_tab"]);
  });
});