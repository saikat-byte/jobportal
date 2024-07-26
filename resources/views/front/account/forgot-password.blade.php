@extends('front.layouts.app')

@section('title', 'forgot password')

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
                        <h1 class="h3">Forgot password</h1>
                        <form action="{{ route('account.process.forgotPassword') }}" method="post">

                            @csrf
                            <div class="mb-3">
                                <label for="" class="mb-2">Email*</label>
                                <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror"
                                    placeholder="example@example.com">

                                    @error('email')
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
