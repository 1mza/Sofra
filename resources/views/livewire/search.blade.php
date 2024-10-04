{{-- In work, do what you enjoy. --}}
<!-- Sidebar Search Form -->
<div class="form-inline w-100">
    <div class="input-group w-100 position-relative">
        <form method="get" action="{{ route('home') }}" class="w-100 d-flex position-relative">
            <input
                    wire:model.live="search"
                    name="search"
                    class="form-control w-100 bg-white form-control-sidebar border-2 rounded-md rounded-start"
                    placeholder="Search a user, seller, client"
                    aria-label="Search"
            />

        </form>
    </div>
    @if($users)
        <div class="mt-1 w-100 bg-white shadow-sm rounded">
            @foreach($users as $user)
                <div class="p-1 border-bottom">
                    <a class="text-blue hover:bg-gray-200 block p-3 rounded transition duration-200"
                       href="{{ route($user['type'] . 's.show', $user['model']) }}">
                        <span class="d-block font-weight-bold">
                            {{ $user['restaurant_name'] ?? $user['name'] }} - {{ $user['type'] }}
                        </span>
                        <small class="text-muted">{{ $user['email'] }}</small>
                    </a>
                </div>
            @endforeach
        </div>
    @elseif(strlen($this->search) >= 1 && count($users)==0)
        <div class="mt-1 w-100 bg-white shadow-sm rounded">
                <div class="p-3 border-bottom">
                    <span class="text-blue hover:bg-gray-200 block p-3 rounded transition duration-200"
                       >No Results found</span>
                </div>
        </div>
    @endif
</div>
