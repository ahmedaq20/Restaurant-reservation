<div>
    <table class="table">
        <thead>
            <tr>
                
                @foreach($columns as $column)
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
                    @foreach($columns as $column)
                        <td>
                            
                              @if($column === 'image_url' || $column === 'photo' || $column === 'avatar' || $column === 'image')
                                <img src="{{ $item->image_url }}" width="50"  style="object-fit: cover; border-radius: 5px;">
                            @else
                                {{ $item->$column }}
                            @endif
                        </td>
                    @endforeach
                     <td class="text-center">
                        <div class="d-flex justify-content-center flex-wrap gap-2">
                            <a href="{{ route('admin.staffs.edit', $item) }}" class="btn btn-sm btn-warning">
                                Edit
                            </a>
                            <a href="{{ route('admin.staffs.show', $item) }}" class="btn btn-sm btn-primary">
                                Show
                            </a>
                            {{-- <button wire:click="$dispatch('openModal', {{ $staff->id }}, '{{ get_class($staff) }}')"
                                class="btn btn-danger">
                                Delete
                            </button> --}} 

                            <button wire:click="openModal('{{ $item->id }}')"
                                class="btn btn-sm btn-danger">
                                Delete
                            </button>
                        </div>
                    </td> 
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No staffs found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($confirming)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            {{-- Add 'modal-dialog-centered' to this div --}}
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Delete</h5>
                        <button type="button" wire:click="$set('confirming', false)" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this item?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="$set('confirming', false)"
                            class="btn btn-secondary">Cancel</button>
                        <button type="button" wire:click="delete" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- @if ($message)
    <div class="alert alert-success mt-2">
        {{ $message }}
    </div>
    @endif --}}
</div>