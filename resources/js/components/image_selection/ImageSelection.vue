<template>
  <div class="field_body_image_selection"
  >

    <input type="hidden" 
      :name="input_name" 
      :id="input_id"
      v-model="selected_image_filename"
      value=""
    >

    <div class="field_image_display">
      <div class="image_display">
        <img :src="selected_image_src" alt="Selected Image">
      </div>
      <button class="button button-info button-inverted"
        v-on:click.prevent="openModal"
      >
        <material-icon name="image"></material-icon>
        <slot name="button_text">Select an Image</slot>
      </button>
    </div>

    <app-modal
      :active="modal_active"
      @close-modal="modal_active = false"
    >

      <h2 slot="title">
        <material-icon name="image"></material-icon>
        <span>Select an Image</span>
      </h2>

      <section class="modal_card_body" slot="body" ref="modal_body">
        <div class="gallery">

          <div class="gallery_image"
            tabindex="0"
            ref="default_option"
            :class=" { 'gallery_image-selected': (gallery_selection === null) }"
            @click="defaultSelection"
            @keydown.enter.prevent="defaultSelection"
            @keydown.space.prevent="defaultSelection"
          >
            <img :src="default_image" alt="Default Image">
          </div>

          <div class="gallery_image"
            tabindex="0"
            v-for="(image, index) in available_images"
            :key="index"
            :class=" { 'gallery_image-selected': (gallery_selection === image.filename) }"
            @click="gallerySelection(image.filename)"
            @keydown.enter.prevent="gallerySelection(image.filename)"
            @keydown.space.prevent="gallerySelection(image.filename)"
          >
            <img :src="image.src" :alt="image.alt">
          </div>

        </div>
        <div class="images_credit">
          <slot name="images_credit">
            Photos provided by <a href="https://www.pexels.com">Pexels</a>
          </slot>
        </div>
      </section>

      <div class="footer_buttons" slot="footer">

        <button class="button button-success button-inverted"
          @click.prevent="confirmSelection"
        >
          <material-icon name="check"></material-icon>
          <span>Select Image</span>
        </button>

        <button class="button button-cancel"
          @click.prevent="modal_active = false"
        >
          <material-icon name="cancel"></material-icon>
          <span>Cancel</span>
        </button>
      </div>
    </app-modal>
  </div>
</template>

<script>
import AppModal from '../modal/AppModal.vue';
import asset_url from '../../mixins/asset_url.js';
export default {
  mixins: [asset_url],
  components: {
    AppModal
  },
  data: function(){
    return {
      selected_image_filename: this.input_value || null,
      gallery_selection: this.input_value || null,
      modal_active: false
    }
  },
  props:{
    input_name: {
      type: String,
      default: "image_selection"
    },
    input_id: {
      type: String,
      default: "image_selection"
    },
    input_value: {
      type: String,
      default: null
    },
    available_images: Array,
    default_image: String,
    directory: String
  },
  methods: {
    gallerySelection(filename){
      this.gallery_selection = filename;
    },
    confirmSelection(){
      this.selected_image_filename = this.gallery_selection;
      this.modal_active = false;
    },
    defaultSelection(){
      this.gallery_selection = null;
    },
    openModal(){
      this.modal_active = true;
      this.$nextTick(() => {
        this.$refs.modal_body.scrollTop = 0;
        this.$refs.default_option.focus();
      });
    }
  },
  computed: {
    selected_image_src(){
      if(this.gallery_selection){
        return this.getAssetURL("/storage/"+this.directory+"/"+this.selected_image_filename);
      }else{
        return this.default_image;
      }
    }
  }
}
</script>
