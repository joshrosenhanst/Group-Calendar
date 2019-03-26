import { shallowMount, mount } from '@vue/test-utils';
import ImageSelection from '../components/image_selection/ImageSelection.vue';
import AppModal from '../components/modal/AppModal.vue';
import MaterialIcon from '../components/icons/MaterialIcon.vue';

const available_images = [{"src":"http://groupcalendar.test/storage/default_headers/celebration-festival-fireworks-1387577.jpg","alt":"Preview Header 1","filename":"celebration-festival-fireworks-1387577.jpg"},{"src":"http://groupcalendar.test/storage/default_headers/dog-walk.jpg","alt":"Preview Header 2","filename":"dog-walk.jpg"},{"src":"http://groupcalendar.test/storage/default_headers/pexels-photo-1047442.jpg","alt":"Preview Header 3","filename":"pexels-photo-1047442.jpg"},{"src":"http://groupcalendar.test/storage/default_headers/pexels-photo-1190297.jpg","alt":"Preview Header 4","filename":"pexels-photo-1190297.jpg"},{"src":"http://groupcalendar.test/storage/default_headers/pexels-photo-1304473.jpg","alt":"Preview Header 5","filename":"pexels-photo-1304473.jpg"},{"src":"http://groupcalendar.test/storage/default_headers/pexels-photo-1353368.jpg","alt":"Preview Header 6","filename":"pexels-photo-1353368.jpg"},{"src":"http://groupcalendar.test/storage/default_headers/pexels-photo-1756338.jpg","alt":"Preview Header 7","filename":"pexels-photo-1756338.jpg"},{"src":"http://groupcalendar.test/storage/default_headers/pexels-photo-544961.jpg","alt":"Preview Header 8","filename":"pexels-photo-544961.jpg"},{"src":"http://groupcalendar.test/storage/default_headers/pexels-photo-57043.jpg","alt":"Preview Header 9","filename":"pexels-photo-57043.jpg"},{"src":"http://groupcalendar.test/storage/default_headers/pexels-photo-696218.jpg","alt":"Preview Header 10","filename":"pexels-photo-696218.jpg"},{"src":"http://groupcalendar.test/storage/default_headers/SW_Dylan+Rives.jpg","alt":"Preview Header 11","filename":"SW_Dylan+Rives.jpg"}];
const default_image = "http://groupcalendar.test/img/default_event_header.jpg";
const propsData = {
  available_images,
  directory: "default_headers",
  default_image
};
const stubs = {
  'material-icon': MaterialIcon
};

describe('ImageSelection.vue', () => {
  // check if the component is created
  it('is a Vue instance', () => {
    const wrapper = shallowMount(ImageSelection, {
      propsData,
      stubs
    });
    expect(wrapper.isVueInstance()).toBeTruthy();
  });

  // renders hidden input and selected image
  it('renders hidden input and selected image', () => {
    const wrapper = shallowMount(ImageSelection, {
      propsData,
      stubs
    });

    const input = wrapper.find("#image_selection");
    expect(input.element.value).toBeDefined();

    const img = wrapper.find(".image_display img");
    expect(img.exists()).toBe(true);
    expect(img.attributes('src')).toEqual(default_image);
  });

  // renders gallery images
  it('renders gallery images', () => {
    const wrapper = shallowMount(ImageSelection, {
      propsData,
      stubs
    });
    // should render .gallery_image class for each image, as well as the default image
    expect(wrapper.findAll('.gallery_image')).toHaveLength(available_images.length + 1);
  });

  // open modal button sets the app-modal to active
  it('renders hidden input and selected image', () => {
    const wrapper = shallowMount(ImageSelection, {
      propsData,
      stubs
    });

    wrapper.find(".field_image_display .button").trigger("click");
    expect(wrapper.find(AppModal).vm.active).toBe(true);
  });
  
  // selecting a gallery image and clicking submit will update the hidden input and selected image
  it('selecting a gallery image and clicking submit will update the hidden input and selected image', () => {
    const wrapper = shallowMount(ImageSelection, {
      propsData,
      stubs
    });
    
    // open the modal
    wrapper.find(".field_image_display .button").trigger("click");

    // select the first non-default image
    wrapper.findAll('.gallery_image').at(1).trigger("click");

    // click the submit button
    wrapper.find(".footer_buttons .button-success").trigger("click");

    const input = wrapper.find("#image_selection");
    expect(input.element.value).toEqual(available_images[0].filename);

    const img = wrapper.find(".image_display img");
    expect(img.exists()).toBe(true);
    const selected_image_src = "/storage/" + wrapper.vm.directory + "/" + available_images[0].filename;
    expect(img.attributes('src')).toEqual(selected_image_src);
  });
});