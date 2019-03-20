export default {
  props: {
    asset_url: {
      type: String,
      default: ''
    }
  },
  methods: {
    getAssetURL(path){
      return this.asset_url+path;
    }
  }
};