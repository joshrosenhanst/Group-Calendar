<template>
  <div class="slider">

    <button class="slider_button slider_prev" aria-label="Slide left"
      v-bind:click="slideLeft"
    >
      <material-icon name="chevron-left"></material-icon>
    </button>

    <button class="slider_button slider_next" aria-label="Slide right"
      v-bind:click="slideRight"
    >
      <material-icon name="chevron-right"></material-icon>
    </button>

    <div class="slider_wrapper" ref="wrapper">

      <div class="slider_content" ref="inner" v-bind:style="{ transform: `translateX(${currentPosition})` }">
        <slot></slot>
      </div>

    </div>

  </div>
</template>

<script>
import debounce from '../utils/debounce.js';
export default {
  data: function(){
    return {
      wrapperWidth: 0,
      innerWidth: 0,
      currentPosition: 0,
    };
  },
  props:{
    gap: {
      type: Number,
      default: 15
    },
    slideDistance: {
      type: Number,
      default: 200
    }
  },
  methods: {
    slideLeft(){
      if(this.currentPosition + this.slideDistance > this.innerWidth){
        this.currentPosition = this.innerWidth;
      }else{
        this.currentPosition += this.slideDistance;
      }
    },
    slideRight(){
      if(this.currentPosition + this.slideDistance < 0){
        this.currentPosition = this.innerWidth;
      }else{
        this.currentPosition += this.slideDistance;
      }
    },
    setSliderWidths(){
      this.wrapperWidth = this.$refs.wrapper.clientWidth;
      this.innerWidth = 0;
      this.$refs.wrapper.children.array.forEach(element => {
        this.innerWidth += element.clientWidth + this.gap;
      });
      this.currentPosition = 0;
    },
    handleResize(){
      this.setSliderWidths();
    }
  },
  created(){
    document.addEventListener('resize', debounce(this.handleResize, 16));
    this.setSliderWidths();
  },
  destroyed(){
    document.removeEventListener('resize', debounce(this.handleResize, 16));
  }
}
</script>
