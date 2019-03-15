
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
Vue.component('status-alert', require('./components/status/StatusAlert.vue').default);
Vue.component('notification-display', require('./components/notifications/NotificationDisplay.vue').default);
Vue.component('app-dropdown', require('./components/dropdown/AppDropdown.vue').default);
Vue.component('tab-wrapper', require('./components/tabs/TabWrapper.vue').default);
Vue.component('attendees-card', require('./components/attendees/AttendeesCard.vue').default);
Vue.component('attendee-status', require('./components/attendees/AttendeeStatus.vue').default);
Vue.component('material-icon', require('./components/icons/MaterialIcon.vue').default);
Vue.component('comments-card', require('./components/comments/CommentsCard.vue').default);
Vue.component('member-list', require('./components/members/MemberList.vue').default);
Vue.component('full-calendar', require('./components/calendar/FullCalendar.vue').default);
Vue.component('navbar-menu-button', require('./components/dropdown/NavbarMenuButton.vue').default);
Vue.component('sidebar-wrapper', require('./components/sidebar/SidebarWrapper.vue').default);
Vue.component('app-datepicker', require('./components/datepicker/AppDatepicker.vue').default);
Vue.component('app-timepicker', require('./components/timepicker/AppTimepicker.vue').default);
Vue.component('image-selection', require('./components/image_selection/ImageSelection.vue').default);
Vue.component('app-modal', require('./components/modal/AppModal.vue').default);
Vue.component('location-picker', require('./components/locationpicker/LocationPicker.vue').default);