<div class="card card-has_header comments_card">
  <div class="card_header">
    <h2>
      <span class="icon">@materialicon('comment-multiple')</span>
      <span>{{ $title }}</span>
    </h2>
  </div>

  {{-- List of Comments --}}
  <div class="card_section comments_section card_list card_list-comments">
    @if(count($comments))
      @foreach($comments as $comment)
        <div class="list_item comment_display">

          {{-- Comment User Avatar or default avatar --}}
          <div class="comment_avatar">
            @if($comment->user)
            <a href="{{ route('users.view', ['user'=>$comment->user]) }}" class="preview_thumbnail">
              <img src="{{ asset($comment->user->avatar) }}" alt="{{ $comment->user->name }} Avatar">
            </a>
            @else
            <span class="preview_thumbnail">
              <img src="{{ asset('img/default_user_avatar.jpg') }}" alt="Default User Avatar">
            </span>
            @endif
          </div>

          <div class="comment_body">
             
            {{-- Comment meta info: user name, created date --}}
            <div class="comment_meta">
              @if($comment->user)
              <a href="{{ route('users.view', ['user'=>$comment->user]) }}" class="comment_user_name">{{ $comment->user->name }}</a>
              @else
              <span class="comment_user_name comment_user_default">Deleted User</span>
              @endif

              <span class="comment_date" title="{{ $comment->created_at }}">{{ $comment->created_text }}</span>
            </div>

            <div class="comment_text">
              <div>{{ $comment->text }}</div>
              @if($comment->edited)
                <div class="comment_edited" title="{{ $comment->updated_at }}">Edited {{ $comment->updated_text }}</div>
              @endif
            </div>
          </div>

        </div>
      @endforeach
    @else
      @component('components.empty', ['icon'=>'comment-question-outline','class'=>'list_empty'])
        No Comments Found
      @endcomponent
    @endif
  </div>

  @isset($form_url)
    @include('blocks.comments.new_comment_form', [
      'form_url' => $form_url
    ])
  @endisset

</div>