<template>
  <div class="locationpicker"
    :class="{ 'locationpicker-has_selection': place_id, 'locationpicker-focused': isFocused  }"
  >
    <input type="text" ref="autocomplete" class="location_input form_input"
      :id="input_id"
      :name="input_name"
      :aria-label="input_label"
      :class="input_class"
      :placeholder="input_placeholder"
      :disabled="place_id"
      @focus="isFocused = true"
      @blur="isFocused = false"
    >
    <div class="selected_location" v-show="place_id">
      <div class="location_icon">
        <material-icon name="map-marker"></material-icon>
      </div>
      <div class="location_details">
        <div class="location_name">{{ name }}</div>
        <div class="location_formatted_address">{{ formatted_address }}</div>
        <a class="location_map_url" :href="map_url" target="_blank">View in Google Maps</a>
      </div>
      <div class="location_remove">
        <button class="button-icon" aria-label="Change Location" title="Change Location"
          v-on:click.prevent="removeSelectedLocation"
        >
          <material-icon name='close'></material-icon>
        </button>
      </div>
    </div>

    <input type="hidden" name="location[place_id]" :value="place_id"> 
    <input type="hidden" name="location[name]" :value="name"> 
    <input type="hidden" name="location[formatted_address]" :value="formatted_address"> 
    <input type="hidden" name="location[city]" :value="city"> 
    <input type="hidden" name="location[state]" :value="state">
    <input type="hidden" name="location[map_url]" :value="map_url">
    <input type="hidden" name="location[coordinates]" :value="coordinates">

  </div>
</template>

<script>
const ADDRESS_COMPONENTS = {
  street_number: 'long_name', //street number
  route: 'short_name', //street name
  locality: 'long_name', //town name
  sublocality: 'long_name', //town name
  sublocality_level_1: 'long_name', //town name
  administrative_area_level_3: 'long_name', //town name
  administrative_area_level_2: 'long_name', //county name
  administrative_area_level_1: 'short_name', //state name
  country: 'short_name', //country
  postal_code: 'long_name' //zip
};
export default {
  data: function(){
    return {
      isFocused: false,
      name: (this.selected_location ? this.selected_location.name : null),
      place_id: (this.selected_location ? this.selected_location.place_id : null),
      formatted_address: (this.selected_location ? this.selected_location.formatted_address : null),
      street_address: (this.selected_location ? this.selected_location.street_address : null),
      city: (this.selected_location ? this.selected_location.city : null),
      state: (this.selected_location ? this.selected_location.state : null),
      zip: (this.selected_location ? this.selected_location.zip : null),
      country: (this.selected_location ? this.selected_location.country : null),
      map_url: (this.selected_location ? this.selected_location.map_url : null),
      coordinates: (this.selected_location ? this.selected_location.coordinates : null)
    };
  },
  props: {
    input_name: {
      type: String,
      required: false
    },
    input_id: {
      type: String,
      required: false
    },
    input_class: {
      type: String,
      required: false
    },
    input_label: {
      type: String,
      required: false
    },
    input_placeholder: {
      type: String,
      required: false
    },
    selected_location: {
      type: Object,
      required: false
    }
  },
  methods: {
    onPlaceChanged(){
      let place = this.autocomplete.getPlace();

      if(!place.geometry){
        // no place entered
        this.clearLocationComponents();
      }else{
        this.setLocationComponents(place);
      }

    },
    removeSelectedLocation(){
      this.$refs.autocomplete.value = "";
      this.clearLocationComponents();
      this.$nextTick(()=>{
        this.$refs.autocomplete.focus();
      });
    },
    setLocationComponents(place){
      this.name = place.name;
      this.formatted_address = place.formatted_address;
      this.place_id = place.place_id;
      this.map_url = place.url;
      this.coordinates = place.geometry.location.lat() + "," + place.geometry.location.lng();

      let placeData = {};
      place.address_components.forEach((item) => {
        let type = item.types[0];
        if(ADDRESS_COMPONENTS[type]){
          placeData[type] = item[ADDRESS_COMPONENTS[type]];
        }
      });

      if(Object.keys(placeData).length){
        this.street_address = placeData['street_number'] + " " + placeData['route'];
        this.city = placeData['locality'] || placeData['sublocality'] || placeData['sublocality_level_1'] || placeData['administrative_area_level_3']
        this.state = placeData['administrative_area_level_1'];
        this.zip = placeData['postal_code'];
        this.country = placeData['country'];
      }

      this.isFocused = false;
    },
    clearLocationComponents(){
      this.formatted_address = null;
      this.name = null;
      this.place_id = null;
      this.street_address = null;
      this.city = null;
      this.state = null;
      this.zip = null;
      this.country = null;
      this.map_url = null;
      this.coordinates = null;
    }
  },
  mounted(){
    console.log(this.$refs.autocomplete, document.activeElement);
    this.autocomplete = new google.maps.places.Autocomplete(
      this.$refs.autocomplete, {types:[]}
    );
    this.autocomplete.addListener('place_changed', this.onPlaceChanged);
  }
}
</script>