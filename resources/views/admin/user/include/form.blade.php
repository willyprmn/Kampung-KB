@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush

<div class="row row-cols-2">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Informasi Umum</div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="email"
                        class="form-label @error('email') text-danger @enderror">
                        Email/Username
                    </label>
                    {{ Form::text(
                        'email',
                        $user->email ?? null,
                        ['class' => $errors->has('email') ? 'is-invalid form-control' : 'form-control']
                    ) }}
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone"
                        class="form-label @error('phone') text-danger @enderror">
                        No. Telp
                    </label>
                    {{ Form::text(
                        'phone',
                        $user->phone ?? null,
                        ['class' => $errors->has('phone') ? 'is-invalid form-control' : 'form-control']
                    ) }}
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                @if (empty($user))
                    <div class="form-group">
                        <label for="password"
                            class="form-label @error('password') text-danger @enderror">
                            Password
                        </label>
                        <div class="input-group mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            <span class="input-group-text">
                                <i class="far fa-eye" id="togglePassword"style="cursor: pointer"></i>
                            </span>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation"
                            class="form-label @error('password_confirmation') text-danger @enderror">
                            Konfirmasi Password
                        </label>
                        <div class="input-group mb-3">
                            <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password">
                            <span class="input-group-text">
                                <i class="far fa-eye" id="togglePasswordConfirm"style="cursor: pointer"></i>
                            </span>
                        </div>
                        @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                @endif

                <div class="form-group">
                    <label for="name" class="form-label">Roles</label>
                    <select id="roles" name="roles[]" class="duallistbox" multiple="multiple">
                        @foreach($roles as $id => $name)
                            <option
                                @switch(true)
                                    @case(!empty(old("roles")) && in_array($id, old('roles'))) selected @break
                                    @case(!empty($user->roles) && $user->roles->contains($id)) selected @break
                                @endswitch
                                value="{{ $id }}">
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="name" class="form-label">Status</label>
                    <div class="icheck-primary d-inline">
                        {{ Form::radio(
                            'is_active',
                            1,
                            (!empty($user) && $user->is_active) ?? null,
                            ['id' => 'is_active_ada']
                        ) }}
                        <label for="is_active_ada">Aktif</label>
                    </div>
                    <div class="icheck-danger d-inline">
                        {{ Form::radio(
                            'is_active',
                            0,
                            (isset($user)) && (bool) $user->is_active === false,
                            ['id' => 'is_active_tidak']
                        ) }}
                        <label for="is_active_tidak">Tidak Aktif</label>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col">
        <x-form.regional-select :client="$user ?? null" />
    </div>
</div>


@push('scripts')
    <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <script>
        $('.duallistbox').bootstrapDualListbox();
        $(() => {
            const togglePassword = document.querySelector("#togglePassword");
            const password = document.querySelector("#password");

            togglePassword.addEventListener("click", function () {
            
                // toggle the type attribute
                const type = password.getAttribute("type") === "password" ? "text" : "password";
                password.setAttribute("type", type);
                // toggle the eye icon
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            const passwordConfirm = document.querySelector("#password_confirmation");

            togglePasswordConfirm.addEventListener("click", function () {
            
                // toggle the type attribute
                const type = passwordConfirm.getAttribute("type") === "password" ? "text" : "password";
                passwordConfirm.setAttribute("type", type);
                // toggle the eye icon
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
@endpush