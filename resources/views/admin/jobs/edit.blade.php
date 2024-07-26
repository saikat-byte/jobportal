@extends('front.layouts.app')

@section('title', 'Admin-Dashboard')

@section('content')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.job') }}">Jobs</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.include.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('front.message')
                    <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card border-0 shadow mb-4 ">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Edit Job Details</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="title" class="mb-2">Title<span class="req">*</span></label>
                                        <input type="text" placeholder="Job Title" id="title" name="title"
                                            value="{{ $job->title }}"
                                            class="form-control  @error('title') is-invalid @enderror">
                                        @error('title')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="category" class="mb-2">Category<span class="req">*</span></label>
                                        <select name="category" id="category"
                                            class="form-control @error('category') is-invalid  @enderror">
                                            <option value="">Select a Category</option>
                                            @if ($categories->isNotEmpty())
                                                @foreach ($categories as $category)
                                                    <option {{ $job->category_id == $category->id ? 'selected' : '' }}
                                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('category')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="job_type" class="mb-2">Job Nature<span class="req">*</span></label>
                                        <select class="form-control @error('job_type') is-invalid @enderror" name="job_type"
                                            value="{{ old('job_type') }}" id="job_type">
                                            <option value="">Select Job Nature</option>
                                            @if ($jobTypes->isNotEmpty())
                                                @foreach ($jobTypes as $jobType)
                                                    <option {{ $job->job_type_id == $jobType->id ? 'selected' : '' }}
                                                        value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('job_type')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="vacancy" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input type="number" min="1" placeholder="Vacancy" id="vacancy"
                                            value="{{ $job->vacancy }}" name="vacancy"
                                            class="form-control  @error('vacancy') is-invalid @enderror">
                                        @error('vacancy')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="salary" class="mb-2">Salary</label>
                                        <input type="text" placeholder="Salary" id="salary" name="salary"
                                            value="{{ $job->salary }}" class="form-control">

                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="location" class="mb-2">Location<span class="req">*</span></label>
                                        <input type="text" placeholder="location" id="location" name="location"
                                            value="{{ $job->location }}"
                                            class="form-control @error('location') is-invalid @enderror">
                                        @error('location')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="mb-4 col-md-6">
                                        <div class="form-check form-switch">
                                            <input {{ $job->isFeatured == 1 ? 'checked' : '' }} class="form-check-input" type="checkbox" role="switch" name="isFeatured" value="1"
                                                id="isFeatured">
                                            <label class="form-check-label" for="isFeatured">Featured</label>
                                        </div>

                                    </div>
                                    <div class="mb-4 col-md-6">
                                        <div class="form-check-inline">
                                            <input  {{ $job->status == 1 ? 'checked' : '' }} class="form-check-input" type="radio" name="status" value="1"
                                                id="status_active">
                                            <label class="form-check-label" for="status_active">
                                                Active
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input  {{ $job->status == 0 ? 'checked' : '' }} class="form-check-input" type="radio" name="status" value="0"
                                                id="status_block" >
                                            <label class="form-check-label" for="status_block">
                                                Block
                                            </label>
                                        </div>
                                    </div>


                                </div>

                                <div class="mb-4">
                                    <label for="description" class="mb-2">Description<span
                                            class="req">*</span></label>
                                    <textarea class="textarea @error('description') is-invalid  @enderror" name="description" id="description"
                                        cols="5" rows="5" placeholder="Description">{{ $job->description }}</textarea>

                                    @error('description')
                                        <p class="invalid-feedback"> {{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="benefits" class="mb-2">Benefits</label>
                                    <textarea class="textarea" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{ $job->benefits }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="responsibility" class="mb-2">Responsibility</label>
                                    <textarea class="textarea" name="responsibility" id="responsibility" cols="5" rows="5"
                                        placeholder="Responsibility">{{ $job->responsibility }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="qualifications" class="mb-2">Qualifications</label>
                                    <textarea class="textarea" name="qualification" id="qualification" cols="5" rows="5"
                                        placeholder="Qualifications">{{ $job->qualification }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="experience" class="mb-2">Experience<span
                                            class="req">*</span></label>
                                    <select class="form-control @error('experience') is-invalid @enderror"
                                        name="experience" id="experience">
                                        <option value="1" {{ $job->experience == 1 ? 'selected' : '' }}>1 year
                                        </option>
                                        <option value="2" {{ $job->experience == 2 ? 'selected' : '' }}>2 years
                                        </option>
                                        <option value="3" {{ $job->experience == 3 ? 'selected' : '' }}>3 years
                                        </option>
                                        <option value="4" {{ $job->experience == 4 ? 'selected' : '' }}>4 years
                                        </option>
                                        <option value="5" {{ $job->experience == 5 ? 'selected' : '' }}>5 years
                                        </option>
                                        <option value="6" {{ $job->experience == 6 ? 'selected' : '' }}>6 years
                                        </option>
                                        <option value="7" {{ $job->experience == 7 ? 'selected' : '' }}>7 years
                                        </option>
                                        <option value="8" {{ $job->experience == 8 ? 'selected' : '' }}>8 years
                                        </option>
                                        <option value="9" {{ $job->experience == 9 ? 'selected' : '' }}>9 years
                                        </option>
                                        <option value="10" {{ $job->experience == 10 ? 'selected' : '' }}>10 years
                                        </option>
                                        <option value="10_plus" {{ $job->experience == '10_plus' ? 'selected' : '' }}>10+
                                            years</option>
                                    </select>
                                    @error('experience')
                                        <p class="invalid-feedback"> {{ $message }} </p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="keywords" class="mb-2">Keywords</label>
                                    <input type="text" placeholder="keywords" id="keywords" name="keywords"
                                        value="{{ $job->keywords }}" class="form-control">
                                </div>

                                <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="company_name" class="mb-2">Name<span
                                                class="req">*</span></label>
                                        <input type="text" placeholder="Company Name" id="company_name"
                                            value="{{ $job->company_name }}" name="company_name"
                                            class="form-control @error('company_name') is-invalid @enderror">

                                        @error('company_name')
                                            <p class="invalid-feedback"> {{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="company_location" class="mb-2">Location</label>
                                        <input type="text" placeholder="Location" id="company_location"
                                            value="{{ $job->company_location }}" name="company_location"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="website" class="mb-2">Website</label>
                                    <input type="text" placeholder="Website" id="website" name="company_website"
                                        value="{{ $job->company_website }}" class="form-control">
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update Job</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customjs')
    <script>
        function deleteUser(id) {
            if (confirm('Are you sure you want to delete?')) {
                $.ajax({
                    type: "delete",
                    url: "{{ route('admin.user.delete') }}",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        window.location.href = "{{ route('admin.users') }}"
                    }
                });
            }
        }
    </script>
@endsection
