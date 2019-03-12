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
        v-on:click.prevent="modal_active = true"
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

      <template slot="body">
        <div class="gallery" slot="body">

          <div class="gallery_image"
            :class=" { 'gallery_image-selected': (gallery_selection === null) }"
            @click="defaultSelection"
          >
            <img :src="default_image" alt="Default Image">
          </div>

          <div class="gallery_image"
            v-for="(image, index) in available_images"
            :key="index"
            :class=" { 'gallery_image-selected': (gallery_selection === image.filename) }"
            @click="gallerySelection(image.filename)"
          >
            <img :src="image.src" :alt="image.alt">
          </div>

        </div>
        <div class="images_credit">
          <slot name="images_credit">
            Photos provided by <a href="https://www.pexels.com">Pexels</a>
          </slot>
        </div>
      </template>

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
export default {
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
    }
  },
  computed: {
    selected_image_src(){
      if(this.gallery_selection){
        return "/storage/"+this.directory+"/"+this.selected_image_filename;
      }else{
        return this.default_image;
      }
    }
  }
}
</script>
