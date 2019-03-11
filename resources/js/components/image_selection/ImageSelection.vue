<template>
  <div class="field_body_image_selection"
    @close-modal="modal_active = false"
  >

    <input type="hidden" 
      :name="input_name" 
      :id="input_id"
      :v-model="selected_image"
    >

    <div class="field_image_display">
      <img :src="selected_image" alt="Selected Image">
      <button class="button button-info button-inverted"
        v-on:click.prevent="modal_active = true"
      >
        <material-icon name="image"></material-icon>
        <slot name="button_text">Select an Image</slot>
      </button>
    </div>

    <app-modal
      :active="modal_active"
    >

      <h2 slot="title">
        <material-icon name="image"></material-icon>
        <span>Select an Image</span>
      </h2>

      <div class="gallery" slot="body">

        <div class="gallery_image"
          v-for="(image, index) in available_images"
          :key="index"
          :class=" { 'gallery_image-selected': (selected_image === image.src) }"
          @click="gallerySelection(image.src)"
        >
          <img :src="image.src" :alt="image.alt">
        </div>

        <div class="footer_buttons" slot="footer">

          <button class="button button-success button-inverted"
            @click.prevent="selectImage"
          >
            <material-icon name="check"></material-icon>
            <span>Select Image</span>
          </button>

          <button class="button button-cancel"
            @click="modal_active = false"
          >
            <material-icon name="cancel"></material-icon>
            <span>Cancel</span>
          </button>
        </div>

      </div>
    </app-modal>
  </div>
</template>

<script>
export default {
  data: function(){
    return {
      selected_image: this.input_value || null,
      gallery_selection: null,
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
    available_images: Array
  },
  method: {
    gallerySelection(image){
      this.gallery_selection = image;
    },
    selectImage(image){
      this.selected_image = this.gallery_selection;
    }
  }
}
</script>
