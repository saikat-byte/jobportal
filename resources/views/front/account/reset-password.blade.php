@extends('front.layouts.app')

@section('title', 'Reset password')

@section('content')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">


                <div class="col-md-5">
                    @if (Session()->has('success'))

                    <div class="alert alert-success">{{ Session()->get('success') }}</div>
                    @endif

                    @if (Session()->has('error'))
                    <div class="alert alert-danger">{{ Session()->get('error') }}</div>
                    @endif

                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Reset password</h1>
                        <form action="{{ route('account.process.password') }}" method="post">
                            @csrf
                            <input type="hidden" name="token" value="{{ $tokenString }}">
                            <div class="mb-3">
                                <label for="" class="mb-2">New password*</label>
                                <input type="password" name="new_password" id="new_password" value="{{ old('new_password') }}" class="form-control @error('new_password') is-invalid @enderror"
                                    placeholder="New password">

                                    @error('new_password')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="mb-2">Confirm password*</label>
                                <input type="password" name="confirm_password" id="confirm_password" value="{{ old('confirm_password') }}" class="form-control @error('confirm_password') is-invalid @enderror"
                                    placeholder="Confirm password">

                                    @error('confirm_password')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                            </div>
                            <div class="justify-content-between d-flex">
                                <button class="btn btn-primary mt-2">Submit </button>
                            </div>
                        </form>
                    </div>
                    <div class="mt-4 text-center">
                        <p>If you allready have an account. <a href="{{ route('account.login') }}">Back to login</a></p>
                    </div>
                </div>
            </div>
            <div class="py-lg-5">&nbsp;</div>
        </div>
    </section>
@endsection
