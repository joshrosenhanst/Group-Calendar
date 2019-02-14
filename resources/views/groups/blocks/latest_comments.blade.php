<div class="card">
  <div class="card_header">
    <h2>
      <span class="icon">@materialicon('comment-multiple')</span>
      <span>Latest Comments</span>
    </h2>
  </div>
  <div class="card_section">
    @include('comments.list', ['comments'=>$comments])
  </div>
</div>