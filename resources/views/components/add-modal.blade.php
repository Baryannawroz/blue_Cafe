@props([
'title' => __('No title provided'), // Added translation helper
'fa' => 'bx bx-list-plus',
'btnText' => __('Actions'), // Added translation helper
'buttons' => true,
'id' => 0,
'modalSize' => 'lg', // Added configurable modal size
'submitText' => __('all.submit'), // Added customizable submit text
'closeText' => __('all.close') // Added customizable close text
])

<button type="button" {{ $attributes->merge(['class' => 'btn btn-primary']) }} // Added default button class
    data-bs-toggle="modal"
    data-bs-target="#addModal{{ $id }}"
    aria-label="{{ $title }}"
    >
    <i class="{{ $fa }} me-1"></i> {{ $btnText }}
</button>

<!-- Modal -->
<div class="modal fade modalBodyToMove" id="addModal{{ $id }}" tabindex="-1" aria-labelledby="modalTitle{{ $id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-{{ $modalSize }}">
        <div class="modal-content">
            <div class="modal-body p-0">
                <!-- Removed padding to let card handle it -->
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body">
                        <div class="card-title d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-primary" id="modalTitle{{ $id }}">
                                {{ $title }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="{{ $closeText }}"></button>
                        </div>
                        <hr>
                        {{ $slot }}
                    </div>
                </div>
            </div>

            @if($buttons)
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ $closeText }}
                </button>
                <button type="submit" class="btn btn-primary">
                    {{ $submitText }}
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Improved modal styling with CSS variables for easier customization */
    :root {
        --modal-max-height: 100vh;
        --modal-footer-height: 70px;
    }

    .modal-content {
        display: flex;
        flex-direction: column;
        max-height: var(--modal-max-height);
    }

    .modal-body {
        flex-grow: 1;
        overflow-y: auto;
        max-height: calc(var(--modal-max-height) - var(--modal-footer-height));
        padding: 0;
        /* Let inner card handle padding */
    }

    .modal-footer {
        flex-shrink: 0;
        background: white;
        /* Ensure footer has solid background */
        border-top: 1px solid #dee2e6;
        /* Add border if needed */
        padding: 1rem;
        /* Consistent padding */
    }

    /* Better spacing for the card inside modal */
    .modal-body .card {
        height: 100%;
    }
</style>
@endpush
