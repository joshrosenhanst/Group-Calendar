
{{-- New Comment Form --}}
<div class="card_section card_section-form card_section-new_comment">

    <div class="comment_avatar">
      <span class="preview_thumbnail">
        <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }} Avatar">
      </span>
    </div>

    <div class="comment_body">
      <form action="{{ $form_url }}" method="POST" class="form embedded_form comment_Form">
        @method('PUT')
        @csrf

        <div class="form_group {{ count($errors) ? 'form_group-error' : '' }}">
          <label for="comment_text" class="form_label">Leave a Comment</label>
          <textarea name="comment_text" id="comment_text" class="form_input form_input-small" placeholder="Leave a Comment..."></textarea>

          <div class="form_errors">
            @foreach($errors as $error)
              <div class="form_error" role="alert">{{ $error }}</div>
            @endforeach
          </div>
        </div>

        <div class="comment_form_footer button_group button_group-small">
          <button class="button button-link button-inverted" type="submit">
            <span class="icon">@materialicon('comment-check')</span>
            <span>Submit Comment</span>
          </button>
        </div>
      </form>
    </div>

  </div>