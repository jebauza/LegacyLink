{{-- ALERTS --}}

@if (session('message-success'))
<div class="alert alert-custom alert-notice alert-light-success fade show" role="alert">
    <div class="alert-icon"><i class="far fa-check-circle"></i></div>
    <div class="alert-text">{{ session('message-success') }}</div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
@elseif(session('message-warning'))
<div class="alert alert-custom alert-notice alert-light-warning fade show" role="alert">
    <div class="alert-icon"><i class="flaticon-warning"></i></div>
    <div class="alert-text">{{ session('message-warning') }}</div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
@elseif(session('message-error'))
<div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
    <div class="alert-icon"><i class="fas fa-ban"></i></div>
    <div class="alert-text">{{ session('message-error') }}</div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
@endif
