<div class="card card-no_header">
  <div class="card_section-calendar">
    <full-calendar
      v-bind:events="events"
      @isset($mini) v-bind:mini="true" @endisset
    ></full-calendar>
  </div>
</div>