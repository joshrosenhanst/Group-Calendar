
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('status-alert', require('./components/StatusAlert.vue').default);
Vue.component('app-dropdown', require('./components/AppDropdown.vue').default);
Vue.component('tab-wrapper', require('./components/tabs/TabWrapper.vue').default);
Vue.component('attendee-status', require('./components/AttendeeStatus.vue').default);
Vue.component('material-icon', require('./components/MaterialIcon.vue').default);
Vue.component('comments-card', require('./components/CommentsCard.vue').default);
Vue.component('attendees-card', require('./components/AttendeesCard.vue').default);
Vue.component('member-list', require('./components/MemberList.vue').default);
Vue.component('full-calendar', require('./components/FullCalendar.vue').default);