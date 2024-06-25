<section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form id="profile-form" method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="firstName" :value="__('FirstName')" />
            <input type="text" id="firstName" name="firstName" type="text" class="mt-1 block w-full" value="{{  $user->firstName }}" required autofocus autocomplete="firsName" />
            <x-input-error class="mt-2" :messages="$errors->get('firstName')" />
        </div>

        <div>
            <x-input-label for="lastName" :value="__('Last Name')" />
            <input type="text" id="lastName" name="lastName" type="text" class="mt-1 block w-full" value="{{ $user->lastName }}" required autofocus autocomplete="lasName" />
            <x-input-error class="mt-2" :messages="$errors->get('lastName')" />
        </div>

        <div>
            <x-input-label for="contactNumber" :value="__('Contact Number')" />
            <x-text-input id="contactNumber" name="contactNumber" type="text" class="mt-1 block w-full" value="{{ $user->contactNumber }}" required autofocus autocomplete="contactNumber" />
            <x-input-error class="mt-2" :messages="$errors->get('contactNumber')" />
        </div>

        <div>
            <x-input-label for="age" :value="__('Age')" />
            <x-text-input id="age" name="age" type="text" class="mt-1 block w-full" value="{{ $user->age }}" required autofocus autocomplete="age" />
            <x-input-error class="mt-2" :messages="$errors->get('age')" />
        </div>


        <div>
            <x-input-label for="gender" :value="__('Gender')" />
            <select class="block mt-1 w-full" id="genderSelect" name="gender">
                <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            $('#profile-form').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    type: "POST",
                    dataType: 'json',

                    success: function(response) {

                        if (response.status) {
                            toastr.success(response.message);
                        } else {
                            $.each(response.errors, function(key, val) {
                                toastr.error(response.errors);
                            });
                        }


                    },

                });
            });
        });
    </script>
</section>