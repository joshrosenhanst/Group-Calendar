<div class="card" id="attendees">
  <div class="card_header">
    <h2>
      <span class="icon">@materialicon('account-multiple')</span>
      <span>Attendees</span>
    </h2>
  </div>
  <div class="card_section card_list">
    @each('blocks.attendees.list_item', $attendees, 'user', 'blocks.attendees.empty')
  </div>
</div>