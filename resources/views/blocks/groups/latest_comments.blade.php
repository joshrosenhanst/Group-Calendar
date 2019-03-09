<div class="card card-has_header">
  <div class="card_header">
    <h2>
      <span class="icon">@materialicon('comment-multiple')</span>
      <span>Latest Comments</span>
    </h2>
  </div>
  <div class="card_section latest_comments_section">
    @each('blocks.comments.list_item', $comments,'comment','blocks.comments.empty')
  </div>
</div>