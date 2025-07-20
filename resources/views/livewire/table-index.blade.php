<div>


    <div class="mb-2">
        @if (session('deleted'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('deleted') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    @if (session('success') || session('updated') || session('deleted') || session('info'))
        <script>
            setTimeout(function() {
                let alerts = document.querySelectorAll('.alert-dismissible');
                alerts.forEach(function(alert) {
                    // Bootstrap 5: fade out and remove
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        </script>
    @endif

    <table class="table">
        <thead>
            <tr>

                @foreach ($columns as $column)
                    <th>{{ Illuminate\Support\Str::headline($column) ?? '-' }}</th>
                @endforeach

                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

            {{-- <td>
                @if ($staff->image_url)
                <img src="{{ $staff->image_url }}" width="50">
                @endif
            </td> --}}
            @forelse($items as $item)
                <tr>
                    @foreach ($columns as $column)
                        <td>

                            @if ($column === 'image_url' || $column === 'photo' || $column === 'avatar' || $column === 'image')
                                <img src="{{ $item->image_url }}" width="50"
                                    style="object-fit: cover; border-radius: 5px;">
                            @else
                                {{ $item->$column }}
                            @endif
                        </td>
                    @endforeach
                    <td class="text-center">
                        <div class="d-flex justify-content-center flex-wrap gap-2">
                            <a href="{{ route('admin.' . $modelRoute . '.edit', $item) }}"
                                class="btn btn-sm btn-warning">
                                Edit
                            </a>
                           @if($modelRoute =='staffs')
                            <a href="{{ route('admin.' . $modelRoute . '.show', $item) }}"
                                class="btn btn-sm btn-primary">
                                Show
                            </a>
                            @endif
                            {{-- <button wire:click="$dispatch('openModal', {{ $staff->id }}, '{{ get_class($staff) }}')"
                                class="btn btn-danger">
                                Delete
                            </button> --}}

                            <button wire:click="confirmDelete({{ $item->id }})" wire:key="{{ $item->id }}" x- data-bs-toggle="modal"
                                data-bs-target="#deleteModal" class="btn btn-sm btn-danger">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No {{ $modelRoute }} found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

     {{-- Modal for Delete Confirmation --}}
                <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true"
                    style="background: rgba(0,0,0,0.5);">
                    {{-- Add 'modal-dialog-centered' to this div --}}
                    <div class="modal-dialog modal-dialog-centered modal-delete-Modall">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this item?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Cancel
                                </button>
                                <button type="button" wire:click="delete()" class="btn btn-danger">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>



</div>

<script>
    window.addEventListener('close-modal', event => {
        var modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
        if (modal) {
            modal.hide();
        }
    });
</script>

{{-- <script>
    document.addEventListener('close-modal', function() {
        Livewire.on('closeModal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            if (modal) modal.hide();
        });
    });
</script> --}}
