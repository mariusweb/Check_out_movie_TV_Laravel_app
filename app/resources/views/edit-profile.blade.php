
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="wrapper bg-white mt-sm-5">
        <h4 class="pb-4 border-bottom">Account settings</h4>
        <div class="d-flex align-items-start py-3 border-bottom"> <img src="{{ asset('/storage/' . $avatar['id'] . '/' . $avatar['file_name']) }}" class="img" alt="">
            <div class="pl-sm-4 pl-2" id="img-section">
                <b>Profile Photo</b>
            </div>
        </div>
        <form class="py-2" method="POST" action="{{ route('profile.update', auth()->user()->getAuthIdentifier()) }}">
            @method('PUT')
            @csrf
            <div class="row py-2">
                <div class="col"> <label for="firstname">User Name</label> <input type="text" name="name" class="bg-light form-control" value="{{auth()->user()->name}}"> </div>
            </div>
            <div class="row py-2">
                <div class="col"> <label for="email">Email Address</label> <input type="text" name="email" class="bg-light form-control" value="{{auth()->user()->email}}"> </div>
            </div>
            <div class="row py-2">
                <div class="col"> <label for="avatar">Upload new profile image</label> <input id="avatar" name="avatar" type="file" > </div>
            </div>
            <div class="py-3 pb-4">
                <input type="submit" class="btn btn-primary mr-3" value="Save Changes" />
            </div>
        </form>
    </div>
    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const inputElement = document.querySelector('input[id="avatar"]');
                const pond = FilePond.create(inputElement);
                FilePond.setOptions({
                    server: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        process: {
                            url: '{{ route('filepond.store') }}',
                        },
                        revert: {
                            url: '{{ route('filepond.delete') }}',
                        }
                    }
                });
            });
        </script>
    @endsection
</x-app-layout>
