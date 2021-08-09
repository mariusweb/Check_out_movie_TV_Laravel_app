<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users from '. $search ) }}
            </h2>
            <form method="GET" action="{{ route('profile.search') }}">
                @method('GET')
                @csrf
                <div class="input-group rounded">
                    <input type="search" class="form-control rounded" name="search" placeholder="Search for people" aria-label="Search"
                           aria-describedby="search-addon"/>
                    <button type="submit" class="input-group-text border-0 bg-white" id="search-addon">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
        </div>

    </x-slot>

    <div class="container">
        <ul class="timeline">
            @isset($users)
                @foreach($users as $user)
                    <li>
                        <!-- end timeline-time -->
                        <!-- begin timeline-icon -->
                        <div class="timeline-icon">
                            <a href="{{ route( 'profile.show', $user['id'] ) }}">&nbsp;</a>
                        </div>
                        <!-- end timeline-icon -->
                        <!-- begin timeline-body -->
                        <div class="timeline-body d-flex justify-content-between">
                            <div class="timeline-header border-bottom-0">
                                <span class="userimage"><img src="{{ asset('/storage/' . $user['folder_id'] . '/' . $user['file_name']) }}" alt=""></span>
                                <span class="username"><a href="{{ route( 'profile.show', $user['id'] ) }}">{{ $user['name'] }}</a> <small></small></span>

                            </div>
                            <div>
                                @switch($user['id'])
                                    @case(auth()->user()->getAuthIdentifier())
                                    <p>You</p>
                                    @break
                                    @default
                                    @switch($user['following'])
                                        @case(true)
                                        <a href="{{ route('profile.unfollow', $user['id']) }}" class="btn btn-sm btn-info mb-2">Unfollow</a>
                                        @break
                                        @default
                                        <a href="{{ route('profile.follow', $user['id']) }}" class="btn btn-sm btn-info mb-2">Follow</a>
                                    @endswitch
                                @endswitch
                            </div>
                        </div>
                        <!-- end timeline-body -->
                    </li>
                @endforeach
            @endisset
            <li>
                <!-- begin timeline-icon -->
                <div class="timeline-icon">
                    <a href="javascript:;">&nbsp;</a>
                </div>
                <!-- end timeline-icon -->
                <!-- begin timeline-body -->
                <div class="timeline-body">
                    Loading...
                </div>
                <!-- begin timeline-body -->
            </li>
        </ul>
    </div>
</x-app-layout>
