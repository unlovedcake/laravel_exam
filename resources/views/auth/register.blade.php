<x-guest-layout>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <form action="{{ route('register') }}" method="POST" id="handleAjax">
        @csrf
        <div id="errors-list"></div>

        <!-- First Name -->
        <div>
            <x-input-label for="firstName" :value="__('FirstName')" />
            <x-text-input id="firstName" class="block mt-1 w-full" type="text" name="firstName" :value="old('firstName')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('firstName')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div>
            <x-input-label for="lastName" :value="__('LastName')" />
            <x-text-input id="lastName" class="block mt-1 w-full" type="text" name="lastName" :value="old('lastName')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('lastName')" class="mt-2" />
        </div>

        <!-- Contact Number -->
        <div>
            <x-input-label for="contactNumber" :value="__('Contact Number')" />
            <x-text-input id="contactNumber" class="block mt-1 w-full" type="text" name="contactNumber" :value="old('contactNumber')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('contactNumber')" class="mt-2" />
        </div>

        <!-- Contact Number -->
        <div>
            <x-input-label for="age" :value="__('Age')" />
            <x-text-input id="age" class="block mt-1 w-full" type="number" name="age" :value="old('age')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('age')" class="mt-2" />
        </div>



        <div>
            <x-input-label for="gender" :value="__('Gender')" />
            <select class="block mt-1 w-full" id="genderSelect" name="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button type="submit" class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script type="text/javascript">
        $(function() {

            /*------------------------------------------
            --------------------------------------------
            Submit Event
            --------------------------------------------
            --------------------------------------------*/
            $(document).on("submit", "#handleAjax", function() {
                var e = this;

                $(this).find("[type='submit']").html("Register...");

                $.ajax({
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $(e).find("[type='submit']").html("Register");

                        if (data.status) {
                            window.location = data.redirect;
                        } else {

                            $(".alert").remove();
                            $.each(data.errors, function(key, val) {
                                $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");

                            });

                        }

                    },

                });

                return false;
            });

        });
    </script>
</x-guest-layout>