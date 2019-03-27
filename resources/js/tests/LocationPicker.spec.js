import { shallowMount, mount } from '@vue/test-utils';
import LocationPicker from '../components/locationpicker/LocationPicker.vue';
import MaterialIcon from '../components/icons/MaterialIcon.vue';
import { googleStub, place_data } from './helpers/google_stub.js';
import { identifier } from '@babel/types';

window.google = global.google = googleStub();

const propsData = {
  input_id: "locationpicker"
};
const stubs = {
  'material-icon': MaterialIcon
};


describe('LocationPicker.vue', () => {
  // check if the component is created
  it('is a Vue instance', () => {
    const wrapper = shallowMount(LocationPicker, {
      propsData,
      stubs
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });

  // set place should show .selected_location and update hidden input fields
  it('set place should show .selected_location and update hidden input fields', () => {
    const wrapper = shallowMount(LocationPicker, {
      propsData,
      stubs
    });
    wrapper.vm.setLocationComponents(place_data);
    expect(wrapper.classes('locationpicker-has_selection')).toBe(true);
    expect(wrapper.find(".selected_location").isVisible()).toBe(true);

    const hidden_inputs = wrapper.findAll("input[type='hidden']");
    hidden_inputs.wrappers.forEach(input => {
      expect(input.element.value).toBeDefined();
    });
  });

  // location_remove should hide .selected_location and clear hidden input fields
  it('location_remove should hide .selected_location and clear hidden input fields', () => {
    const wrapper = shallowMount(LocationPicker, {
      propsData,
      stubs
    });
    wrapper.vm.setLocationComponents(place_data);
    wrapper.find(".location_remove .button-icon").trigger("click");
    expect(wrapper.classes('locationpicker-has_selection')).toBe(false);
    expect(wrapper.find(".selected_location").isVisible()).toBe(false);

    const hidden_inputs = wrapper.findAll("input[type='hidden']");
    hidden_inputs.wrappers.forEach(input => {
      expect(input.element.value).toBeFalsy();
    });
  });
});