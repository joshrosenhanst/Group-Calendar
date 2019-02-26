<div class="card card-no_header">
  <div class="card_section-calendar">
    <full-calendar
      v-bind:events="events"
      @isset($mini) mini="true" @endisset
    ></full-calendar>
  </div>
</div>